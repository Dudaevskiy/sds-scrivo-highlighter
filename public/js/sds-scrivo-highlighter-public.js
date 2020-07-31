//(function( $ ) {
//	'use strict';
	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

//})( jQuery );

// jQuery(document).ready(function($){
// // 		$(window).on('load', function () {
//
// 	$('body li#wp-admin-bar-edit').click(function(){
// 		console.info('body li#wp-admin-bar-edit ✅');
// 		if (window.fee){
// 			setTimeout(function() {
// 				// ============================
// 				// if($('body').hasClass('fee-on')){
// 				// console.info('✅');
// 				$('body.fee-on').on('click touch','i.mce-ico.mce-i-pre', function(){
// 					console.info('✅');
// 					//var CreatePreHTML = $('body').find('pre[data-mce-selected="block"]').html();
// 					//И обернем html d <code>
// 					$('body').find('pre[data-mce-selected="block"]').html('<code>'+CreatePreHTML+'</code>');
// 					// $('body').find('pre[data-mce-selected="block"]').addClass('SDStudio-fee-PRE-create');
// 					// $('body').find('pre[data-mce-selected="block"]').wrap('<div class="SDStudio-fee-PRE-create"></div>');
// 					// console.info('Клик по pre есть');
// 					// console.info(wdw);
// 				});
// 				// } else {
// 				// 	// console.info('🔴');
// 				// }
// 				// ============================
// 			}, 1000);
// 		}
// 	});
//
// // 	});
// });

jQuery(document).ready(function($){
// 		$(window).on('load', function () {

	$('body li#wp-admin-bar-edit').click(function(){
		console.info('body li#wp-admin-bar-edit ✅');
		if (window.fee){
			setTimeout(function() {
				// ============================
				// if($('body').hasClass('fee-on')){
				// console.info('✅');
				$('body.fee-on').on('click touch','i.mce-ico.mce-i-code', function(){
					console.info('✅');
					var CreatePreHTML = $('body').find('[data-mce-selected="block"] code').html();
					//И обернем html d <code>
// 					$('body').find('code[data-mce-selected="block"]').html('<code>'+CreatePreHTML+'</code>');
					// $('body').find('pre[data-mce-selected="block"]').addClass('SDStudio-fee-PRE-create');
					$('body').find('[data-mce-selected="block"]').html('<pre class="SDStudio-fee-PRE-create"><code>'+CreatePreHTML+'</code></pre>');
					// console.info('Клик по pre есть');
					// console.info(wdw);
				});
				// } else {
				// 	// console.info('🔴');
				// }
				// ============================
			}, 1000);
		}
	});

// 	});
});



document.onkeyup = function(e) {

// Alt+P Вставляем блок <pre><code class="language-uncnow"></code></pre>
	if (e.altKey && e.which == 80) {

		jQuery(document).ready(function($){
			$('body').find('[data-mce-bogus]').before("<pre class='language-SDStudio-hot-key-frontend'>👔👔👔👔👔</pre>");
			// console.log('Опа');
		});

	}
};

