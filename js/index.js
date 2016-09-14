//noinspection JSJQueryEfficiency
$( ".input" ).focusin(function() {
    $( this ).find( "span" ).animate({"opacity":"0"}, 200);
});

//noinspection JSJQueryEfficiency
$( ".input" ).focusout(function() {
    $( this ).find( "span" ).animate({"opacity":"1"}, 300);
});

$(".login").submit(function(){
    var pwIn = $(".pw-in");
    $(".login").find(".submit i").removeAttr('class').addClass("fa fa-refresh fa-refresh-animate").css({"color":"#fff"});
    $(".submit").css({background:"#26697F", borderColor:"#26697F"});
    $("input").prop("readonly", true);
    $(".error").hide().animate(0);

    pwIn.blur();
    $.ajax({
        type: 'POST',
        url: '../scripts/login.php',
        data: "username=" + $('.user-in').val() + "&password=" + pwIn.val(),
        success: function(data) {
            if (data == "2015dc533959e662c9c7409bb95a7b2d4f77bbd57dd39360a803861d727152eb9956bc81beb294563702d0182ee41d0cfee8aa237d04fe4885e1368486edefa6") {
                $(".login").find(".submit i").removeAttr("class").addClass("fa fa-check");
                $(".submit").css({"background":"#2ecc71", "border-color":"#2ecc71"});
                $("input").css({"border-color":"#2ecc71"});
                setTimeout("window.location.href='timetable.php'", 1000);
            } else if (data == "874f5a97696908867933da2f6ee6a4c013f3a87483bda93b81b52333ac4a893e938960397c95d03678576a5e84db9e33c60f1ef4fcdde9350aff4fbbb0d74093") {
                $(".login").find(".submit i").removeAttr('class').addClass("fa fa-times").css({"color":"#fff"});
                $(".submit").css({"background":"#FF7052", "border-color":"#FF7052"});
                $(".error").show().animate({"opacity":"1", "bottom":"-80px"}, 400);
                $("input").css({"border-color":"#FF7052"}).prop('readonly', false);
                pwIn.val("").focus();
            } else if (data == "465729e25900c34f728f030771cd83452123d8c4070255a327d0c7d46b605b79bb212c31504d8e9dd9a2c353132b1d69f642b0ef30513562bb1200243f4d4e27") {
                $(".login").find(".submit i").removeAttr('class').addClass("fa fa-exclamation").css({"color":"#fff"});
                $(".submit").css({"background":"#f0ad4e", "border-color":"#f0ad4e"});
                $(".interror").show().animate({"opacity":"1", "bottom":"-80px"}, 400);
                $("input").css({"border-color":"#f0ad4e"}).prop('readonly', false);
                pwIn.val("").focus();
            }
        }
    });
    return false;
});
function download(url) {
    $.fileDownload(url)
        .done(function () {
            $(".download i").removeAttr("class").addClass("fa fa-check");
            $(".download").css({"background":"#2ecc71", "border-color":"#2ecc71", "color":"#EDEDED"});
            setTimeout(function () {
                $(".download i").removeAttr("class").addClass("fa fa-download");
                $(".download").css({"background":"#fff", "border-color":"#26697F", "color":"#26697F"});
            }, 1000);
        })
        .fail(function () {
            $(".download i").removeAttr("class").addClass("fa fa-check");
            $(".download").css({"background":"#2ecc71", "border-color":"#2ecc71", "color":"#EDEDED"});
            setTimeout(function () {
                $(".download i").removeAttr("class").addClass("fa fa-download");
                $(".download").css({"background":"#fff", "border-color":"#26697F", "color":"#26697F"});
            }, 1000);
        });
}