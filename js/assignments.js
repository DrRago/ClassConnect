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