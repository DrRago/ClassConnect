function deleteEvent(e, sessionID) {
    if (confirm("Are you sure that you want to delete this event?")) {
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_event.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "28f9026632f87cf81ab4ae6752abd86cb5740d06dad1718db99cce25e66eaa81ab4ccdb300e8c3d8d3dcae648d794fbd3e79e4266a2a4cdedf54015b0750fa7f") {
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

/* Edit event */
function editEvent(e, sessionID) {
    $(".mask").show();
    $(".edit_form").show();
    loadContents(e.closest("tr").getAttribute("id"), sessionID)
}

function loadContents(id, sessionID) {
    $.ajax({
        type: 'POST',
        url: '../scripts/get_event.php',
        data: "id=" + id + "&validation=" + sessionID,
        success: function (data) {
            data = data.slice(1).slice(0, -1);
            var obj = jQuery.parseJSON(data);
            $(".edit_form #id").val(obj.id);
            $(".edit_form #title").val(obj.title);
            $(".edit_form #description").val(obj.description);
            $(".edit_form #place_in").val(obj.place);
            $(".edit_form #start").val(obj.eventStart);
            $(".edit_form #end").val(obj.eventEnd);
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
        var title = inputs.find("#title").val();
        var description = inputs.find("#description").val();
        var start = inputs.find("#start").val();
        var end = inputs.find("#end").val();
        var place = inputs.find("#place_in").val();
        var date = inputs.find("#date_in").val();

        $.ajax({
            type: 'POST',
            url: '../scripts/update_event.php',
            data: "id=" + id + "&title=" + title + "&description=" + description + "&start=" + start + "&end=" + end + "&place=" + place + "&date=" + date + "&validation=" + inputs.find("#session").val(),
            success: function (data) {
                $("#status").removeClass("fa-refresh fa-spin");
                if (data == "bdec0ac5c069dd4899e2bf43dc43f4639218a05bbf43f165fd0e80dfe729d118b820551c81bf0308e225a9125ab44823fe89406f56c1a680dad7ecccf631e63c") {
                    $("#status").addClass("fa-times");
                } else {
                    $("#status").addClass("fa-check");

                    var changedRow = $(".events_tbl #" + id);
                    changedRow.find(".title").html(title);
                    changedRow.find(".description").html(description);
                    changedRow.find(".start").html(start);
                    changedRow.find(".end").html(end);
                    changedRow.find(".place").html(place);

                    var res = date.split("-");
                    var d = new Date();
                    d.setFullYear(parseInt(res[0]));
                    d.setMonth(parseInt(res[1]) - 1);
                    d.setDate(parseInt(res[2]));

                    date = d.toLocaleDateString();

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