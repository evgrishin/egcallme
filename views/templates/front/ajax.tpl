{*
*		!Configuration::updateValue('EGCALLME_FIELD_FNAME', 'mondatory')||//not|view|mondatory
*		!Configuration::updateValue('EGCALLME_FIELD_LNAME', 'mondatory')||//not|view|mondatory
*		!Configuration::updateValue('EGCALLME_FIELD_MESS', 'mondatory')//not|view|mondatory
*}

{if $view=="form"}
<div id="eg_callmemess"></div>
<form id="eg_callmeform" name="eg_callmeform" action="#" method="post">
<fieldset>
	<h3>{l s='order call back' mod='egcallme'}</h3>
	<div class="clearfix">
		<label for="eg_phone">{l s='phone' mod='egcallme'}</label>
			<input class="form-control grey validate" type="phone" placeholder="{$mask}" id="eg_phone" name="eg_phone" maxlength="30"  required="">
	</div>
	<div class="clearfix">
		<label for="eg_fnamee">{l s='fname' mod='egcallme'}</label>
			<input class="form-control grey validate" type="text" id="eg_fname" name="eg_fname" maxlength="20"  required="">
	</div>	
	<div class="clearfix">
		<label for="eg_lname">{l s='lname' mod='egcallme'}</label>
			<input class="form-control grey validate" type="text" id="eg_lname" name="eg_lname" maxlength="20"  required="">
	</div>	
	<input type="hidden" id="ajax" name="ajax" value="">
	<input type="hidden" id="action" name="action" value="new">
	<input type="hidden" id="eg_urlaction" name="eg_urlaction" value="{$ajaxcontroller}">
	<label for="eg_message">{l s='message' mod='egcallme'}</label>
    	<textarea class="form-control" id="eg_message" name="eg_message"></textarea>
	</div>
	<div class="submit">
		<button type="submit" name="eg_submitcallme" id="eg_submitcallme" class="button btn btn-outline button-medium"><span>{l s='call me' mod='egcallme'}</span></button>
	</div>
</fieldset>
</form>
	{if trim($mask)!=""}
	<script type="text/javascript">
	var eg_mask;
	eg_mask = "{$mask}";
	$("#eg_phone").mask(eg_mask);
	</script>
	{/if}
{else}
<span>{l s='submited' mod='egcallme'}</span>
{/if}