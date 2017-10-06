"use strict";

jQuery(document).ready(function($){ 
	if( window.iota_url != "" ){
		$('[data-address]').microtipping(window.iota_url);
	}
});

