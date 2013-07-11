<div id="right">
{include file='blocks/blocker.tpl' id='main' content=$content}
</div>

<div id="left">
{include file='blocks/blocker.tpl' id='nav' content=$content}
</div>

{*
<pre>
{$vfsID}
{$content|@print_r}
</pre>
*}