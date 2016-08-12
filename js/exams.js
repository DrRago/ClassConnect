function deleteExam(e, sessionID) {
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
    return false;
}