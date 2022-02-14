$(document).ready(function() {
	console.log("Hello and Welcome to Add Blog Page!!!");
	disableRemoveButton();
	enableRemoveButton();
	//$('#tagContaoner')
	
	 $('#add_tag').click(function(){

		  // Selecting last id 
		  var tagTitle_id = $('.tagItem input[type=text]:nth-child(1)').last().attr('id');
		  var split_id = tagTitle_id.split("_");
		
		  // New index
		  var index = Number(split_id[1]) + 1;
		  console.log(index+ " - Index");
		
		  // Create clone
		  var newel = $('.tagItem:last').clone(true);
		
		  // Set id of new element
		  $(newel).find('input[type=text]:nth-child(1)').attr("id","title_"+index);
		  $(newel).find('input[type=text]:nth-child(2)').attr("id","link_"+index);
		  
		  // Set Name
		  $(newel).find('input[type=text]:nth-child(1)').attr("name", "tagTitle[]");
		  $(newel).find('input[type=text]:nth-child(2)').attr("name", "tagLink[]");
		  
		  // Insert element
		  $(newel).insertAfter(".tagItem:last");
		  enableRemoveButton();
	 });
	 
	 $('#remove_tag').click(function(){
		var count = $('.tagItem').length; 
		if(count>1) {			
			$(this).parent().prev().remove();
		}
		disableRemoveButton();
	 });

	function disableRemoveButton() {
		var count = $('.tagItem').length; 
		if(count<2) {			
			$('#remove_tag').prop("disabled", true);
		}
	}
	function enableRemoveButton() {
		var count = $('.tagItem').length; 
		if(count>1) {			
			$('#remove_tag').prop("disabled", false);
		}
	}
	
	

});