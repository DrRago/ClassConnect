function deleteExam(e, sessionID) {
    if (confirm("Are you sure that you want to delete this Exam?")) {
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_exam.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "a4d6b3047af2c2538b883473b4595bf838f93aed458d89734c10f8e0a05d165315287426d2dd121be73528e27b4838f6d31bd0190e3951ee7b8ba6f68e3f887b") {
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

/* Edit exam */
function editExam(e, sessionID) {
    $(".mask").show();
    $(".edit_form").show();
    loadContents(e.closest("tr").getAttribute("id"), sessionID)
}

function loadContents(id, sessionID) {
    $.ajax({
        type: 'POST',
        url: '../scripts/get_exam.php',
        data: "id=" + id + "&validation=" + sessionID,
        success: function (data) {
            data = data.slice(1).slice(0, -1);
            var obj = jQuery.parseJSON(data);
            $(".edit_form #id").val(obj.id);
            $(".edit_form #lesson_in").val(obj.lesson);
            $(".edit_form #topics_in").val(obj.topics);
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
        var inputs = $(".input-div");

        var id = inputs.find("#id").val();
        var lesson = inputs.find("#lesson_in").val();
        var topics = inputs.find("#topics_in").val();
        var date = inputs.find("#date_in").val();

        $.ajax({
            type: 'POST',
            url: '../scripts/update_exam.php',
            data: "id=" + id + "&lesson=" + lesson + "&topics=" + topics + "&date=" + date + "&validation=" + inputs.find("#session").val(),
            success: function (data) {
                $("#status").removeClass("fa-refresh fa-spin");

                if (data == "bdec0ac5c069dd4899e2bf43dc43f4639218a05bbf43f165fd0e80dfe729d118b820551c81bf0308e225a9125ab44823fe89406f56c1a680dad7ecccf631e63c") {
                    $("#status").addClass("fa-times");
                } else {
                    $("#status").addClass("fa-check");

                    var changedRow = $(".examList #" + id);
                    changedRow.find(".lessonName").html(lesson);

                    const regex = /(https?|ftp):\/\/(-\.)?([^\s/?\.#-]+\.?)+(\/[^\s]*)?$/i;

                    if(regex.exec(topics)) {
                        changedRow.find(".topics").html("<a href='" + topics + "' target='_blank'>Click Here</a>");
                    } else {
                        changedRow.find(".topics").html(topics);
                    }

                    var res = date.split("-");

                    var d = new Date();
                    d.setFullYear(parseInt(res[0]));
                    d.setMonth(parseInt(res[1]) - 1);
                    d.setDate(parseInt(res[2]));

                    date = d.toLocaleDateString();

                    changedRow.find(".examDate").html(date);

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