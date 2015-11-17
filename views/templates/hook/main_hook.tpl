{*
*  @author Evgeny Grishin <e.v.grishin@yandex.ru>
*  @copyright  2015 Evgeny grishin
*}
{strip}
{addJsDef egcallmefree_ajaxcontroller=$ajaxcontroller}
{/strip}
{if $btn_view=='Show'}
<div class="clearfix pull-left">
	<button class="eg_callme_btn" type="button">{l s='call me order' mod='egcallmefree'}</button>
</div>
{/if}
{if $phone_tube=='Show'}
<div class="eg_callme_btn pozvonim-button BOTTOM_RIGHT pozvonim-button-animation" style="position: fixed; bottom: 30px;right: 50px;z-index: 999;; cursor: pointer; opacity: 1; display: block;">
    <div class="pozvonim-button-wrapper actionShow">    
        <div class="pozvonim-button-border-inner"></div>
        <div class="pozvonim-button-border-outer"></div>
        <div class="pozvonim-button-text">
            <span class="pozvonim-button-center-text">{l s='Free callback' mod='egcallmefree'}</span>
        </div>
        <div class="pozvonim-button-phone"></div>
    </div>
</div>
{/if}