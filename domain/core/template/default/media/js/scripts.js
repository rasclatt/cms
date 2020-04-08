$(function(){
	// Stop the component editor from jumping to top
	$('a.component-element,a.nodrag.close-btn').on('click', function(e){
		e.preventDefault();
	});
});