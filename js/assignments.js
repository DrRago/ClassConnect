function deleteAssignment(e, sessionID) {
    if (confirm("Are you sure that you want to delete this assignment?")) {
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_assignment.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "7a8151f444604f8244809e8da59917d87fafe8330705184948c3f791cb8072f5f247096988a1a022f52af1baef7c133a39ea09aab76a1735b97fe77b0f865139") {
                    $("#" + e.getAttribute("content")).children('td')
                        .animate({padding: 0})
                        .wrapInner('<div />')
                        .children()
                        .slideUp("slow", function () {
                            $(this).closest('tr').remove();
                        });
                }
            }
        });
    }
    return false;
}

/* Edit assignment */
function editAssignment(e, sessionID) {
    $(".mask").show();
    $(".edit_form").show();
    loadContents(e.closest("tr").getAttribute("id"), sessionID)
}

function loadContents(id, sessionID) {
    $.ajax({
        type: 'POST',
        url: '../scripts/get_assignment.php',
        data: "id=" + id + "&validation=" + sessionID,
        success: function (data) {
            data = data.slice(1).slice(0, -1);
            var obj = jQuery.parseJSON(data);
            $(".edit_form #id").val(obj.id);
            $(".edit_form #lesson_in").val(obj.lesson);
            $(".edit_form #exercises_in").val(obj.exercises);
            $(".edit_form #date_in").val(obj.date);
            $(".edit_form .input-div").fadeIn();
            $(".edit_form .fa-spin").hide();
        },
        error: function () {
            raiseTiemout();
        },
        timeout: 10000
    });
}

$(".edit_form").submit(function () {
    $(".edit_form .input-div").fadeOut();
    setTimeout(function () {
        $(".edit_form .fa-spin").show();
    }, 400);

    setTimeout(function () {
        var inputs = $(".edit_form .input-div");

        var id = inputs.find("#id").val();
        var lesson = inputs.find("#lesson_in").val();
        var exercises = inputs.find("#exercises_in").val();
        var date = inputs.find("#date_in").val();

        $.ajax({
            type: 'POST',
            url: '../scripts/update_assignment.php',
            data: "id=" + id + "&lesson=" + lesson + "&exercises=" + exercises + "&date=" + date + "&validation=" + inputs.find("#session").val(),
            success: function (data) {
                $("#status").removeClass("fa-refresh fa-spin");

                if (data == "bdec0ac5c069dd4899e2bf43dc43f4639218a05bbf43f165fd0e80dfe729d118b820551c81bf0308e225a9125ab44823fe89406f56c1a680dad7ecccf631e63c") {
                    $("#status").addClass("fa-times");
                } else {
                    $("#status").addClass("fa-check");

                    var changedRow = $(".assignment_tbl #" + id);
                    changedRow.find(".lessonName").html(lesson);
                    changedRow.find(".exercise").html(exercises);
                    changedRow.find(".assignmentDate").html(date);

                    setTimeout(function () {
                        changedRow.addClass("changed");
                        exitEdit();
                        setTimeout(function () {
                            $("#status").removeClass("fa-times fa-check");
                            $("#status").addClass("fa-refresh fa-spin");
                        }, 1000);
                    }, 1000);

                    setTimeout(function () {
                        changedRow.removeClass("changed");
                    }, 5000);
                }
            },
            error: function () {
                raiseTiemout();
            },
            timeout: 10000
        });
    }, 500);
    return false;
});