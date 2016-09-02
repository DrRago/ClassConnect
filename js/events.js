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