

/*
*  input.js
*
*  All javascript needed for ACF to work
*
*  @type	awesome
*  @date	1/08/13
*
*  @param	N/A
*  @return	N/A
*/ 

var acf = {
	
	// vars
	ajaxurl				:	'',
	admin_url			:	'',
	wp_version			:	'',
	post_id				:	0,
	nonce				:	'',
	l10n				:	null,
	o					:	null,
	
	// helper functions
	helpers				:	{
		get_atts		: 	null,
		version_compare	:	null,
		uniqid			:	null,
		sortable		:	null,
		add_message		:	null,
		is_clone_field	:	null,
		url_to_object	:	null
	},
	
	
	// modules
	validation			:	null,
	conditional_logic	:	null,
	media				:	null,
	
	
	// fields
	fields				:	{
		date_picker		:	null,
		color_picker	:	null,
		Image			:	null,
		file			:	null,
		wysiwyg			:	null,
		gallery			:	null,
		relationship	:	null
	}
};

(function($){
	
	
	/*
	*  acf.helpers.isset
	*
	*  description
	*
	*  @type	function
	*  @date	20/07/13
	*
	*  @param	{mixed}		arguments
	*  @return	{boolean}	
	*/
	
	acf.helpers.isset = function(){
		
		var a = arguments,
	        l = a.length,
	        c = null,
	        undef;
		
	    if (l === 0) {
	        throw new Error('Empty isset');
	    }
		
		c = a[0];
		
	    for (i = 1; i < l; i++) {
	    	
	        if (a[i] === undef || c[ a[i] ] === undef) {
	            return false;
	        }
	        
	        c = c[ a[i] ];
	        
	    }
	    
	    return true;
			
	};
	
	
	/*
	*  acf.helpers.get_atts
	*
	*  description
	*
	*  @type	function
	*  @date	1/06/13
	*
	*  @param	{el}		$el
	*  @return	{object}	atts
	*/
	
	acf.helpers.get_atts = function( $el ){
		
		var atts = {};
		
		$.each( $el[0].attributes, function( index, attr ) {
        	
        	if( attr.name.substr(0, 5) == 'data-' )
        	{
	        	atts[ attr.name.replace('data-', '') ] = attr.value;
        	}
        });
        
        return atts;
			
	};
        
           
	/**
	 * Simply compares two string version values.
	 * 
	 * Example:
	 * versionCompare('1.1', '1.2') => -1
	 * versionCompare('1.1', '1.1') =>  0
	 * versionCompare('1.2', '1.1') =>  1
	 * versionCompare('2.23.3', '2.22.3') => 1
	 * 
	 * Returns:
	 * -1 = left is LOWER than right
	 *  0 = they are equal
	 *  1 = left is GREATER = right is LOWER
	 *  And FALSE if one of input versions are not valid
	 *
	 * @function
	 * @param {String} left  Version #1
	 * @param {String} right Version #2
	 * @return {Integer|Boolean}
	 * @author Alexey Bass (albass)
	 * @since 2011-07-14
	 */
	 
	acf.helpers.version_compare = function(left, right)
	{
	    if (typeof left + typeof right != 'stringstring')
	        return false;
	    
	    var a = left.split('.')
	    ,   b = right.split('.')
	    ,   i = 0, len = Math.max(a.length, b.length);
	        
	    for (; i < len; i++) {
	        if ((a[i] && !b[i] && parseInt(a[i]) > 0) || (parseInt(a[i]) > parseInt(b[i]))) {
	            return 1;
	        } else if ((b[i] && !a[i] && parseInt(b[i]) > 0) || (parseInt(a[i]) < parseInt(b[i]))) {
	            return -1;
	        }
	    }
	    
	    return 0;
	};
	
	
	/*
	*  Helper: uniqid
	*
	*  @description: 
	*  @since: 3.5.8
	*  @created: 17/01/13
	*/
	
	acf.helpers.uniqid = function()
    {
    	var newDate = new Date;
    	return newDate.getTime();
    };
    
    
    /*
	*  Helper: url_to_object
	*
	*  @description: 
	*  @since: 4.0.0
	*  @created: 17/01/13
	*/
	
    acf.helpers.url_to_object = function( url ){
	    
	    // vars
	    var obj = {},
	    	pairs = url.split('&');
	    
	    
		for( i in pairs )
		{
		    var split = pairs[i].split('=');
		    obj[decodeURIComponent(split[0])] = decodeURIComponent(split[1]);
		}
		
		return obj;
	    
    };
    
	
	/*
	*  Sortable Helper
	*
	*  @description: keeps widths of td's inside a tr
	*  @since 3.5.1
	*  @created: 10/11/12
	*/
	
	acf.helpers.sortable = function(e, ui)
	{
		ui.children().each(function(){
			$(this).width($(this).width());
		});
		return ui;
	};
	
	
	/*
	*  is_clone_field
	*
	*  @description: 
	*  @since: 3.5.8
	*  @created: 17/01/13
	*/
	
	acf.helpers.is_clone_field = function( input )
	{
		if( input.attr('name') && input.attr('name').indexOf('[acfcloneindex]') != -1 )
		{
			return true;
		}
		
		return false;
	};
	
	
	/*
	*  acf.helpers.add_message
	*
	*  @description: 
	*  @since: 3.2.7
	*  @created: 10/07/2012
	*/
	
	acf.helpers.add_message = function( message, div ){
		
		var message = $('<div class="acf-message-wrapper"><div class="message updated"><p>' + message + '</p></div></div>');
		
		div.prepend( message );
		
		setTimeout(function(){
			
			message.animate({
				opacity : 0
			}, 250, function(){
				message.remove();
			});
			
		}, 1500);
			
	};
	
	
	/*
	*  Exists
	*
	*  @description: returns true / false		
	*  @created: 1/03/2011
	*/
	
	$.fn.exists = function()
	{
		return $(this).length>0;
	};
	
	
	/*
	*  3.5 Media
	*
	*  @description: 
	*  @since: 3.5.7
	*  @created: 16/01/13
	*/
	
	acf.media = {
	
		div : null,
		frame : null,
		render_timout : null,
		
		clear_frame : function(){
			
			// validate
			if( !this.frame )
			{
				return;
			}
			
			
			// detach
			this.frame.detach();
			this.frame.dispose();
			
			
			// reset var
			this.frame = null;
			
		},
		type : function(){
			
			// default
			var type = 'thickbox';
			
			
			// if wp exists
			if( typeof wp !== 'undefined' )
			{
				type = 'backbone';
			}
			
			
			// return
			return type;
			
		},
		init : function(){
			
			// validate
			if( this.type() !== 'backbone' )
			{
				return false;
			}
			
			
			// validate prototype
			if( ! acf.helpers.isset(wp, 'media', 'view', 'AttachmentCompat', 'prototype') )
			{
				return false;	
			}
			
			
			// vars
			var _prototype = wp.media.view.AttachmentCompat.prototype;
			
			
			// orig
			_prototype.orig_render = _prototype.render;
			_prototype.orig_dispose = _prototype.dispose;
			
			
			// update class
			_prototype.className = 'compat-item acf_postbox no_box';
			
			
			// modify render
			_prototype.render = function() {
				
				// reference
				var _this = this;
				
				
				// validate
				if( _this.ignore_render )
				{
					return this;	
				}
				
				
				// run the old render function
				this.orig_render();
				
				
				// add button
				setTimeout(function(){
					
					// vars
					var $media_model = _this.$el.closest('.media-modal');
					
					
					// is this an edit only modal?
					if( $media_model.hasClass('acf-media-modal') )
					{
						return;	
					}
					
					
					// does button already exist?
					if( $media_model.find('.media-frame-router .acf-expand-details').exists() )
					{
						return;	
					}
					
					
					// create button
					var button = $([
						'<a href="#" class="acf-expand-details">',
							'<span class="icon"></span>',
							'<span class="is-closed">' + acf.l10n.core.expand_details +  '</span>',
							'<span class="is-open">' + acf.l10n.core.collapse_details +  '</span>',
						'</a>'
					].join('')); 
					
					
					// add events
					button.on('click', function( e ){
						
						e.preventDefault();
						
						if( $media_model.hasClass('acf-expanded') )
						{
							$media_model.removeClass('acf-expanded');
						}
						else
						{
							$media_model.addClass('acf-expanded');
						}
						
					});
					
					
					// append
					$media_model.find('.media-frame-router').append( button );
						
				
				}, 0);
				
				
				// setup fields
				// The clearTimout is needed to prevent many setup functions from running at the same time
				clearTimeout( acf.media.render_timout );
				acf.media.render_timout = setTimeout(function(){

					$(document).trigger( 'acf/setup_fields', [ _this.$el ] );
					
				}, 50);

				
				// return based on the origional render function
				return this;
			};
			
			
			// modify dispose
			_prototype.dispose = function() {
				
				// remove
				$(document).trigger('acf/remove_fields', [ this.$el ]);
				
				
				// run the old render function
				this.orig_dispose();
				
			};
			
			
			// override save
			_prototype.save = function( event ) {
			
				var data = {},
					names = {};
				
				if ( event )
					event.preventDefault();
					
					
				_.each( this.$el.serializeArray(), function( pair ) {
				
					// initiate name
					if( pair.name.slice(-2) === '[]' )
					{
						// remove []
						pair.name = pair.name.replace('[]', '');
						
						
						// initiate counter
						if( typeof names[ pair.name ] === 'undefined'){
							
							names[ pair.name ] = -1;
							//console.log( names[ pair.name ] );
							
						}
						
						
						names[ pair.name ]++
						
						pair.name += '[' + names[ pair.name ] +']';
						
						
					}
 
					data[ pair.name ] = pair.value;
				});
 
				this.ignore_render = true;
				this.model.saveCompat( data );
				
			};
		}
	};
	
	
	/*
	*  Conditional Logic Calculate
	*
	*  @description: 
	*  @since 3.5.1
	*  @created: 15/10/12
	*/
	
	acf.conditional_logic = {
		
		items : [],
		
		init : function(){
			
			// reference
			var _this = this;
			
			
			// events
			$(document).on('change', '.field input, .field textarea, .field select', function(){
				
				// preview hack
				if( $('#acf-has-changed').exists() )
				{
					$('#acf-has-changed').val(1);
				}
				
				_this.change( $(this) );
				
			});
			
			
			$(document).on('acf/setup_fields', function(e, el){
				
				//console.log('acf/setup_fields calling acf.conditional_logic.refresh()');
				_this.refresh( $(el) );
				
			});
			
			//console.log('acf.conditional_logic.init() calling acf.conditional_logic.refresh()');
			_this.refresh();
			
		},
		change : function( $el ){
			
			//console.log('change %o', $el);
			// reference
			var _this = this;
			
			
			// vars
			var $field = $el.closest('.field'),
				key = $field.attr('data-field_key');
			
			
			// loop through items and find rules where this field key is a trigger
			$.each(this.items, function( k, item ){
				
				$.each(item.rules, function( k2, rule ){
					
					// compare rule against the changed $field
					if( rule.field == key )
					{
						_this.refresh_field( item );
					}
					
				});
				
			});
			
		},
		
		refresh_field : function( item ){
			
			//console.log( 'refresh_field: %o ', item );
			// reference
			var _this = this;
			
			
			// vars
			var $targets	=	$('.field_key-' + item.field);

			
			// may be multiple targets (sub fields)
			$targets.each(function(){
				
				//console.log('target %o', $(this));
				
				// vars
				var show = true;
				
				
				// if 'any' was selected, start of as false and any match will result in show = true
				if( item.allorany == 'any' )
				{
					show = false;
				}
				
				
				// vars
				var $target		=	$(this),
					hide_all	=	true;
				
				
				// loop through rules
				$.each(item.rules, function( k2, rule ){
					
					// vars
					var $toggle = $('.field_key-' + rule.field);
					
					
					// are any of $toggle a sub field?
					if( $toggle.hasClass('sub_field') )
					{
						// toggle may be a sibling sub field.
						// if so ,show an empty td but keep the column
						$toggle = $target.siblings('.field_key-' + rule.field);
						hide_all = false;
						
						
						// if no toggle was found, we need to look at parent sub fields.
						// if so, hide the entire column
						if( ! $toggle.exists() )
						{
							// loop through all the parents that could contain sub fields
							$target.parents('tr').each(function(){
								
								// attempt to update $toggle to this parent sub field
								$toggle = $(this).find('.field_key-' + rule.field)
								
								// if the parent sub field actuallly exists, great! Stop the loop
								if( $toggle.exists() )
								{
									return false;
								}
								
							});

							hide_all = true;
						}
						
					}
					
					
					// if this sub field is within a flexible content layout, hide the entire column because 
					// there will never be another row added to this table
					var parent = $target.parent('tr').parent().parent('table').parent('.layout');
					if( parent.exists() )
					{
						hide_all = true;
						
						if( $target.is('th') && $toggle.is('th') )
						{
							$toggle = $target.closest('.layout').find('td.field_key-' + rule.field);
						}

					}
					
					// if this sub field is within a repeater field which has a max row of 1, hide the entire column because 
					// there will never be another row added to this table
					var parent = $target.parent('tr').parent().parent('table').parent('.repeater');
					if( parent.exists() && parent.attr('data-max_rows') == '1' )
					{
						hide_all = true;
						
						if( $target.is('th') && $toggle.is('th') )
						{
							$toggle = $target.closest('table').find('td.field_key-' + rule.field);
						}

					}
					
					
					var calculate = _this.calculate( rule, $toggle, $target );
					
					if( item.allorany == 'all' )
					{
						if( calculate == false )
						{
							show = false;
							
							// end loop
							return false;
						}
					}
					else
					{
						if( calculate == true )
						{
							show = true;
							
							// end loop
							return false;
						}
					}
					
				});
				// $.each(item.rules, function( k2, rule ){
				
				
				// clear classes
				$target.removeClass('acf-conditional_logic-hide acf-conditional_logic-show acf-show-blank');
				
				
				// hide / show field
				if( show )
				{
					// remove "disabled"
					$target.find('input, textarea, select').removeAttr('disabled');
					
					$target.addClass('acf-conditional_logic-show');
					
					// hook
					$(document).trigger('acf/conditional_logic/show', [ $target, item ]);
					
				}
				else
				{
					// add "disabled"
					$target.find('input, textarea, select').attr('disabled', 'disabled');
					
					$target.addClass('acf-conditional_logic-hide');
					
					if( !hide_all )
					{
						$target.addClass('acf-show-blank');
					}
					
					// hook
					$(document).trigger('acf/conditional_logic/hide', [ $target, item ]);
				}
				
				
			});
			
		},
		
		refresh : function( $el ){
			
			// defaults
			$el = $el || $('body');
			
			
			// reference
			var _this = this;
			
			
			// loop through items and find rules where this field key is a trigger
			$.each(this.items, function( k, item ){
				
				$.each(item.rules, function( k2, rule ){
					
					// is this field within the $el
					// this will increase performance by ignoring conditional logic outside of this newly appended element ($el)
					if( ! $el.find('.field[data-field_key="' + item.field + '"]').exists() )
					{
						return;
					}
					
					_this.refresh_field( item );
					
				});
				
			});
			
		},
		
		calculate : function( rule, $toggle, $target ){
			
			// vars
			var r = false;
			

			// compare values
			if( $toggle.hasClass('field_type-true_false') || $toggle.hasClass('field_type-checkbox') || $toggle.hasClass('field_type-radio') )
			{
				var exists = $toggle.find('input[value="' + rule.value + '"]:checked').exists();
				
				
				if( rule.operator == "==" )
				{
					if( exists )
					{
						r = true;
					}
				}
				else
				{
					if( ! exists )
					{
						r = true;
					}
				}
				
			}
			else
			{
				// get val and make sure it is an array
				var val = $toggle.find('input, textarea, select').last().val();
				
				if( ! $.isArray(val) )
				{
					val = [ val ];
				}
				
				
				if( rule.operator == "==" )
				{
					if( $.inArray(rule.value, val) > -1 )
					{
						r = true;
					}
				}
				else
				{
					if( $.inArray(rule.value, val) < 0 )
					{
						r = true;
					}
				}
				
			}
			
			
			// return
			return r;
			
		}
		
	};
	
	
	
	
		
	/*
	*  Document Ready
	*
	*  @description: 
	*  @since: 3.5.8
	*  @created: 17/01/13
	*/
	
	$(document).ready(function(){
		
		
		// conditional logic
		acf.conditional_logic.init();
		
		
		// fix for older options page add-on
		$('.acf_postbox > .inside > .options').each(function(){
			
			$(this).closest('.acf_postbox').addClass( $(this).attr('data-layout') );
			
		});
		
		
		// Remove 'field_123' from native custom field metabox
		$('#metakeyselect option[value^="field_"]').remove();
		
	
	});
	
	
	/*
	*  window load
	*
	*  @description: 
	*  @since: 3.5.5
	*  @created: 22/12/12
	*/
	
	$(window).load(function(){
		
		// init
		acf.media.init();
		
		
		setTimeout(function(){
			
			// Hack for CPT without a content editor
			try
			{
				// post_id may be string (user_1) and therefore, the uploaded image cannot be attached to the post
				if( $.isNumeric(acf.o.post_id) )
				{
					wp.media.view.settings.post.id = acf.o.post_id;
				}
				
			} 
			catch(e)
			{
				// one of the objects was 'undefined'...
			}
			
			
			// setup fields
			$(document).trigger('acf/setup_fields', [ $('#poststuff') ]);
			
		}, 10);
		
	});
	
	
	/*
	*  Gallery field Add-on Fix
	*
	*  Gallery field v1.0.0 required some data in the acf object.
	*  Now not required, but older versions of gallery field need this.
	*
	*  @type	object
	*  @date	1/08/13
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	acf.fields.gallery = {
		add : function(){},
		edit : function(){},
		update_count : function(){},
		hide_selected_items : function(){},
		text : {
			title_add : "Select Images"
		}
	};
	
		
	
})(jQuery);

(function($){
	
	
	/*
	*  acf.screen
	*
	*  Data used by AJAX to hide / show field groups
	*
	*  @type	object
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	acf.screen = {
		action 			:	'acf/location/match_field_groups_ajax',
		post_id			:	0,
		page_template	:	0,
		page_parent		:	0,
		page_type		:	0,
		post_category	:	0,
		post_format		:	0,
		taxonomy		:	0,
		lang			:	0,
		nonce			:	0
	};
	
	
	/*
	*  Document Ready
	*
	*  Updates acf.screen with more data
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).ready(function(){
		
		
		// update post_id
		acf.screen.post_id = acf.o.post_id;
		acf.screen.nonce = acf.o.nonce;
		
		
		// MPML
		if( $('#icl-als-first').length > 0 )
		{
			var href = $('#icl-als-first').children('a').attr('href'),
				regex = new RegExp( "lang=([^&#]*)" ),
				results = regex.exec( href );
			
			// lang
			acf.screen.lang = results[1];
			
		}
		
	});
	
	
	/*
	*  acf/update_field_groups
	*
	*  finds the new id's for metaboxes and show's hides metaboxes
	*
	*  @type	event
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('acf/update_field_groups', function(){
		
		// Only for a post.
		// This is an attempt to stop the action running on the options page add-on.
		if( ! acf.screen.post_id || ! $.isNumeric(acf.screen.post_id) )
		{
			return false;	
		}
		
		
		$.ajax({
			url: ajaxurl,
			data: acf.screen,
			type: 'post',
			dataType: 'json',
			success: function(result){
				
				// validate
				if( !result )
				{
					return false;
				}
				
				
				// hide all metaboxes
				$('.acf_postbox').addClass('acf-hidden');
				$('.acf_postbox-toggle').addClass('acf-hidden');
		
				
				// dont bother loading style or html for inputs
				if( result.length == 0 )
				{
					return false;
				}
				
				
				// show the new postboxes
				$.each(result, function(k, v) {
					
					
					// vars
					var $el = $('#acf_' + v),
						$toggle = $('#adv-settings .acf_postbox-toggle[for="acf_' + v + '-hide"]');
					
					
					// classes
					$el.removeClass('acf-hidden hide-if-js');
					$toggle.removeClass('acf-hidden');
					$toggle.find('input[type="checkbox"]').attr('checked', 'checked');
					
					
					// load fields if needed
					$el.find('.acf-replace-with-fields').each(function(){
						
						var $replace = $(this);
						
						$.ajax({
							url			:	ajaxurl,
							data		:	{
								action	:	'acf/post/render_fields',
								acf_id	:	v,
								post_id	:	acf.o.post_id,
								nonce	:	acf.o.nonce
							},
							type		:	'post',
							dataType	:	'html',
							success		:	function( html ){
							
								$replace.replaceWith( html );
								
								$(document).trigger('acf/setup_fields', $el);
								
							}
						});
						
					});
				});
				
				
				// load style
				$.ajax({
					url			:	ajaxurl,
					data		:	{
						action	:	'acf/post/get_style',
						acf_id	:	result[0],
						nonce	:	acf.o.nonce
					},
					type		: 'post',
					dataType	: 'html',
					success		: function( result ){
					
						$('#acf_style').html( result );
						
					}
				});
				
				
				
			}
		});
	});

	
	/*
	*  Events
	*
	*  Updates acf.screen with more data and triggers the update event
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('change', '#page_template', function(){
		
		acf.screen.page_template = $(this).val();
		
		$(document).trigger('acf/update_field_groups');
	    
	});
	
	
	$(document).on('change', '#parent_id', function(){
		
		var val = $(this).val();
		
		
		// set page_type / page_parent
		if( val != "" )
		{
			acf.screen.page_type = 'child';
			acf.screen.page_parent = val;
		}
		else
		{
			acf.screen.page_type = 'parent';
			acf.screen.page_parent = 0;
		}
		
		
		$(document).trigger('acf/update_field_groups');
	    
	});

	
	$(document).on('change', '#post-formats-select input[type="radio"]', function(){
		
		var val = $(this).val();
		
		if( val == '0' )
		{
			val = 'standard';
		}
		
		acf.screen.post_format = val;
		
		$(document).trigger('acf/update_field_groups');
		
	});	
	
	
	function _sync_taxonomy_terms() {
		
		// vars
		var values = [];
		
		
		$('.categorychecklist input:checked, .acf-taxonomy-field input:checked, .acf-taxonomy-field option:selected').each(function(){
			
			// validate
			if( $(this).is(':hidden') || $(this).is(':disabled') )
			{
				return;
			}
			
			
			// validate media popup
			if( $(this).closest('.media-frame').exists() )
			{
				return;
			}
			
			
			// validate acf
			if( $(this).closest('.acf-taxonomy-field').exists() )
			{
				if( $(this).closest('.acf-taxonomy-field').attr('data-load_save') == '0' )
				{
					return;
				}
			}
			
			
			// append
			if( values.indexOf( $(this).val() ) === -1 )
			{
				values.push( $(this).val() );
			}
			
		});

		
		// update screen
		acf.screen.post_category = values;
		acf.screen.taxonomy = values;

		
		// trigger change
		$(document).trigger('acf/update_field_groups');
			
	}
	
	
	$(document).on('change', '.categorychecklist input, .acf-taxonomy-field input, .acf-taxonomy-field select', function(){
		
		// a taxonomy field may trigger this change event, however, the value selected is not
		// actually a term relatinoship, it is meta data
		if( $(this).closest('.acf-taxonomy-field').exists() )
		{
			if( $(this).closest('.acf-taxonomy-field').attr('data-save') == '0' )
			{
				return;
			}
		}
		
		
		// this may be triggered from editing an imgae in a popup. Popup does not support correct metaboxes so ignore this
		if( $(this).closest('.media-frame').exists() )
		{
			return;
		}
		
		
		// set timeout to fix issue with chrome which does not register the change has yet happened
		setTimeout(function(){
			
			_sync_taxonomy_terms();
		
		}, 1);
		
		
	});
	
	
	
	
})(jQuery);

(function($){
	
	/*
	*  Color Picker
	*
	*  jQuery functionality for this field type
	*
	*  @type	object
	*  @date	20/07/13
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	var _cp = acf.fields.color_picker = {
		
		$el : null,
		$input : null,
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('input[type="text"]');
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){
			
			// vars (reference)
			var $input = this.$input;
			
			
			// is clone field?
			if( acf.helpers.is_clone_field($input) )
			{
				return;
			}
			
			
			this.$input.wpColorPicker();
			
			
			
		}
	};
	
	
	/*
	*  acf/setup_fields
	*
	*  run init function on all elements for this field
	*
	*  @type	event
	*  @date	20/07/13
	*
	*  @param	{object}	e		event object
	*  @param	{object}	el		DOM object which may contain new ACF elements
	*  @return	N/A
	*/
	
	$(document).on('acf/setup_fields', function(e, el){
		
		$(el).find('.acf-color_picker').each(function(){
			
			_cp.set({ $el : $(this) }).init();
			
		});
		
	});
		

})(jQuery);

(function($){
	
	/*
	*  Date Picker
	*
	*  static model for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	acf.fields.date_picker = {
		
		$el : null,
		$input : null,
		$hidden : null,
		
		o : {},
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('input[type="text"]');
			this.$hidden = this.$el.find('input[type="hidden"]');
			
			
			// get options
			this.o = acf.helpers.get_atts( this.$el );
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){

			// is clone field?
			if( acf.helpers.is_clone_field(this.$hidden) )
			{
				return;
			}
			
			
			// get and set value from alt field
			this.$input.val( this.$hidden.val() );
			
			
			// create options
			var options = $.extend( {}, acf.l10n.date_picker, { 
				dateFormat		:	this.o.save_format,
				altField		:	this.$hidden,
				altFormat		:	this.o.save_format,
				changeYear		:	true,
				yearRange		:	"-100:+100",
				changeMonth		:	true,
				showButtonPanel	:	true,
				firstDay		:	this.o.first_day
			});
			
			
			// add date picker
			this.$input.addClass('active').datepicker( options );
			
			
			// now change the format back to how it should be.
			this.$input.datepicker( "option", "dateFormat", this.o.display_format );
			
			
			// wrap the datepicker (only if it hasn't already been wrapped)
			if( $('body > #ui-datepicker-div').length > 0 )
			{
				$('#ui-datepicker-div').wrap('<div class="ui-acf" />');
			}
			
		},
		blur : function(){
			
			if( !this.$input.val() )
			{
				this.$hidden.val('');
			}
			
		}
		
	};
	
	
	/*
	*  acf/setup_fields
	*
	*  run init function on all elements for this field
	*
	*  @type	event
	*  @date	20/07/13
	*
	*  @param	{object}	e		event object
	*  @param	{object}	el		DOM object which may contain new ACF elements
	*  @return	N/A
	*/
	
	$(document).on('acf/setup_fields', function(e, el){
		
		$(el).find('.acf-date_picker').each(function(){
			
			acf.fields.date_picker.set({ $el : $(this) }).init();
			
		});
		
	});
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	$(document).on('blur', '.acf-date_picker input[type="text"]', function( e ){
		
		acf.fields.date_picker.set({ $el : $(this).parent() }).blur();
					
	});
	

})(jQuery);

(function($){
	
	/*
	*  File
	*
	*  static model for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	
	// reference
	var _media = acf.media;
	
	
	acf.fields.file = {
		
		$el : null,
		$input : null,
		
		o : {},
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('input[type="hidden"]');
			
			
			// get options
			this.o = acf.helpers.get_atts( this.$el );
			
			
			// multiple?
			this.o.multiple = this.$el.closest('.repeater').exists() ? true : false;
			
			
			// wp library query
			this.o.query = {};
			
			
			// library
			if( this.o.library == 'uploadedTo' )
			{
				this.o.query.uploadedTo = acf.o.post_id;
			}
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){

			// is clone field?
			if( acf.helpers.is_clone_field(this.$input) )
			{
				return;
			}
					
		},
		add : function( file ){
			
			// this function must reference a global div variable due to the pre WP 3.5 uploader
			// vars
			var div = _media.div;
			
			
			// set atts
			div.find('.acf-file-icon').attr( 'src', file.icon );
		 	div.find('.acf-file-title').text( file.title );
		 	div.find('.acf-file-name').text( file.name ).attr( 'href', file.url );
		 	div.find('.acf-file-size').text( file.size );
			div.find('.acf-file-value').val( file.id ).trigger('change');
		 	
		 	
		 	// set div class
		 	div.addClass('active');
		 	
		 	
		 	// validation
			div.closest('.field').removeClass('error');
	
		},
		edit : function(){
			
			// vars
			var id = this.$input.val();
			
			
			// set global var
			_media.div = this.$el;
			

			// clear the frame
			_media.clear_frame();
			
			
			// create the media frame
			_media.frame = wp.media({
				title		:	acf.l10n.file.edit,
				multiple	:	false,
				button		:	{ text : acf.l10n.file.update }
			});
			
			
			// log events
			/*
			acf.media.frame.on('all', function(e){
				
				console.log( e );
				
			});
			*/
			
			
			// open
			_media.frame.on('open',function() {
				
				// set to browse
				if( _media.frame.content._mode != 'browse' )
				{
					_media.frame.content.mode('browse');
				}
				
				
				// add class
				_media.frame.$el.closest('.media-modal').addClass('acf-media-modal acf-expanded');
					
				
				// set selection
				var selection	=	_media.frame.state().get('selection'),
					attachment	=	wp.media.attachment( id );
				
				
				// to fetch or not to fetch
				if( $.isEmptyObject(attachment.changed) )
				{
					attachment.fetch();
				}
				

				selection.add( attachment );
						
			});
			
			
			// close
			_media.frame.on('close',function(){
			
				// remove class
				_media.frame.$el.closest('.media-modal').removeClass('acf-media-modal');
				
			});
			
							
			// Finally, open the modal
			acf.media.frame.open();
			
		},
		remove : function()
		{
			
			// set atts
			this.$el.find('.acf-file-icon').attr( 'src', '' );
			this.$el.find('.acf-file-title').text( '' );
		 	this.$el.find('.acf-file-name').text( '' ).attr( 'href', '' );
		 	this.$el.find('.acf-file-size').text( '' );
			this.$el.find('.acf-file-value').val( '' ).trigger('change');
			
			
			// remove class
			this.$el.removeClass('active');
			
		},
		popup : function()
		{
			// reference
			var t = this;
			
			
			// set global var
			_media.div = this.$el;
			

			// clear the frame
			_media.clear_frame();
			
			
			 // Create the media frame
			 _media.frame = wp.media({
				states : [
					new wp.media.controller.Library({
						library		:	wp.media.query( t.o.query ),
						multiple	:	t.o.multiple,
						title		:	acf.l10n.file.select,
						priority	:	20,
						filterable	:	'all'
					})
				]
			});
			
			
			// customize model / view
			acf.media.frame.on('content:activate', function(){
				
				// vars
				var toolbar = null,
					filters = null;
					
				
				// populate above vars making sure to allow for failure
				try
				{
					toolbar = acf.media.frame.content.get().toolbar;
					filters = toolbar.get('filters');
				} 
				catch(e)
				{
					// one of the objects was 'undefined'... perhaps the frame open is Upload Files
					//console.log( e );
				}
				
				
				// validate
				if( !filters )
				{
					return false;
				}
				
				
				// no need for 'uploaded' filter
				if( t.o.library == 'uploadedTo' )
				{
					filters.$el.find('option[value="uploaded"]').remove();
					filters.$el.after('<span>' + acf.l10n.file.uploadedTo + '</span>')
					
					$.each( filters.filters, function( k, v ){
						
						v.props.uploadedTo = acf.o.post_id;
						
					});
				}
								
			});
			
			
			// When an image is selected, run a callback.
			acf.media.frame.on( 'select', function() {
				
				// get selected images
				selection = _media.frame.state().get('selection');
				
				if( selection )
				{
					var i = 0;
					
					selection.each(function(attachment){
	
				    	// counter
				    	i++;
				    	
				    	
				    	// select / add another file field?
				    	if( i > 1 )
						{
							// vars
							var $td			=	_media.div.closest('td'),
								$tr 		=	$td.closest('.row'),
								$repeater 	=	$tr.closest('.repeater'),
								key 		=	$td.attr('data-field_key'),
								selector	=	'td .acf-file-uploader:first';
								
							
							// key only exists for repeater v1.0.1 +
							if( key )
							{
								selector = 'td[data-field_key="' + key + '"] .acf-file-uploader';
							}
							
							
							// add row?
							if( ! $tr.next('.row').exists() )
							{
								$repeater.find('.add-row-end').trigger('click');
								
							}
							
							
							// update current div
							_media.div = $tr.next('.row').find( selector );
							
						}
												
						
				    	// vars
				    	var file = {
					    	id		:	attachment.id,
					    	title	:	attachment.attributes.title,
					    	name	:	attachment.attributes.filename,
					    	url		:	attachment.attributes.url,
					    	icon	:	attachment.attributes.icon,
					    	size	:	attachment.attributes.filesize
				    	};
				    	
				    	
				    	// add file to field
				        acf.fields.file.add( file );
				        
						
				    });
				    // selection.each(function(attachment){
				}
				// if( selection )
				
			});
			// acf.media.frame.on( 'select', function() {
					 
				
			// Finally, open the modal
			acf.media.frame.open();
				
			
			return false;
		}
		
	};
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('click', '.acf-file-uploader .acf-button-edit', function( e ){
		
		e.preventDefault();
		
		acf.fields.file.set({ $el : $(this).closest('.acf-file-uploader') }).edit();
			
	});
	
	$(document).on('click', '.acf-file-uploader .acf-button-delete', function( e ){
		
		e.preventDefault();
		
		acf.fields.file.set({ $el : $(this).closest('.acf-file-uploader') }).remove();
			
	});
	
	
	$(document).on('click', '.acf-file-uploader .add-file', function( e ){
		
		e.preventDefault();
		
		acf.fields.file.set({ $el : $(this).closest('.acf-file-uploader') }).popup();
		
	});
	

})(jQuery);

(function($){
	
	/*
	*  Location
	*
	*  static model for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	acf.fields.google_map = {
		
		$el : null,
		$input : null,
		
		o : {},
		
		ready : false,
		geocoder : false,
		map : false,
		maps : {},
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('.value');
			
			
			// get options
			this.o = acf.helpers.get_atts( this.$el );
			
			
			// get map
			if( this.maps[ this.o.id ] )
			{
				this.map = this.maps[ this.o.id ];
			}
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){
			
			// geocode
			if( !this.geocoder )
			{
				this.geocoder = new google.maps.Geocoder();
			}
			
			
			// google maps is loaded and ready
			this.ready = true;
			
			
			// is clone field?
			if( acf.helpers.is_clone_field(this.$input) )
			{
				return;
			}
			
			this.render();
					
		},
		render : function(){
			
			// reference
			var _this	= this,
				_$el	= this.$el;
			
			
			// vars
			var args = {
        		zoom		: parseInt(this.o.zoom),
        		center		: new google.maps.LatLng(this.o.lat, this.o.lng),
        		mapTypeId	: google.maps.MapTypeId.ROADMAP
        	};
			
			// create map	        	
        	this.map = new google.maps.Map( this.$el.find('.canvas')[0], args);
	        
	        
	        // add search
			var autocomplete = new google.maps.places.Autocomplete( this.$el.find('.search')[0] );
			autocomplete.map = this.map;
			autocomplete.bindTo('bounds', this.map);
			
			
			// add dummy marker
	        this.map.marker = new google.maps.Marker({
		        draggable	: true,
		        raiseOnDrag	: true,
		        map			: this.map,
		    });
		    
		    
		    // add references
		    this.map.$el = this.$el;
		    
		    
		    // value exists?
		    var lat = this.$el.find('.input-lat').val(),
		    	lng = this.$el.find('.input-lng').val();
		    
		    if( lat && lng )
		    {
			    this.update( lat, lng ).center();
		    }
		    
		    
			// events
			google.maps.event.addListener(autocomplete, 'place_changed', function( e ) {
			    
			    // reference
			    var $el = this.map.$el;


			    // manually update address
			    var address = $el.find('.search').val();
			    $el.find('.input-address').val( address );
			    $el.find('.title h4').text( address );
			    
			    
			    // vars
			    var place = this.getPlace();
			    
			    
			    // validate
			    if( place.geometry )
			    {
			    	var lat = place.geometry.location.lat(),
						lng = place.geometry.location.lng();
						
						
				    _this.set({ $el : $el }).update( lat, lng ).center();
			    }
			    else
			    {
				    // client hit enter, manulaly get the place
				    _this.geocoder.geocode({ 'address' : address }, function( results, status ){
				    	
				    	// validate
						if( status != google.maps.GeocoderStatus.OK )
						{
							console.log('Geocoder failed due to: ' + status);
							return;
						}
						
						if( !results[0] )
						{
							console.log('No results found');
							return;
						}
						
						
						// get place
						place = results[0];
						
						var lat = place.geometry.location.lat(),
							lng = place.geometry.location.lng();
							
							
					    _this.set({ $el : $el }).update( lat, lng ).center();
					    
					});
			    }
			    
			});
		    
		    
		    google.maps.event.addListener( this.map.marker, 'dragend', function(){
		    	
		    	// reference
			    var $el = this.map.$el;
			    
			    
		    	// vars
				var position = this.map.marker.getPosition(),
					lat = position.lat(),
			    	lng = position.lng();
			    	
				_this.set({ $el : $el }).update( lat, lng ).sync();
			    
			});
			
			
			google.maps.event.addListener( this.map, 'click', function( e ) {
				
				// reference
			    var $el = this.$el;
			    
			    
				// vars
				var lat = e.latLng.lat(),
					lng = e.latLng.lng();
				
				
				_this.set({ $el : $el }).update( lat, lng ).sync();
			
			});

			
			
	        // add to maps
	        this.maps[ this.o.id ] = this.map;
	        
	        
		},
		
		update : function( lat, lng ){
			
			// vars
			var latlng = new google.maps.LatLng( lat, lng );
		    
		    
		    // update inputs
			this.$el.find('.input-lat').val( lat );
			this.$el.find('.input-lng').val( lng ).trigger('change');
			
			
		    // update marker
		    this.map.marker.setPosition( latlng );
		    
		    
			// show marker
			this.map.marker.setVisible( true );
		    
		    
	        // update class
	        this.$el.addClass('active');
	        
	        
	        // validation
			this.$el.closest('.field').removeClass('error');
			
			
	        // return for chaining
	        return this;
		},
		
		center : function(){
			
			// vars
			var position = this.map.marker.getPosition(),
				lat = this.o.lat,
				lng = this.o.lng;
			
			
			// if marker exists, center on the marker
			if( position )
			{
				lat = position.lat();
				lng = position.lng();
			}
			
			
			var latlng = new google.maps.LatLng( lat, lng );
				
			
			// set center of map
	        this.map.setCenter( latlng );
		},
		
		sync : function(){
			
			// reference
			var $el	= this.$el;
				
			
			// vars
			var position = this.map.marker.getPosition(),
				latlng = new google.maps.LatLng( position.lat(), position.lng() );
			
			
			this.geocoder.geocode({ 'latLng' : latlng }, function( results, status ){
				
				// validate
				if( status != google.maps.GeocoderStatus.OK )
				{
					console.log('Geocoder failed due to: ' + status);
					return;
				}
				
				if( !results[0] )
				{
					console.log('No results found');
					return;
				}
				
				
				// get location
				var location = results[0];
				
				
				// update h4
				$el.find('.title h4').text( location.formatted_address );

				
				// update input
				$el.find('.input-address').val( location.formatted_address ).trigger('change');
				
			});
			
			
			// return for chaining
	        return this;
		},
		
		locate : function(){
			
			// reference
			var _this	= this,
				_$el	= this.$el;
			
			
			// Try HTML5 geolocation
			if( ! navigator.geolocation )
			{
				alert( acf.l10n.google_map.browser_support );
				return this;
			}
			
			
			// show loading text
			_$el.find('.title h4').text(acf.l10n.google_map.locating + '...');
			_$el.addClass('active');
			
		    navigator.geolocation.getCurrentPosition(function(position){
		    	
		    	// vars
				var lat = position.coords.latitude,
			    	lng = position.coords.longitude;
			    	
				_this.set({ $el : _$el }).update( lat, lng ).sync().center();
				
			});

				
		},
		
		clear : function(){
			
			// update class
	        this.$el.removeClass('active');
			
			
			// clear search
			this.$el.find('.search').val('');
			
			
			// clear inputs
			this.$el.find('.input-address').val('');
			this.$el.find('.input-lat').val('');
			this.$el.find('.input-lng').val('');
			
			
			// hide marker
			this.map.marker.setVisible( false );
		},
		
		edit : function(){
			
			// update class
	        this.$el.removeClass('active');
			
			
			// clear search
			var val = this.$el.find('.title h4').text();
			
			
			this.$el.find('.search').val( val ).focus();
			
		},
		
		refresh : function(){
			
			// trigger resize on div
			google.maps.event.trigger(this.map, 'resize');
			
			// center map
			this.center();
			
		}
	
	};
	
	
	/*
	*  acf/setup_fields
	*
	*  run init function on all elements for this field
	*
	*  @type	event
	*  @date	20/07/13
	*
	*  @param	{object}	e		event object
	*  @param	{object}	el		DOM object which may contain new ACF elements
	*  @return	N/A
	*/
	
	$(document).on('acf/setup_fields', function(e, el){
		
		// vars
		$fields = $(el).find('.acf-google-map');
		
		
		// validate
		if( ! $fields.exists() )
		{
			return;
		}
		
		
		// validate google
		if( typeof google === 'undefined' )
		{
			$.getScript('https://www.google.com/jsapi', function(){
			
			    google.load('maps', '3', { other_params: 'sensor=false&libraries=places', callback: function(){
			    
			        $fields.each(function(){
					
						acf.fields.google_map.set({ $el : $(this) }).init();
						
					});
			        
			    }});
			});
			
		}
		else
		{
			google.load('maps', '3', { other_params: 'sensor=false&libraries=places', callback: function(){
				
				$fields.each(function(){
					
					acf.fields.google_map.set({ $el : $(this) }).init();
					
				});
		        
		    }});
				
		}
		
	});
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('click', '.acf-google-map .acf-sprite-remove', function( e ){
		
		e.preventDefault();
		
		acf.fields.google_map.set({ $el : $(this).closest('.acf-google-map') }).clear();
		
		$(this).blur();
		
	});
	
	
	$(document).on('click', '.acf-google-map .acf-sprite-locate', function( e ){
		
		e.preventDefault();
		
		acf.fields.google_map.set({ $el : $(this).closest('.acf-google-map') }).locate();
		
		$(this).blur();
		
	});
	
	$(document).on('click', '.acf-google-map .title h4', function( e ){
		
		e.preventDefault();
		
		acf.fields.google_map.set({ $el : $(this).closest('.acf-google-map') }).edit();
			
	});
	
	$(document).on('keydown', '.acf-google-map .search', function( e ){
		
		// prevent form from submitting
		if( e.which == 13 )
		{
		    return false;
		}
			
	});
	
	$(document).on('blur', '.acf-google-map .search', function( e ){
		
		// vars
		var $el = $(this).closest('.acf-google-map');
		
		
		// has a value?
		if( $el.find('.input-lat').val() )
		{
			$el.addClass('active');
		}
		
	});
	
	$(document).on('acf/fields/tab/show acf/conditional_logic/show', function( e, $field ){
		
		// validate
		if( ! acf.fields.google_map.ready )
		{
			return;
		}
		
		
		// validate
		if( $field.attr('data-field_type') == 'google_map' )
		{
			acf.fields.google_map.set({ $el : $field.find('.acf-google-map') }).refresh();
		}
		
	});

	

})(jQuery);

(function($){
	
	/*
	*  Image
	*
	*  static model for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	
	// reference
	var _media = acf.media;
	
	
	acf.fields.image = {
		
		$el : null,
		$input : null,
		
		o : {},
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('input[type="hidden"]');
			
			
			// get options
			this.o = acf.helpers.get_atts( this.$el );
			
			
			// multiple?
			this.o.multiple = this.$el.closest('.repeater').exists() ? true : false;
			
			
			// wp library query
			this.o.query = {
				type : 'image'
			};
			
			
			// library
			if( this.o.library == 'uploadedTo' )
			{
				this.o.query.uploadedTo = acf.o.post_id;
			}
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){

			// is clone field?
			if( acf.helpers.is_clone_field(this.$input) )
			{
				return;
			}
					
		},
		add : function( image ){
			
			// this function must reference a global div variable due to the pre WP 3.5 uploader
			// vars
			var div = _media.div;
			
			
			// set atts
			div.find('.acf-image-image').attr( 'src', image.url );
			div.find('.acf-image-value').val( image.id ).trigger('change');
		 	
			
		 	// set div class
		 	div.addClass('active');
		 	
		 	
		 	// validation
			div.closest('.field').removeClass('error');
	
		},
		edit : function(){
			
			// vars
			var id = this.$input.val();
			
			
			// set global var
			_media.div = this.$el;
			

			// clear the frame
			_media.clear_frame();
			
			
			// create the media frame
			_media.frame = wp.media({
				title		:	acf.l10n.image.edit,
				multiple	:	false,
				button		:	{ text : acf.l10n.image.update }
			});
			
			
			// log events
			/*
			acf.media.frame.on('all', function(e){
				
				console.log( e );
				
			});
			*/
			
			
			// open
			_media.frame.on('open',function() {
				
				// set to browse
				if( _media.frame.content._mode != 'browse' )
				{
					_media.frame.content.mode('browse');
				}
				
				
				// add class
				_media.frame.$el.closest('.media-modal').addClass('acf-media-modal acf-expanded');
					
				
				// set selection
				var selection	=	_media.frame.state().get('selection'),
					attachment	=	wp.media.attachment( id );
				
				
				// to fetch or not to fetch
				if( $.isEmptyObject(attachment.changed) )
				{
					attachment.fetch();
				}
				

				selection.add( attachment );
						
			});
			
			
			// close
			_media.frame.on('close',function(){
			
				// remove class
				_media.frame.$el.closest('.media-modal').removeClass('acf-media-modal');
				
			});
			
							
			// Finally, open the modal
			acf.media.frame.open();
			
		},
		remove : function()
		{
			
			// set atts
		 	this.$el.find('.acf-image-image').attr( 'src', '' );
			this.$el.find('.acf-image-value').val( '' ).trigger('change');
			
			
			// remove class
			this.$el.removeClass('active');
			
		},
		popup : function()
		{
			// reference
			var t = this;
			
			
			// set global var
			_media.div = this.$el;
			

			// clear the frame
			_media.clear_frame();
			
			
			 // Create the media frame
			 _media.frame = wp.media({
				states : [
					new wp.media.controller.Library({
						library		:	wp.media.query( t.o.query ),
						multiple	:	t.o.multiple,
						title		:	acf.l10n.image.select,
						priority	:	20,
						filterable	:	'all'
					})
				]
			});
			
			
			/*acf.media.frame.on('all', function(e){
				
				console.log( e );
				
			});*/
			
			
			// customize model / view
			acf.media.frame.on('content:activate', function(){

				// vars
				var toolbar = null,
					filters = null;
					
				
				// populate above vars making sure to allow for failure
				try
				{
					toolbar = acf.media.frame.content.get().toolbar;
					filters = toolbar.get('filters');
				} 
				catch(e)
				{
					// one of the objects was 'undefined'... perhaps the frame open is Upload Files
					//console.log( e );
				}
				
				
				// validate
				if( !filters )
				{
					return false;
				}
				
				
				// filter only images
				$.each( filters.filters, function( k, v ){
				
					v.props.type = 'image';
					
				});
				
				
				// no need for 'uploaded' filter
				if( t.o.library == 'uploadedTo' )
				{
					filters.$el.find('option[value="uploaded"]').remove();
					filters.$el.after('<span>' + acf.l10n.image.uploadedTo + '</span>')
					
					$.each( filters.filters, function( k, v ){
						
						v.props.uploadedTo = acf.o.post_id;
						
					});
				}
				
				
				// remove non image options from filter list
				filters.$el.find('option').each(function(){
					
					// vars
					var v = $(this).attr('value');
					
					
					// don't remove the 'uploadedTo' if the library option is 'all'
					if( v == 'uploaded' && t.o.library == 'all' )
					{
						return;
					}
					
					if( v.indexOf('image') === -1 )
					{
						$(this).remove();
					}
					
				});
				
				
				// set default filter
				filters.$el.val('image').trigger('change');
				
			});
			
			
			// When an image is selected, run a callback.
			acf.media.frame.on( 'select', function() {
				
				// get selected images
				selection = _media.frame.state().get('selection');
				
				if( selection )
				{
					var i = 0;
					
					selection.each(function(attachment){
	
				    	// counter
				    	i++;
				    	
				    	
				    	// select / add another image field?
				    	if( i > 1 )
						{
							// vars
							var $td			=	_media.div.closest('td'),
								$tr 		=	$td.closest('.row'),
								$repeater 	=	$tr.closest('.repeater'),
								key 		=	$td.attr('data-field_key'),
								selector	=	'td .acf-image-uploader:first';
								
							
							// key only exists for repeater v1.0.1 +
							if( key )
							{
								selector = 'td[data-field_key="' + key + '"] .acf-image-uploader';
							}
							
							
							// add row?
							if( ! $tr.next('.row').exists() )
							{
								$repeater.find('.add-row-end').trigger('click');
								
							}
							
							
							// update current div
							_media.div = $tr.next('.row').find( selector );
							
						}
						
						
				    	// vars
				    	var image = {
					    	id		:	attachment.id,
					    	url		:	attachment.attributes.url
				    	};
				    	
				    	// is preview size available?
				    	if( attachment.attributes.sizes && attachment.attributes.sizes[ t.o.preview_size ] )
				    	{
					    	image.url = attachment.attributes.sizes[ t.o.preview_size ].url;
				    	}
				    	
				    	// add image to field
				        acf.fields.image.add( image );
				        
						
				    });
				    // selection.each(function(attachment){
				}
				// if( selection )
				
			});
			// acf.media.frame.on( 'select', function() {
					 
				
			// Finally, open the modal
			acf.media.frame.open();
				

			return false;
		},
		
		// temporary gallery fix		
		text : {
			title_add : "Select Image",
			title_edit : "Edit Image"
		}
		
	};
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('click', '.acf-image-uploader .acf-button-edit', function( e ){
		
		e.preventDefault();
		
		acf.fields.image.set({ $el : $(this).closest('.acf-image-uploader') }).edit();
			
	});
	
	$(document).on('click', '.acf-image-uploader .acf-button-delete', function( e ){
		
		e.preventDefault();
		
		acf.fields.image.set({ $el : $(this).closest('.acf-image-uploader') }).remove();
			
	});
	
	
	$(document).on('click', '.acf-image-uploader .add-image', function( e ){
		
		e.preventDefault();
		
		acf.fields.image.set({ $el : $(this).closest('.acf-image-uploader') }).popup();
		
	});
	

})(jQuery);

(function($){
	
	/*
	*  Radio
	*
	*  static model and events for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	acf.fields.radio = {
		
		$el : null,
		$input : null,
		$other : null,
		farbtastic : null,
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find input
			this.$input = this.$el.find('input[type="radio"]:checked');
			this.$other = this.$el.find('input[type="text"]');
			
			
			// return this for chaining
			return this;
			
		},
		change : function(){

			if( this.$input.val() == 'other' )
			{
				this.$other.attr('name', this.$input.attr('name'));
				this.$other.show();
			}
			else
			{
				this.$other.attr('name', '');
				this.$other.hide();
			}
		}
	};
	
	
	/*
	*  Events
	*
	*  jQuery events for this field
	*
	*  @type	function
	*  @date	1/03/2011
	*
	*  @param	N/A
	*  @return	N/A
	*/
	
	$(document).on('change', '.acf-radio-list input[type="radio"]', function( e ){
		
		acf.fields.radio.set({ $el : $(this).closest('.acf-radio-list') }).change();
		
	});
	

})(jQuery);

(function($){
	
	/*
	*  Relationship
	*
	*  static model for this field
	*
	*  @type	event
	*  @date	1/06/13
	*
	*/
	
	acf.fields.relationship = {
		
		$el : null,
		$input : null,
		$left : null,
		$right : null,
				
		o : {},
		
		timeout : null,
		
		set : function( o ){
			
			// merge in new option
			$.extend( this, o );
			
			
			// find elements
			this.$input = this.$el.children('input[type="hidden"]');
			this.$left = this.$el.find('.relationship_left'),
			this.$right = this.$el.find('.relationship_right');
			
			
			// get options
			this.o = acf.helpers.get_atts( this.$el );
			
			
			// return this for chaining
			return this;
			
		},
		init : function(){
			
			// reference
			var _this = this;
			
			
			// is clone field?
			if( acf.helpers.is_clone_field(this.$input) )
			{
				return;
			}
			
			
			// set height of right colum