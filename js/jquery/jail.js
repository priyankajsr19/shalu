;(function($){
	var $window = $(window);

	$.fn.asynchImageLoader = $.fn.jail = function(options) {

		// Configuration
		options = $.extend({
			timeout : 10,
			effect : false,
			speed : 400,
			selector: null,
			offset : 0,
			event : 'load+scroll',
			callback : jQuery.noop,
			callbackAfterEachImage : jQuery.noop,
			placeholder : false,
			container : window
		}, options);

		var images = this;
		
		$.jail.initialStack = this;

		// Store the selector into 'triggerEl' data for the images selected
		this.data('triggerEl', (options.selector) ? $(options.selector) : $window);
		
		// Use a placeholder in case it is specified
		if (options.placeholder !== false) {
			images.each(function(){
				$(this).attr("src", options.placeholder);
			});
		}

		// When the event is not specified the images will be loaded with a delay
		if(/^load/.test(options.event)) {
			$.asynchImageLoader.later.call(this, options);
		} else {
			$.asynchImageLoader.onEvent.call(this, options, images);
		}

		return this;
	};

	// Methods cointaing the logic
	$.asynchImageLoader = $.jail = {
	
		// Remove any elements that have been loaded from the jQuery stack.
		// This should speed up subsequent calls by not having to iterate over the loaded elements.
		_purgeStack : function(stack) {
			// number of images not loaded
			var i = 0;

			while(true) {
				if(i === stack.length) {
					break;
				} else {
					if(stack[i].getAttribute('data-href')) {
						i++;
					} else {
						stack.splice(i, 1);
					}
				}
			}
		},

		// Load the image - after the event is triggered on the image itself - no need
		// to check for visibility
		_loadOnEvent : function(e) {
			var $img = $(this),
			options = e.data.options,
			images = e.data.images;

			// Load images
			$.asynchImageLoader._loadImage(options, $img);

			// Image has been loaded so there is no need to listen anymore
			$img.unbind( options.event, $.asynchImageLoader._loadOnEvent );

			$.asynchImageLoader._purgeStack( images );
			
			if (!!options.callback) {
				$.asynchImageLoader._purgeStack( $.jail.initialStack );
				$.asynchImageLoader._launchCallback($.jail.initialStack, options);
			}
		},

		// Load the image - after the event is triggered by a DOM element different
		// from the images (options.selector value) or the event is "scroll" - 
		// visibility of the images is checked
		_bufferedEventListener : function(e) {
			var images = e.data.images,
			options = e.data.options,
			triggerEl = images.data('triggerEl');

			clearTimeout(images.data('poller'));
			images.data('poller', setTimeout(function() {
				images.each(function _imageLoader(){
					$.asynchImageLoader._loadImageIfVisible(options, this, triggerEl);
				});

				$.asynchImageLoader._purgeStack( images );
				
				if (!!options.callback) {
					$.asynchImageLoader._purgeStack( $.jail.initialStack );
					$.asynchImageLoader._launchCallback($.jail.initialStack, options);
				}
				
			}, options.timeout));
			
		},

		// Images loaded triggered by en event (event different from "load" or "load+scroll")
		onEvent : function(options, images) {
			images = images || this;

			if (options.event === 'scroll' || options.selector) {
				var triggerEl = images.data('triggerEl');

				if(images.length > 0) {

					// Bind the event to the selector specified in the config obj
					triggerEl.bind( options.event, { images:images, options:options }, $.asynchImageLoader._bufferedEventListener );
					
					if (options.event === 'scroll' || !options.selector) {
						$window.resize({ images:images, options:options }, $.asynchImageLoader._bufferedEventListener );
					}
					return;
				} else {
					if (!!triggerEl) {
						triggerEl.unbind( options.event, $.asynchImageLoader._bufferedEventListener );
					}
				}
			} else {
				// Bind the event to the images
				images.bind(options.event, { options:options, images:images }, $.asynchImageLoader._loadOnEvent);
			}
		},

		// Method called when event : "load" or "load+scroll" (default)
		later : function(options) {
			var images = this;

			// If the 'load' event is specified, immediately load all the visible images and remove them from the stack
			if (options.event === 'load') {
				images.each(function(){
					$.asynchImageLoader._loadImageIfVisible(options, this, images.data('triggerEl'));
				});
			}
			$.asynchImageLoader._purgeStack(images);
			
			$.asynchImageLoader._launchCallback(images, options);
			
			// After [timeout] has elapsed, load the remaining images if they are visible OR (if no event is specified)
			setTimeout(function() {

				if (options.event === 'load') {
					images.each(function(){
						$.asynchImageLoader._loadImage(options, $(this));
					});
				} else {
					// Method : "load+scroll"
					images.each(function(){
						$.asynchImageLoader._loadImageIfVisible(options, this, images.data('triggerEl'));
					});
				}

				$.asynchImageLoader._purgeStack( images );
				
				$.asynchImageLoader._launchCallback(images, options);

				if (options.event === 'load+scroll') {
					options.event = 'scroll';
					$.asynchImageLoader.onEvent( options, images );
				}
			}, options.timeout);
		},
		
		_launchCallback : function(images, options) {
			if (images.length === 0 && !$.jail.isCallback) {
					//Callback call
					options.callback.call(this, options);
					$.jail.isCallback = true;
			}
		},

		// Function that checks if the images have been loaded
		_loadImageIfVisible : function(options, image, triggerEl) {
			var $img = $(image),
			container = (/scroll/i.test(options.event)) ? triggerEl : $window;

			if ($.asynchImageLoader._isInTheScreen ($window, $img, options.offset)) {
				$.asynchImageLoader._loadImage(options, $img);
			}
			
		},

		// Function that returns true if the image is visible inside the "window" (or specified container element)
		_isInTheScreen : function($ct, $img, optionOffset) {
			var is_ct_window  = $ct[0] === window,
				ct_offset  = (is_ct_window ? { top:0, left:0 } : $ct.offset()),
				ct_top     = ct_offset.top + ( is_ct_window ? $ct.scrollTop() : 0),
				ct_left    = ct_offset.left + ( is_ct_window ? $ct.scrollLeft() : 0),
				ct_right   = ct_left + $ct.width(),
				ct_bottom  = ct_top + $ct.height(),
				img_offset = $img.offset(),
				img_width = $img.width(),
				img_height = $img.height();
			
			return (ct_top - optionOffset) <= (img_offset.top + img_height) &&
				(ct_bottom + optionOffset) >= img_offset.top &&
					(ct_left - optionOffset)<= (img_offset.left + img_width) &&
						(ct_right + optionOffset) >= img_offset.left;
		},

		// Main function --> Load the images copying the "data-href" attribute into the "src" attribute
		_loadImage : function(options, $img) {

			$img.hide();
			$img.attr("src", $img.attr("data-href"));
			$img.removeAttr('data-href');

			// Images loaded with some effect if existing
			if(options.effect) {
				if (options.speed) {
					$img[options.effect](options.speed);
				} else {
					$img[options.effect]();
				}
			} else {
				$img.show();
			}
			
			// Callback after each image is loaded
			options.callbackAfterEachImage.call(this, $img, options);
		}
	};
}(jQuery));