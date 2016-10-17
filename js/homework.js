function deleteAssignment(e, sessionID) {
    if (confirm("Are you sure that you want to delete this assignment?")) {
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_assignment.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "61d85c36464de09e23a96e2f98eca31a1607eed43653246e2966475e15458a4b82f53553c8e12cafecf9c41bf78412088fc2008dba62d676cdbe4b9c3cd09262") {
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