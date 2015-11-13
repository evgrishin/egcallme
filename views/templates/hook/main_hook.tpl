{if $btn_view=='link'}
<div class="clearfix pull-left">
	<a class="eg_callme_btn" href="{$ajaxcontroller}" rel="{$ajaxcontroller}">{l s='call me order' mod='egcallme'}</a>
</div>
{/if}
{if $btn_view=='btn'}
<div class="clearfix pull-left">
	<a class="eg_callme_btn" href="{$ajaxcontroller}" rel="{$ajaxcontroller}">{l s='call me order' mod='egcallme'}</a>
</div>
{/if}
{if $btn_view=='self'}
{$btn_self}
{/if}

{if $phone_tube=='view'}
<a class="eg_callme_btn eg_uptocall-mini" href="{$ajaxcontroller}" rel="{$ajaxcontroller}"><div class="uptocall-mini-phone"></div></a>
{/if}
{if $phone_tube=='ani'}
<a class="eg_callme_btn eg_uptocall-mini" href="{$ajaxcontroller}" rel="{$ajaxcontroller}"><div class="uptocall-mini-phone"></div></a>
{/if}