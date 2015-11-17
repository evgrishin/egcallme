/**
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*/
$(document).ready(function() { 
	
	$(document).on('click', '.eg_callme_btn', function(e){
		e.preventDefault();
		var egcallmefree_ajaxcontroller_url
		egcallmefree_ajaxcontroller_url = egcallmefree_ajaxcontroller+"?ajax";

		if (!!$.prototype.fancybox)
				$.fancybox({
					'type':     'ajax',
					'href':     egcallmefree_ajaxcontroller_url
				});	

	});	
	
	$(document).on('click', '#eg_submitcallme', function(e){
		var eg_form = $("#eg_callmeform");
		eg_form.validate();
		if (eg_form.valid())
		{
			$(this).prop( "disabled", true );
	    
		    $.ajax({
		         type: 'POST',
		         url: egcallmefree_ajaxcontroller,
		         data: eg_form.serialize(),
		         success: function(data) {
		        	 eg_form.fadeOut("fast", function(){
		        		 $("#eg_callmemess").html(data);
		        		 setTimeout("$.fancybox.close()", 1500);
		        	 });
		         }
		    });	
		}
	});	
	
});


