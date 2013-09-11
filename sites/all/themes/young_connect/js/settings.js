var $ = jQuery;
	
$(function() {	

	/**
	 * SECLECT BOX STYLING
	 */

	customSelectAttach();
	
	// Attach select box styling on checkbox click
	jQuery("#edit-field-event-date input[type=checkbox]").click(function() {
		customSelectAttach();
		setTimeout("customSelectAttach()",1);
	});
	
	// Attach select box styling on checkbox click
	jQuery("#btn-reveal").click(function() {
		customSelectAttach();
		setTimeout("customSelectAttach()",1);
	});
	
	// Attach select box styling on Ajax update
/*
	Drupal.behaviors.customSelect = {
		attach: function (context, settings) {		
			customSelectAttach();
		}
	};
*/
	
	/**
	 * SEARCH BLOCK - TOOLBOX
	 */
	 $("#btn-reveal").click(function (e) {
	 	e.preventDefault();
		
      $("#block-views-exp-v-rkt-jskasse-page-1").slideToggle(300, function() {
			// Change button text on slideToggle
      	if($(this).is(":visible")) $("#btn-reveal").html("Luk");
      	else { $("#btn-reveal").html("Søg her"); }
      });
    });
    if($("#block-views-exp-v-rkt-jskasse-page-1").is(":visible")) {
	 	$("#btn-reveal").html("Luk");
	 }
    
});

function customSelectAttach() {
	jQuery('.form-select:visible').not('.customised-select').customSelect();
}