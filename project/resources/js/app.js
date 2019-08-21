require('jquery');
require('./countUp.min');
require('./jquery.bcSwipe.min');
require('./owl.carousel.min');
require('./gauge.min');
require('./trading');
require('./jquery.toast');
// require('jquery-validation/dist/additional-methods');
// require('jquery-validation/dist/localization/messages_bg');
//require('jquery-validation/dist/localization/messages_bg');
require('floatthead');
// let dt = require( 'datatables.net')(window, $);

/*window.Popper = require('popper.js').default;
require('bootstrap/dist/js/bootstrap.js');
require('bootstrap/js/dist/util');*/

/**
 * Set a cookie for a month
 * @param cname Name of the cookie
 * @param cvalue Value of the cookie
 */
function setCookie(cname, cvalue) {
    var d = new Date();
    d.setTime(d.getTime() + (30 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

/**
 * Get cooke's value if such a cookie exists
 * @param cname Name of the cookie
 * @returns {*} Either the value of the cookie or false
 */
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return false;
}

var updated = 0,
    updated2 = 0,
    updated3 = 0,
    darkThemeStr = 'darkTheme',
    lightThemeStr = 'lightTheme',
    switchTheme = false;

$(function () {

    var $win = $(window);
    var $box = $("header");

    $win.on("click.Bst", function (event) {
        if ($box.has(event.target).length == 0 && !$box.is(event.target)) {
            if ($(".only-mobile").css("display") == "block" && $(".menuContainer").css("display") == "block") {
                $(".menuContainer").slideUp();
            }
        } else {
            /*console.log("inside the box");*/
        }
    });

});


/**
 * Switch to DARK THEME
 */
function swithThemeDark() {
    setCookie(darkThemeStr, true);
    switchTheme = true;
    $("#myonoffswitch1").prop("checked", false);
    $("#myonoffswitch2").prop("checked", false);
    document.getElementById('dark-styles').disabled = false;
    let count = $(".custom-counter").data('count');
    let max_count = Math.ceil(count * 2 / 100) * 100;
    let real_count = max_count / 2;
    if (!$('.onoffswitch-checkbox').is(':checked')) {
        $('.onoffswitch-checkbox').addClass('active');
    }
    $('body').addClass('dark-mode');
    $('.table').addClass('table-dark');

    if (document.body.contains(document.querySelector('#tradingview'))) {
        let coin = $('.trade-view-coin').data('coin');
        let tradingVeiw = new TradingView.widget(
            {
                "autosize": true,
                "symbol": coin,
                "interval": "D",
                "timezone": "Etc/UTC",
                "theme": "Dark",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "withdateranges": true,
                "hide_side_toolbar": false,
                "allow_symbol_change": true,
                "container_id": "tradingview"
            }
        );
    }
    var gauge = new RadialGauge({
        renderTo: 'canvas-id',
        width: 90,
        height: 90,
        units: "",
        minValue: 0,
        value: 0,
        startAngle: 90,
        ticksAngle: 180,
        valueBox: false,
        maxValue: real_count,
        majorTicks: [
            "0",
            "",
            "",
            "",
            "",
            "",
            max_count
        ],
        minorTicks: 3,
        colorMajorTicks: "#f5f5f5",
        colorMinorTicks: "#ddd",
        colorNumbers: "#d6d6d6",
        strokeTicks: true,
        highlights: [
            {
                "from": real_count - real_count * 0.3,
                "to": real_count,
                "color": "rgba(192, 192, 192, 1)"
            }
        ],
        colorPlate: "#252525",
        borderShadowWidth: 0,
        fontNumbersSize: 34,
        borders: false,
        needleType: "arrow",
        needleWidth: 3,
        needleCircleSize: 2,
        needleCircleOuter: true,
        needleCircleInner: false,
        animationDuration: 1500,
        animationRule: "linear"
    }).draw();

    setInterval(function () {
        var value = count;
        gauge.value = value;

        document.getElementById("canvas-id").setAttribute("data-value", value);
    }, 1000);
}

// Switch to light theme on load (deprecated)
function swithThemeLightOnLoad() {
    switchTheme = false;
    document.getElementById('dark-styles').disabled = true;
    $(document).removeClass('dark-mode');
}

/**
 * Switch to LIGHT THEME
 */
function swithThemeLight() {
    setCookie(darkThemeStr, false);
    switchTheme = false;
    $("#myonoffswitch1").prop("checked", true);
    $("#myonoffswitch2").prop("checked", true);
    document.getElementById('dark-styles').disabled = true;
    if (!$('.onoffswitch-checkbox').is(':checked')) {
        $('.onoffswitch-checkbox').removeClass('active');
    }
    $('body').removeClass('dark-mode');
    $('.table').removeClass('table-dark');
    let count = $(".custom-counter").data('count');
    let max_count = Math.ceil(count * 2 / 100) * 100;
    let real_count = max_count / 2;
    if (document.body.contains(document.querySelector('#tradingview'))) {
        let coin = $('.trade-view-coin').data('coin');
        let tradingVeiw = new TradingView.widget(
            {
                "autosize": true,
                "symbol": coin,
                "interval": "D",
                "timezone": "Etc/UTC",
                "theme": "Light",
                "style": "1",
                "locale": "en",
                "toolbar_bg": "#f1f3f6",
                "enable_publishing": false,
                "withdateranges": true,
                "hide_side_toolbar": false,
                "allow_symbol_change": true,
                "container_id": "tradingview"
            }
        );
    }

    var gauge = new RadialGauge({
        renderTo: 'canvas-id',
        width: 90,
        height: 90,
        units: "",
        minValue: 0,
        startAngle: 90,
        ticksAngle: 180,
        valueBox: false,
        value: 0,
        maxValue: real_count,
        majorTicks: [
            "0",
            "",
            "",
            "",
            "",
            "",
            max_count
        ],
        minorTicks: 3,
        colorMajorTicks: "#252525",
        colorMinorTicks: "#444444",
        colorNumbers: "#252525",
        strokeTicks: true,
        highlights: [
            {
                "from": real_count - real_count * 0.3,
                "to": real_count,
                "color": "rgba(192, 192, 192, 1)"
            }
        ],
        colorPlate: "#252525",
        colorPlate: "#FFF",
        borderShadowWidth: 0,
        fontNumbersSize: 34,
        borders: false,
        needleType: "arrow",
        needleWidth: 3,
        needleCircleSize: 2,
        needleCircleOuter: true,
        needleCircleInner: false,
        animationDuration: 1500,
        animationRule: "linear"

    }).draw();

    setInterval(function () {
        var value = count;
        gauge.value = value;

        document.getElementById("canvas-id").setAttribute("data-value", value);
    }, 1000);

}

// var gauge = new RadialGauge({
//     renderTo: 'canvas-id',
//     width: 90,
//     height: 90,
//     units: "",
//     minValue: 0,
//     startAngle: 90,
//     ticksAngle: 180,
//     valueBox: false,
//     maxValue: 60000,
//     majorTicks: [
//         "0",
//         "",
//         "",
//         "",
//         "",
//         "",
//         "60k"
//     ],
//     minorTicks: 3,
//     colorMajorTicks: "#252525",
//     colorMinorTicks: "#444444",
//     colorNumbers: "#252525",
//     strokeTicks: true,
//     highlights: [
//         {
//             "from": 40000,
//             "to": 60000,
//             "color": "rgba(192, 192, 192, 1)"
//         }
//     ],
//     colorPlate: "#252525",
//     colorPlate: "#FFF",
//     borderShadowWidth: 0,
//     fontNumbersSize: 34,
//     borders: false,
//     needleType: "arrow",
//     needleWidth: 3,
//     needleCircleSize: 2,
//     needleCircleOuter: true,
//     needleCircleInner: false,
//     animationDuration: 4000,
//     animationRule: "linear"
// }).draw();
//
// setInterval(function () {
//     var value = 35000;
//     gauge.value = value;
//
//     document.getElementById("canvas-id").setAttribute("data-value", value);
// }, 1500);


// Dark theme onload
window.onload = function () {
    //Get the state of the current cookie (false, if it doesn't exist)
    switchTheme = getCookie(darkThemeStr);

    // If the cookie hasn't been set, or is set to false, call "switchThemeDark()"
    // Otherwise call "swithThemeLight()"
    if (switchTheme === 'true' || switchTheme === false) {
        swithThemeDark(); // set dark theme
    } else {
        swithThemeLight(); // set light theme
    }
};

$(document).ready(function () {

    $('.carousel').bcSwipe();

    // swithThemeLightOnLoad();

    if ($('.counter').length > 0) {
        setTimeout(function () {
            $('.counter').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');

                $({countNum: $this.text()}).animate({
                        countNum: countTo.replace(",", "")
                    },
                    {
                        duration: 1300,
                        easing: 'linear',
                        step: function () {
                            var countTo1 = new String(this.countNum);

                            $this.text(Math.floor(countTo1.replace(",", "")));
                        },
                        complete: function () {

                            var nStr = this.countNum;

                            nStr += '';
                            x = nStr.split('.');
                            x1 = x[0];
                            x2 = x.length > 1 ? '.' + x[1] : '';
                            var rgx = /(\d+)(\d{3})/;
                            while (rgx.test(x1)) {
                                x1 = x1.replace(rgx, '$1' + ',' + '$2');
                            }
                            //alert(parseFloat(x1+x2));
                            //alert(x1+x2);

                            $this.text(x1 + x2);
                        }
                    });
            });
        }, 1500);
    }

    var mytitle = $("#material-tabs > .active").html();
    if (mytitle === undefined) {
        var mytitle = $("#custom-material-tabs > .active").html();
    }
    $("#mobileMatTitle").html(mytitle + '<i class="fas fa-chevron-down"></i>'); //joro

    $('.formHolder').hide();

    $("#searchFormBtn").on("click", function () {
        if ($("#searchForm").hasClass("searchFormActive")) {
            $(this).show();
            $("#searchForm").removeClass("searchFormActive");
            $('.formHolder').hide();
        } else {
            $(this).hide();
            $('.formHolder').show();
            $("#searchForm").addClass("searchFormActive");
            $('.searchInput').focus();
        }
    });

    //moje dai test sek
    $(".searchInput").on("blur", function () {
        if ($("#searchForm").hasClass("searchFormActive") && $('.searchInput').val() !== '') {

        }else{
            $('#searchFormBtn').show();
            $('.formHolder').show();
            $("#searchForm").removeClass("searchFormActive");
        }
    });

    $("#topMenu").bind("click", function () {

        if ($(".menuContainer").css("display") == "none") {
            if (updated == 0) {
                updated = 1;
            }
            $(".menuContainer").slideDown();
        } else {
            $(".menuContainer").slideUp();
        }

    });

    $("#onoffswitch1").bind('click', function () {
        if (!switchTheme) {
            swithThemeDark();
            $("#myonoffswitch2").prop("checked", true);
        } else {
            swithThemeLight();
            $("#myonoffswitch2").prop("checked", false);
        }
    });

    $("#onoffswitch2").bind('click', function () {
        if (!switchTheme) {
            swithThemeDark();
            // console.log("izvyn elsa");
            $("#myonoffswitch").prop("checked", true);

        } else {
            swithThemeLight();
            // console.log("v elsa");
            $("#myonoffswitch").prop("checked", false);
        }
    });

    $("#mobileMatTitle").bind("click", function () {

        if ($(".tabLinks").css("display") == "none") {
            if (updated3 == 0) {
                updated3 = 1;
            }
            $(".tabLinks").slideDown();
        } else {
            $(".tabLinks").slideUp();
        }
    });

    $(".fmobileRow").bind("click", function () {

        if ($(".only-mobile").css("display") == "block") {
            if ($(this).next(".fmenuHolder").css("display") == "none") {
                if (updated2 == 0) {
                    updated2 = 1;
                }
                $(".fmobileRow i").removeClass("rotateIcon");
                $(".fmenuHolder").slideUp();
                $(this).children("i").addClass("rotateIcon");
                $(this).next(".fmenuHolder").slideDown();
            } else {
                $(this).children("i").removeClass("rotateIcon");
                $(this).next(".fmenuHolder").slideUp();
            }
        }
    });

    $.fn.exists = function () {
        return this.length !== 0;
    }

    $('#material-tabs').each(function () {

        var $active, $content, $links = $(this).find('a');

        $active = $(this).find('.active');

        if (!$active.exists()) {
            $active = $($links[0]);
            $active.addClass('active');

        }

        $content = $($active[0].hash);

        $links.not($active).each(function () {
            // console.log(this.hash);
            $(this.hash).hide();
        });

        $content = $($active.attr('href'));
        $content.show();

        $(this).on('click', 'a', function (e) {

            $active.removeClass('active');
            $content.hide();

            $active = $(this);
            $content = $(this.hash);

            $active.addClass('active');
            $content.show();

            if ($(".only-mobile").css("display") == "block") {
                $(".tabLinks").slideUp();
                var mytitle = $("#material-tabs > .active").html();
                $("#mobileMatTitle").html(mytitle + '<i class="fas fa-chevron-down"></i>');
            }

            e.preventDefault();
        });
    });

    $('#material-tabs[data-analyze="material-tabs-2"]').each(function () {

        var $active, $content, $links = $(this).find('a');

        $active = $(this).find('.active');

        if (!$active.exists()) {
            $active = $($links[0]);
            $active.addClass('active');

        }

        $content = $($active[0].hash);

        $links.not($active).each(function () {
            // console.log(this.hash);
            $(this.hash).hide();
        });

        $content = $($active.attr('href'));
        $content.show();

        $(this).on('click', 'a', function (e) {

            $active.removeClass('active');
            $content.hide();

            $active = $(this);
            $content = $(this.hash);

            $active.addClass('active');
            $content.show();

            if ($(".only-mobile").css("display") == "block") {
                $(".tabLinks").slideUp();
                var mytitle = $('#material-tabs[data-analyze="material-tabs-2"] > .active').html();
                $("#mobileMatTitle").html(mytitle + '<i class="fas fa-chevron-down"></i>');
            }

            e.preventDefault();
        });
    });

    $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay: true,
        margin: 24,
        autoplayTimeout: 6000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            768: {
                items: 4
            },
            1100: {
                items: 5
            },
            1200: {
                items: 6
            }
        }
    });

});

$(document).ready(function () {
    // Link to coin's page
    $('.coin-link').on('click', function () {
        window.location.href = $(this).data().link
    });

    // Add coin to favorites
    $('.add-to-favorites').on('click', function () {
        $(this).toggleClass('is-fav');
    });

    // $('.contact-form').validate({
    //     rules: {
    //
    //     }
    // });

    /*// Suggest a tag
    $('.suggest-tag-trigger').on('click', function () {
        console.log('trigger clicked');
        $('#suggest-tab-modal').modal('show')
    })*/

    $('.question-trigger').tooltip();

    // Post a comment
    $('.addComment').on('click', function () {
        let id = $(this).attr('id');
        // console.log(id);
        let hidden_wrapper = $('.for_hidden');
        hidden_wrapper.html('');
        hidden_wrapper.html('<input type="hidden" name="parent_id" value="' + id + '">');
        $('#post-comment-modal').modal('show')
    });

    if ($('#post-comment-form').length > 0) {
        $('#post-comment-form').validate({
            ignore: [],
            rules: {
                field: {
                    required: true
                },
                email: {
                    email: true
                },
                'g-recaptcha-response': {
                    required: true
                }
            },
        });
    }

    if ($('#post-new-comment').length > 0) {
        $('#post-new-comment').validate({
            ignore: [],
            rules: {
                field: {
                    required: true
                },
                email: {
                    email: true
                },
                'g-recaptcha-response': {
                    required: true
                }
            },
        });
    }

    let urlCheck = window.location.href.toString();

    if (urlCheck.indexOf("comment_id") > 0) {
        let findCommentId = window.location.href.split('_id=')[1];

        $('html, body').animate({
            scrollTop: $('#' + findCommentId).offset().top
        }, 800);


    }

    // Sortable tables
    let coinsTable = $('#main-coins-table').DataTable({
        searching: false,
        lengthChange: false,
        paging: false,
        info: false,
        fixedHeader: {
            header: true
        }
    });

    // Fixed header offset on smaller resolutions
    if (window.innerWidth > 1100) {
        coinsTable.fixedHeader.enable(true);
    } else {
        coinsTable.fixedHeader.disable();
    }

    // $('.dataTables_length').addClass('bs-select');

});

// var fired = false;
//
// window.changeArticlesData = function (category_slug = null, page, from_category = false) {
//
//     //check if category slug is empty and get it from hidden html tags
//
//     let links = $('#custom-material-tabs');
//
//     const sleep = (milliseconds) => {
//         return new Promise(resolve => setTimeout(resolve, milliseconds))
//     }
//
//     links.children().each(function () {
//         $(this).removeClass('active');
//
//         if ($(this).data('slug') === category_slug) {
//             $(this).addClass('active');
//         }
//     });
//
//     $.ajaxSetup({
//         cache: false,
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });
//     $.ajax({
//         url: links.data('url'),
//         method: 'post',
//         data: {
//             page: page,
//             category: category_slug,
//         },
//         beforeSend: function () {
//             if (!from_category) {
//                 $('.loader').fadeIn(50);
//             }
//         },
//
//         success: function (result) {
//             if (result.errors.length === 0) {
//                 if (from_category) {
//                     $('#articles_container').html(result.data);
//                 } else {
//                     sleep(300).then(() => {
//                         $('#articles_container').append(result.data);
//                     })
//                 }
//                 if (result.data !== '') {
//                     $('.page_number').html(parseInt(page) + 1);
//                     fired = false;
//                 }
//
//                 $('.loader').fadeOut(400);
//             } else {
//
//             }
//         }
//     });
//
// };

// let links = document.querySelector('#custom-material-tabs');
//
// if (document.body.contains(links)) {
//     let active_link;
//     let page = 1;
//     $(window).scroll(function () {
//         let links = $('#custom-material-tabs');
//         links.children().each(function () {
//             if ($(this).hasClass('active')) {
//                 active_link = $(this).data('slug');
//             }
//         });
//
//         if ($('.page_number').html() < 2) {
//             page = 2;
//         } else {
//             page = $('.page_number').html();
//         }
//         if ($(window).scrollTop() + $(window).height() >= $(document).height() - 550 && fired === false) {
//             changeArticlesData(active_link, page);
//             fired = true;
//         }
//     });
// }

window.submit_subscriber = function (prefix) {
    let email_value = $("#" + prefix + '_email').val();
    let link = $("#" + prefix + '_link').val();

    $.ajaxSetup({
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: link,
        method: 'post',
        data: {
            email: email_value,
        },
        success: function (result) {
            let success_wrapper = $('.' + prefix + '-success-wrapper');
            let errors_wrapper = $('.' + prefix + '-errors-wrapper');

            success_wrapper.hide();
            success_wrapper.html('');
            errors_wrapper.hide();
            errors_wrapper.html('');

            if (result.errors.length !== 0) {
                result.errors.forEach(function (error) {
                    let html = "<div class=\"footer_success alert alert-warning\" role=\"alert\">" + error + "</div>";
                    errors_wrapper.append(html);
                });

                errors_wrapper.fadeIn(200);

            } else {
                let html = "<div class=\"footer_success alert alert-success\" role=\"alert\">" + result.success + "</div>";
                success_wrapper.append(html);
                success_wrapper.fadeIn(200);
                $("#" + prefix + '_email').val(null);
            }
        }
    });

};

//--------------------------------------
//            CUSTOM FB SHARE BTN
//--------------------------------------

setShareLinks();

function socialWindow(url) {
    let left = (screen.width - 570) / 2;
    let top = (screen.height - 570) / 2;
    let params = "menubar=no,toolbar=no,status=no,width=570,height=570,top=" + top + ",left=" + left;
    window.open(url,"NewWindow",params);
}

function setShareLinks() {
    let pageUrl = encodeURIComponent(document.URL);

    $(".fb-share").on("click", function() {
        let url = "https://www.facebook.com/sharer.php?u=" + pageUrl;
        socialWindow(url);
    });
}
//--------------------------------------
//            COIN CALCULATOR
//--------------------------------------

let coin_input = $('.coin-value input');
let coin_calculated_input = $('.coin-value-calculated input');
let selected_currency = $('.currency-selected');
let currency_dropdown = $('.currency-dropdown');

function calculateCoin() {
    //GET CURRENCY
    currency_dropdown.children().on('click', function (e) {
        e.preventDefault();
        let clicked_currency_text = $(this).html();
        let clicked_currency_price = $(this).data('curr-price');
        coin_calculated_input.val(clicked_currency_price);
        coin_calculated_input.attr('data-value', clicked_currency_price);
        selected_currency.val(clicked_currency_text.toLowerCase());
        selected_currency.html(clicked_currency_text);
        let number = coin_input.val() * clicked_currency_price;
        let minimum = 0;
        if (coin_calculated_input.data('value') < 1) {
            minimum = 7;
        }

        coin_calculated_input.val(removeTrailingZeros(Number(number).toLocaleString(undefined, { minimumFractionDigits: minimum })));
//DISPLAY RESULT ON KEYUP
        coin_input.on('keyup', function () {
            let number = coin_input.val() * clicked_currency_price;
            let minimum = 0;
            if (coin_calculated_input.data('value') < 1) {
                minimum = 7;
            }
            coin_calculated_input.val(removeTrailingZeros(Number(number).toLocaleString(undefined, { minimumFractionDigits: minimum })));
        });
    });

    coin_input.on('keyup', function () {
        let number = coin_input.val() * coin_calculated_input.data('value');
        let minimum = 0;
        if (coin_calculated_input.data('value') < 1) {
            minimum = 7;
        }
        coin_calculated_input.val(removeTrailingZeros(Number(number).toLocaleString(undefined, { minimumFractionDigits: minimum })));
    });



}

function removeTrailingZeros(value) {
    value = value.toString();

    if (value.indexOf('.') === -1) {
        return value;
    }

    while((value.slice(-1) === '0' || value.slice(-1) === '.') && value.indexOf('.') !== -1) {
        value = value.substr(0, value.length - 1);
    }
    return value;
}

calculateCoin();

// -----------------------------------------
//             BACK TO TOP
// -----------------------------------------
$btn = $('.to-top');
$btn.hide();
$(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
        $btn.fadeIn(300);
    } else {
        $btn.fadeOut(300);
    }
});

$btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({scrollTop: 0}, '300');
});

// Cookie Compliancy BEGIN
function GetCookie(name) {
    var arg=name+"=";
    var alen=arg.length;
    var clen=document.cookie.length;
    var i=0;
    while (i<clen) {
        var j=i+alen;
        if (document.cookie.substring(i,j)==arg)
            return "here";
        i=document.cookie.indexOf(" ",i)+1;
        if (i==0) break;
    }
    return null;
}
function testFirstCookie(){
    var offset = new Date().getTimezoneOffset();
    if ((offset >= -180) && (offset <= 0)) { // European time zones
        var visit=GetCookie("cookieCompliancyAccepted");
        if (visit==null){
            $("#myCookieConsent").fadeIn(400);	// Show warning
        } else {
            // Already accepted
        }
    }
}
$(document).ready(function(){
    $("#cookieButton").click(function(){
        console.log('Understood');
        var expire=new Date();
        expire=new Date(expire.getTime()+7776000000);
        document.cookie="cookieCompliancyAccepted=here; expires="+expire+";path=/";
        $("#myCookieConsent").hide(400);
    });
    testFirstCookie();
});