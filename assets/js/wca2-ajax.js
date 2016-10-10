( function( window, document, $, undefined ) {
	'use strict';

	var WCA2AJAX = {

		// Bind our primary actions
		bind : function () {
			$('body').on( 'blur', '.search-field', WCA2AJAX.onSearchBlur );
			$('body').on( 'keyup', '.search-field', WCA2AJAX.onSearchTyping );
		},

		// Actions taken when search input loses focus.
		onSearchBlur : function () {
			$('body').on( 'click', WCA2AJAX.removeSuggestedResults );
		},

		// Actions taken when typing in search field.
		onSearchTyping : function () {
			WCA2AJAX.submitSearchAJAX( $(this).val() );
		},

		// Run our AJAX request for search results
		submitSearchAJAX : function ( value ) {

			if ( 0 === value.length ) {
				WCA2AJAX.removeSuggestedResults();
				return;
			}

			$.post(
				wca2.ajaxUrl,
				{
					'action' : 'wca2-search',
					's' : value
				},
				function ( response ) {
					WCA2AJAX.removeSuggestedResults();
					WCA2AJAX.addSuggestedResults( response.data.results );
				}
			);
		},

		// Add suggested results markup to page
		addSuggestedResults : function ( results ) {
			var markup = WCA2AJAX.generateSuggestionsMarkup( results );
			$(markup).appendTo('.widget_search');
		},

		// Remove suggested results markup from page
		removeSuggestedResults : function () {
			$('.search-suggestions').remove();
		},

		// Generage suggested results markup
		generateSuggestionsMarkup : function ( results ) {
			var output = '';
			output = '<div class="search-suggestions">';
			output += '<ul>';

			results.forEach( function( result, index, array ) {
				output += '<li><a href="' + result.link + '">' + result.title + '</a></li>';
			}, this );

			output += '</ul>';
			output += '</div>';

			return output;
		}
	};

	$(document).on( 'ready', WCA2AJAX.bind );

})( window, document, jQuery );
