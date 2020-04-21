/**
 *	Custom jQuery Scripts
 *	
 *	Developed by: Austin Crane	
 *	Designed by: Austin Crane
 */

jQuery(document).ready(function ($) {
	
	/* Slideshow */
	// var swiper = new Swiper('#slideshow', {
	// 	effect: 'slide', /* "fade", "cube", "coverflow" or "flip" */
	// 	loop: true,
	// 	noSwiping: false,
	// 	simulateTouch : false,
	// 	autoplay: {
	// 		delay: 4000,
	// 	},
	// 	pagination: {
	// 		el: '.swiper-pagination',
	// 		clickable: true,
	// 	},
	// 	navigation: {
	// 		nextEl: '.swiper-button-next',
	// 		prevEl: '.swiper-button-prev',
	// 	},
 //    });

	var swiper = new Swiper('#slideshow', {
		effect: 'fade', /* "fade", "cube", "coverflow" or "flip" */
		loop: true,
		noSwiping: false,
		simulateTouch : false,
		speed: 1000,
		autoplay: {
			delay: 4000,
		}
    });

    /* Select Style */
    $(".select-input-field").each(function(){
    	var label = $(this).data("label");
    	var id = $(this).data("id");
    	$("select#"+id).select2({ placeholder: label, allowClear: true });
    });


	$(".contactform select").select2();


    /* Smooth Scroll */
    $('a[href*="#"]')
	  .not('[href="#"]')
	  .not('[href="#0"]')
	  .click(function(event) {
	    // On-page links
	    if (
	      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
	      && 
	      location.hostname == this.hostname
	    ) {
	      // Figure out element to scroll to
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      // Does a scroll target exist?
	      if (target.length) {
	        // Only prevent default if animation is actually gonna happen
	        event.preventDefault();
	        $('html, body').animate({
	          scrollTop: target.offset().top
	        }, 1000, function() {
	          // Callback after animation
	          // Must change focus!
	          var $target = $(target);
	          $target.focus();
	          if ($target.is(":focus")) { // Checking if the target was focused
	            return false;
	          } else {
	            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
	            $target.focus(); // Set focus again
	          };
	        });
	      }
	    }
	});


	/* News Pagination */
	var n = 2;
	$(document).on("click","#loadmore",function(e){
		e.preventDefault();
		var target = $(this);
		var maxpageNum = $(this).data("maxpagenum");
		var currentPage = $(this).data("nextpage");
		var end = n+1;
		var currentURL = window.location.href;
		
		if(n<=maxpageNum) {
			target.attr('data-nextpage',n);
			//var pagelink = currentURL + '?pg=' + n;
			var baseURL = '';
			if( $("#pagination a.page-numbers").length > 0 ) {
				$("#pagination a.page-numbers").each(function(k){
					if(k==0) {
						var link = $(this).attr("href");
						var parts = link.split("pg=");
						baseURL = parts[0];
					}
				});
			}
			if(baseURL) {
				var new_base_url = baseURL + 'pg=' + n;
				$.get(new_base_url,function(data){
					var output = $.parseHTML(data);
					var items = $(data).find("#newsInner").html();
					$("#newsInner").append(items);
				});
			}
			
		}

		if(end>maxpageNum) {
			$(".morediv").html('<span class="end">No more posts to load.</span>');
		}
		n++;
	});

	$(document).on("change",".filter-wrapper select",function(){
		$("#filterPostForm").trigger("submit");
	});

	/* Sidebar Articles */
	
	$( window ).resize(function() {
		resize_sidebar_height();
	});
	resize_sidebar_height();
	function resize_sidebar_height() {
		var sidebar_article = $("#sidebar #recentPosts");
		if( sidebar_article.length > 0 ) {
			var sbHeight = $("ul.recent-posts").outerHeight();
			sidebar_article.css("height",sbHeight+'px');
		}
	}
	
	var s=2;
	$(document).on("click","#sbloadmore",function(e){
		e.preventDefault();
		var target = $(this);
		var maxpageNum = $(this).data("maxpagenum");
		var currentPage = $(this).data("nextpage");
		var end = s+1;
		var currentURL = window.location.href;
		if(s<=maxpageNum) {
			var baseURL = '';
			if( $("#pagination a.page-numbers").length > 0 ) {
				$("#pagination a.page-numbers").each(function(k){
					if(k==0) {
						var link = $(this).attr("href");
						var parts = link.split("pg=");
						baseURL = parts[0];
					}
				});
			}
			if(baseURL) {
				var new_base_url = baseURL + 'pg=' + s;
				$.get(new_base_url,function(data){
					var output = $.parseHTML(data);
					var items = $(data).find(".recent-posts").html();
					$(".recent-posts").append(items);
					$("#widget-articles").addClass('addedNewItems');
					var container = $('#recentPosts'),
					    scrollTo = $('.morediv');
					container.animate({
					    scrollTop: scrollTo.offset().top - container.offset().top + container.scrollTop()
					});
				});
			}
		}
		if(end>maxpageNum) {
			$(".morediv").html('<span class="end">No more posts to load.</span>');
		}
		s++;
	});



	/* 
		GRAVITY FORM
		First and Last name field 
	*/
	if( $("span.name_first").length > 0 &&  $("span.name_last").length > 0 ) {
		var firstName = $("span.name_first input").val().replace(/\s/g,'');
		if(firstName) {
			$("span.name_first").addClass('hasText');
		} else {
			$("span.name_first").removeClass('hasText');
		}
		var lastName = $("span.name_last input").val().replace(/\s/g,'');
		if(lastName) {
			$("span.name_last").addClass('hasText');
		} else {
			$("span.name_last").removeClass('hasText');
		}

		$("span.name_first input, span.name_last input").on("focus",function(){
			var txt = $(this).val().replace(/\s/g,'');
			var parent = $(this).parents("span");
			parent.addClass("hasText");
		});

		$("span.name_first input, span.name_last input").on("blur focusout",function(){
			var txt = $(this).val().replace(/\s/g,'');
			var parent = $(this).parents("span");
			if(txt=='') {
				parent.removeClass("hasText");
			}
		});
	}

	/*
	*
	*	Wow Animation
	*
	------------------------------------*/
	new WOW().init();


	$(document).on("click","#menu-toggle",function(e){
		e.preventDefault();
		$(this).toggleClass('open');
		$('body').toggleClass('open-menu');
	});
	$(document).on("click","#overlay",function(e){
		e.preventDefault();
		$('#menu-toggle').trigger('click');
	});

});// END #####################################    END