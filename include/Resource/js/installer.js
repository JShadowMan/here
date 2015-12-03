'use strict';

$(function() {
    $(document).on('contextmenu', function() { return false; });
    $(document).on('selectstart', function() { return false; });
    
    if (isMobile()) {
        $.getScript('/include/Resource/js/library/mobile/fastclick.min.js', function() {
            FastClick.attach(document.body);
            $('#Next-Step-Btn').on('click', nextStep);
        });
    } else {
        $('#Next-Step-Btn').on('click', nextStep);
    }
    
    function isMobile() {
        var sUserAgent = navigator.userAgent.toLowerCase();
        var bIsIpad = sUserAgent.match(/ipad/i) == "ipad";
        var bIsIphoneOs = sUserAgent.match(/iphone os/i) == "iphone os";
        var bIsMidp = sUserAgent.match(/midp/i) == "midp";
        var bIsUc7 = sUserAgent.match(/rv:1.2.3.4/i) == "rv:1.2.3.4";
        var bIsUc = sUserAgent.match(/ucweb/i) == "ucweb";
        var bIsAndroid = sUserAgent.match(/android/i) == "android";
        var bIsCE = sUserAgent.match(/windows ce/i) == "windows ce";
        var bIsWM = sUserAgent.match(/windows mobile/i) == "windows mobile";
        if (bIsIpad || bIsIphoneOs || bIsMidp || bIsUc7 || bIsUc || bIsAndroid || bIsCE || bIsWM) {
            return true;
        } else {
            return false;
        }
    }
});

function nextStep() {
    $.post('/controller/installer/setp/2', {
        step : 2
    }, function(data) {
    }, 'json');
    
//    switch (i++ % 4) {
//        case 0: $('#_Here-Replace-Container').attr('class', '').addClass('widget-opacity-75'); break;
//        case 1: $('#_Here-Replace-Container').attr('class', '').addClass('widget-opacity-5'); break;
//        case 2: $('#_Here-Replace-Container').attr('class', '').addClass('widget-opacity-35'); break;
//        case 3: $('#_Here-Replace-Container').attr('class', '').addClass('widget-opacity-0').html('')
//        .attr('class', '').addClass('widget-opacity-1'); break;
//    }
}