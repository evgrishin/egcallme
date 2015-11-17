{*
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*}
{if $view=="form"}
<div id="eg_callmemess"></div>
<form id="eg_callmeform" name="eg_callmeform" action="#" method="post">
<fieldset>
	<h3>{l s='order call back' mod='egcallmefree'}</h3>
	<div class="clearfix">
		<label for="eg_phone">{l s='phone' mod='egcallmefree'}*</label>
			<input class="form-control grey validate required" type="phone" placeholder="" id="eg_phone" name="eg_phone" maxlength="30">
	</div>
	<div class="clearfix">
		<label for="eg_fnamee">{l s='fname' mod='egcallmefree'}*</label>
			<input class="form-control grey validate class required" type="text" id="eg_fname" name="eg_fname" maxlength="20">
	</div>
	<input type="hidden" id="ajax" name="ajax" value="">
	<input type="hidden" id="action" name="action" value="new">
	<input type="hidden" id="eg_urlaction" name="eg_urlaction" value="{$ajaxcontroller|escape:'htmlall':'UTF-8'}">
	<label for="eg_message">{l s='message' mod='egcallmefree'}*</label>
    	<textarea class="form-control required" id="eg_message" name="eg_message"></textarea>
	</div>
	<div class="submit" style="margin-top: 13px;">
		<button type="submit" name="eg_submitcallme" id="eg_submitcallme" class="button btn btn-outline button-medium"><span>{l s='call me' mod='egcallmefree'}</span></button>
	</div>
</fieldset>
</form>
<script type="text/javascript">
$.validator.messages.required = "{l s='Field is required!' mod='egcallmefree'}";
</script>
{else}
<span>{l s='submited' mod='egcallmefree'}</span>
{/if}