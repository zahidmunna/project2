$(document).ready(function(){
    $(".section").showSection('.section',"#view-all-section");
    $('.show-section').click(function(e){
        e.preventDefault();
        $(".section").showSection('.section',$(this).attr('href'));
    });
    $(document).on('click','.close-this-section',function(e){
        e.preventDefault();
        $(".section").showSection('.section',"#view-all-section");
    });
});
(function ( $ ) {
    $.fn.showSection = function(commonSectionClass,showThisSection) {
        $(commonSectionClass).hide();
        $(showThisSection).show();
    };
 
}( jQuery ));