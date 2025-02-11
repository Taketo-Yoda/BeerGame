window.onload = function() {
    stopLoad($('#all-area-indicator'));
};

var stopLoad = function($elem : any) {
    let $loadingObj = $elem.children('.loading'); 
    $loadingObj.children('.spinner').delay(300).fadeOut(300);
    $loadingObj.delay(500).fadeOut(500, function(){
        $loadingObj.addClass('d-none');
    });
}

var startLoad = function($elem : any) {
    let $loadingObj = $elem.children('.loading'); 
    $loadingObj.removeClass('d-none')
    $loadingObj.show();
    $loadingObj.children('.spinner').show();
}

$(window).on('load', function(){
    $('.submit').on('click', function(){
        startLoad($('#all-area-indicator'));
    });
})
