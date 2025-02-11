"use strict";
window.onload = function () {
    stopLoad();
};
var stopLoad = function () {
    let $loadingObj = $('#all-area-indicator').children('.loading');
    $loadingObj.children('.spinner').delay(300).fadeOut(300);
    $loadingObj.delay(500).fadeOut(500, function () {
        $loadingObj.addClass('d-none');
    });
};
var startLoad = function () {
    let $loadingObj = $('#all-area-indicator').children('.loading');
    $loadingObj.removeClass('d-none');
    $loadingObj.show();
    $loadingObj.children('.spinner').show();
};
$(window).on('load', function () {
    $('.submit').on('click', function () {
        startLoad();
    });
});
