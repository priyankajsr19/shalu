(function($) {
	$.fn.hoverIntent = function(f, g) {
		var cfg = {
			sensitivity : 7,
			interval : 100,
			timeout : 0
		};
		cfg = $.extend(cfg, g ? {
			over : f,
			out : g
		} : f);

		var cX, cY, pX, pY;

		var track = function(ev) {
			cX = ev.pageX;
			cY = ev.pageY;
		};

		var compare = function(ev, ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			if ((Math.abs(pX - cX) + Math.abs(pY - cY)) < cfg.sensitivity) {
				$(ob).unbind("mousemove", track);
				ob.hoverIntent_s = 1;
				return cfg.over.apply(ob, [ ev ]);
			} else {
				pX = cX;
				pY = cY;
				ob.hoverIntent_t = setTimeout(function() {
					compare(ev, ob);
				}, cfg.interval);
			}
		};

		var delay = function(ev, ob) {
			ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			ob.hoverIntent_s = 0;
			return cfg.out.apply(ob, [ ev ]);
		};

		var handleHover = function(e) {
			var ev = jQuery.extend({}, e);
			var ob = this;

			if (ob.hoverIntent_t) {
				ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t);
			}

			if (e.type == "mouseenter") {
				pX = ev.pageX;
				pY = ev.pageY;
				$(ob).bind("mousemove", track);
				if (ob.hoverIntent_s != 1) {
					ob.hoverIntent_t = setTimeout(function() {
						compare(ev, ob);
					}, cfg.interval);
				}

			} else {
				$(ob).unbind("mousemove", track);
				if (ob.hoverIntent_s == 1) {
					ob.hoverIntent_t = setTimeout(function() {
						delay(ev, ob);
					}, cfg.timeout);
				}
			}
		};

		return this.bind('mouseenter', handleHover).bind('mouseleave',
				handleHover);
	};
})(jQuery);
function makeTall(e) {
	$("#cart_block").slideDown();
}
function makeSmall(e) {
	$("#cart_block").slideUp();
}

$(document).ready(function() {
	var config = {
		over : makeTall,
		timeout : 100,
		out : makeSmall,
		sensitivity : 1,
		interval : 100
	};
	$("#header_user").hoverIntent(config);
	config = {
		over : function(e) {
			id = $(this).attr('rel');
			$('#ajax_id_product_' + id).show();
		},
		timeout : 300,
		out : function hideButton() {
			id = $(this).attr('rel');
			$('#ajax_id_product_' + id).hide();
			;
		},
		sensitivity : 1,
		interval : 100
	};	
	//$('.ajax_block_product').hoverIntent(config);
	$('.ajax_block_product').hover(function(){
		id = $(this).attr('rel');
		$('#ajax_id_product_' + id).show(0);
	},function(){
		id = $(this).attr('rel');
		$('#ajax_id_product_' + id).hide(0);
	});
	
	$('.quick_view_link').fancybox({
		fitToView : true,
		margin:0,
		padding:0
	});
	
});


//header
function plusClick(data)
{
  var plus_click_type = 0;
  if(data.state=="on"){
	  plus_click_type = 1;
    }else if(data.state=="off"){
    	plus_click_type = 2;
    }

    var datastring = 'ajax=true&plus_click='+ plus_click_type + '&pid=' + id_product;
	$.ajax(
			{
				type: 'POST',
				url: baseDir + 'feedback.php',
				data: datastring,
				dataType: 'json',
				success: function(result){
					if(result.feedback_status == 'succeeded')
					{
						
					}
				}
	});
}
$(document).ready(function() {
	$('#feedback-form').submit(function(e){
		var container = $('#error_container');
		// validate the form when it is submitted
		var validator = $("#feedback-form").validate({
			errorContainer: container,
			errorLabelContainer: $("ol", container),
			wrapper: 'li',
			meta: "validate"
		});
		if(!validator.form())
			e.preventDefault();
		else
		{
			e.preventDefault();
			var dataString = $('#feedback-form').serialize();
			$.ajax(
					{
						type: 'POST',
						url: baseDir + 'feedback.php',
						data: dataString,
						dataType: 'json',
						success: function(result){
							if(result.feedback_status == 'succeeded')
							{
								$('#feedback-form').fadeOut();
								$('#fb_thanks').fadeIn();
								Recaptcha.reload();
								window.setTimeout(function(){
									$.fancybox.close();
									$('#feedback-form').fadeIn();
									$(':input','#feedback-form').not(':button, :submit, :hidden').val('');
									$('#fb_thanks').fadeOut();
								}, 3000);
							}
							else if(result.feedback_status == 'invalid_recaptcha')
							{
								$('.recaptcha_error').fadeIn();
								$('#error_container ol').fadeIn();
								$('#error_container').fadeIn();
							}
						}
					});
		}
	});
	
	$('#feedback_button').fancybox({
			'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	true,
			'height'		:	500,
			'width'			:   700,
    		'hideOnContentClick':false
	});
	
	$('#login_link').fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	true,
		'hideOnContentClick':false
});
	
	$('.lazy').jail({timeout:500});
	$('.delaylazy').jail({timeout:3000, event:'load'});
});


var RecaptchaOptions = {
    theme : 'clean'
};

//search
var defaultSearchText = '';
$(document).ready(function(){
	$('#searchbox').submit(function(e){
		e.preventDefault();
		var q = $('#search_query_top').val();
		q = q.replace(/ /g, '+');
		if(q != defaultSearchText && q != '')
		{
			window.location = encodeURI(baseDir + 'products/' + q); 
		}
		
	});
});
function blurText(eleText)
{
	if($('#search_query_top').val() == '')
		$('#search_label').fadeIn();
}
function focustText(eleText)
{
	$('#search_label').fadeOut();
}

//megamenu
$(function() {
	var $menu = $('#topmenu');
	
	var config = {    
		     over: function() {
		    		var $this = $(this);
					var $span = $this.children('.menu-title');
					$menu.find('.dropmenu').hide();
					$this.find('.dropmenu').show();
					$span.addClass('active');}, 
		     timeout: 250,  
		     out: function() {
		    	 	var $this = $(this);
					var $span = $this.children('.menu-title');
		    	 	$this.find('.dropmenu').hide();
					$span.removeClass('active');
				}  
		};

	$menu.children('li.submenu').each(function() {
		
		var $this = $(this);
		var $span = $this.children('a');
		$span.data('width', $span.width());
		$this.hoverIntent( config );
	});
	
	$('#currencymenu').hoverIntent({
		over: function() {
    		var $this = $(this);
			var $span = $this.children('.menu-title');
			$this.find('.currencydropmenu').slideDown('fast');
			$span.addClass('active');}, 
		timeout: 250,  
		out: function() {
    	 	var $this = $(this);
			var $span = $this.children('.menu-title');
			$this.find('.currencydropmenu').slideUp('fast');
			$span.removeClass('active');
		}  
	});
});
