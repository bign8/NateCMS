{foreach from=$dynInclude item=foo}
	{if $foo['type'] eq 'js'}
		<script src="{$foo['script']}"></script>
	{elseif $foo['type'] eq 'css'}
		<link rel="stylesheet" type="text/css" href="{$foo['script']}" />
	{else}
		{*error*}
	{/if}
{/foreach}

{if isset($smarty.cookies.hash)}
	<script src="/js/private.js"></script>
{/if}