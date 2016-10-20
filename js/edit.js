$(document).on('keyup',function(evt) {
    if (evt.keyCode == 27 && $(".mask").is(":visible")) {
        exitEdit();
    }
});

$(document).mouseup(function (e) {
    var container = $(".edit_form");

    var date = $("#ui-datepicker-div");

    if (!container.is(e.target) && container.has(e.target).length === 0 && $(".mask").is(":visible")) {
        exitEdit();
    }
});

function exitEdit() {
    $(".mask").fadeOut();
    $(".edit_form").fadeOut();
    $(".form-inline input").prop("disabled", false);
    $(".edit_form .input-div").fadeOut();
    setTimeout(function () {
        $(".edit_form .fa-spin").show();
    }, 1000);
}

function raiseTiemout() {
    $("#status").removeClass("fa-refresh fa-spin").addClass("fa-times");
    setTimeout(function () {
        alert("Maximum execution time of 10 seconds was exceeded. Check your internet connection and try again");
        setTimeout(function () {
            $("#status").removeClass("fa-times").addClass("fa-refresh fa-spin");
            exitEdit()
        }, 1000)
    }, 500);
}