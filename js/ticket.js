function deleteTicket(e, sessionID) {
    if (confirm("Are you sure that you want to delete this ticket?")) {
        alert("ghgsa");
        $.ajax({
            type: 'POST',
            url: '../scripts/delete_ticket.php',
            data: "id=" + e.getAttribute("content") + "&validation=" + sessionID,
            success: function (data) {
                if (data == "dd68e8f8d949fa55f430acee153a1d490fae537921f795a2701688f57a6806e2cb1486d5b21423c1b920e32f2bbb9a9ad387710f2096bbd7366b1cbb0509a311") {
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