


/*=============================================================
    Authour URI: www.binarytheme.com
    License: Commons Attribution 3.0

    http://creativecommons.org/licenses/by/3.0/

    100% To use For Personal And Commercial Use.
    IN EXCHANGE JUST GIVE US CREDITS AND TELL YOUR FRIENDS ABOUT US
   
    ========================================================  */


(function ($) {
    "use strict";

    var mainApp = {

        main_fun: function () {
           
            /*====================================
              LOAD APPROPRIATE MENU BAR
           ======================================*/
            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });

          
     
        },

        initialization: function () {
            mainApp.main_fun();

        }

    }

    var navigationFn = {
        goToSection: function(id,speed) {
            $('html, body').animate({
                scrollTop: $(id).offset().top
            }, speed);
        }
    }      
    // Initializing ///

    $(document).ready(function () {
        mainApp.main_fun();
         $('#view-all-section table').DataTable( {});
	    $(document).on("focus", ".datetime", function () {
		$('.datetime').datetimepicker({ format: 'Y-m-d H:i:s' });
	    });
    });  

}(jQuery));
