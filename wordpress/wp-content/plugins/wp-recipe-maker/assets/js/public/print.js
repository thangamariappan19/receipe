import { get_active_system } from '../../../../wp-recipe-maker-premium/addons-pro/unit-conversion/assets/js/shared/unit-conversion';

window.WPRecipeMaker.print = {
	init: () => {
		document.addEventListener( 'click', function(e) {
			for ( var target = e.target; target && target != this; target = target.parentNode ) {
				if ( target.matches( '.wprm-recipe-print, .wprm-print-recipe-shortcode' ) ) {
					WPRecipeMaker.print.onClick( target, e );
					break;
				}
			}
		}, false );
	},
	onClick: ( el, e ) => {
		let recipeId = el.dataset.recipeId;

		// Backwards compatibility.
		if ( !recipeId ) {
			const container = el.closest( '.wprm-recipe-container' );

			if ( container ) {
				recipeId = container.dataset.recipeId; 
			}
		}

		// Still no recipe ID? Just follow the link. Override otherwise.
		if ( recipeId ) {
			e.preventDefault();
			recipeId = parseInt( recipeId );
			WPRecipeMaker.print.recipeAsIs( recipeId, el );
		}
	},
	recipeAsIs: ( id, button = false ) => {
		let servings = false,
			system = 1,
			recipe = document.querySelector( '#wprm-recipe-container-' + id );

		if ( ! recipe && button ) {
			recipe = button.closest( '.wprm-recipe' );
		}

		if ( recipe ) {
			const servingsContainer = recipe.querySelector( '.wprm-recipe-servings' );
			if ( servingsContainer ) {
				// TODO: Update once adjustable servings feature is not using jQuery anymore.
				if ( typeof jQuery === 'undefined' ) {
					servings = parseInt( servingsContainer.dataset.servings );
				} else {
					servings = parseInt( jQuery(servingsContainer).data('servings') );
				}
			}
			system = get_active_system( recipe );
		}

		WPRecipeMaker.print.recipe( id, servings, system );
	},
	recipe: ( id, servings = false, system = 1 ) => {
		const url = WPRecipeMaker.print.getUrl( id );
		const printWindow = window.open( url, '_blank' );

		printWindow.onload = () => {
			printWindow.focus();
			printWindow.WPRMPrint.setArgs({
				system,
				servings,
			});
		};
	},
	getUrl: ( id ) => {
		const urlParts = wprm_public.home_url.split(/\?(.+)/);
		let printUrl = urlParts[0];

		if ( wprm_public.permalinks ) {
			printUrl += wprm_public.print_slug + '/' + id;

			if ( urlParts[1] ) {
				printUrl += '?' + urlParts[1];
			}
		} else {
			printUrl += '?' + wprm_public.print_slug + '=' + id;

			if ( urlParts[1] ) {
				printUrl += '&' + urlParts[1];
			}
		}

		return printUrl;
	},
};

ready(() => {
	window.WPRecipeMaker.print.init();
});

function ready( fn ) {
    if (document.readyState != 'loading'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}