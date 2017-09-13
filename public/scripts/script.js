;(function( $ ) {

    "use strict";

	$(document).ready( function(){

		console.log("Everything OK");

	
		$('#nav-mobile').on("click", function(){
			if($('header nav').hasClass('active')){
				$(this).find('span').addClass('glyphicon-menu-hamburger').removeClass('glyphicon-remove');
				$('header nav').removeClass('active');

			}else{
				$(this).find('span').removeClass('glyphicon-menu-hamburger').addClass('glyphicon-remove');
				$('header nav').addClass('active');
			}
		});



	});
})(jQuery); 