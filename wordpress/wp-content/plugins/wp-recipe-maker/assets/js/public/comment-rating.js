window.WPRecipeMaker.rating = {
	init() {
		const ratingFormElem = document.querySelector( '.comment-form-wprm-rating' );

		if ( ratingFormElem ) {
			const recipes = document.querySelectorAll( '.wprm-recipe-container' );
			const admin = document.querySelector( 'body.wp-admin' );

			if ( recipes.length > 0 || admin ) {
				ratingFormElem.style.display = '';
			} else {
				// Hide when no recipe is found.
				ratingFormElem.style.display = 'none';
			}
		}
	},
	settings: {
		enabled: typeof window.wprm_public !== 'undefined' ? wprm_public.settings.features_comment_ratings : wprm_admin.settings.features_comment_ratings,
	},
	value: 0,
	onClick( el ) {
		const newValue = parseInt( el.value );

		if ( newValue === this.value ) {
			el.checked = false;
			document.querySelector( 'input[name="wprm-comment-rating"][value="0"]').checked = true;
			this.value = 0;
		} else {
			this.value = newValue;
		}
	},
};

ready(() => {
	window.WPRecipeMaker.rating.init();
});

function ready( fn ) {
    if (document.readyState != 'loading'){
        fn();
    } else {
        document.addEventListener('DOMContentLoaded', fn);
    }
}