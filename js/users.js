function deleteUser(e, sessionID) {
    if (confirm("Are you sure that you want to delete this user?")) {
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_user.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "2281d5dc3cb6a8789f457f087bfa6d27089801f38aef0a35270fa17fa3d87006848d2da382af34b8408c46a3b85093b734bd593a5a0501dfa4a295eeb3e21f56") {
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