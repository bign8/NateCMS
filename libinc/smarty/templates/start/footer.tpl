		</div> {* body *}
		<footer>
			Produced by NW PRODUCTIONS, CMS AND ALL
		</footer>
	</div> {* wrapper *}
	<div id="editorNav">
		<ul>
		{if $isEditer}
			{if !isset($smarty.get.mode) || $smarty.get.mode != 'edit'}
				<li><a href="{$smarty.server.REDIRECT_URL}?mode=edit" class="ui-icon ui-icon-pencil" title="Edit Page">Edit</a></li>
			{else}
				<li><a href="#shuffle!" class="ui-icon ui-icon-shuffle" title="Re-order Content">Re-order Content</a></li>
				<li><a href="{$smarty.server.REDIRECT_URL}" class="ui-icon ui-icon-circle-close" title="Close Editor">Close</a></li>
			{/if}
			{*<a href="/logout">Logout</a>&nbsp;&nbsp;&nbsp;&nbsp;*}
			<li><a href="/user.php?action=forceLogout" onclick="return General.logout()" class="ui-icon ui-icon-power" title="Logout of Editor">Logout</a></li>
		{else}
			{*<a href="/login">Login</a> need a fix for javascript-less browsers - have that user.php display a form or something*}
			<li><a href="/user.php?action=forceLogin" onclick="return General.login()" class="ui-icon ui-icon-key" title="Login to Editor">Login</a></li>
		{/if}
		{if $isEditer && $is404}
			<li><a href="/newPage">MAKE IT A PAGE NOW!!!</a></li>{* only show if correct extension *}
		{/if}
		</ul>
	</div>
</body>
</html>
{*$smarty.server|@print_r*}
