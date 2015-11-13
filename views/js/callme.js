/**
 * 
 */
$(document).ready(function() { 
	
	$("#eg_callmeform").submit(function() { return false; });
	
	$(document).on('click', '.eg_callme_btn', function(e){
		e.preventDefault();
		var url = this.rel+"?ajax";

		if (!!$.prototype.fancybox)
				$.fancybox({
					'padding':  20,
					'type':     'ajax',
					'href':     url
				});	

	});	
	
	$(document).on('click', '#eg_submitcallme', function(e){
		e.preventDefault();

			$("#eg_submitcallme").prop( "disabled", true );
	    
		    $.ajax({
		         type: 'POST',
		         url: $("#eg_urlaction").val(),
		         data: $("#eg_callmeform").serialize(),
		         success: function(data) {
		        	 $("#eg_callmeform").fadeOut("fast", function(){
		        		 $("#eg_callmemess").html(data);
		        		 setTimeout("$.fancybox.close()", 1500);
		        	 });
		         }
		    });	
		
	});	
	
});

