		</div> {* body *}
		<footer>
			Produced by NW PRODUCTIONS, CMS AND ALL
		</footer>
	</div> {* wrapper *}
	<div id="editorNav">
		<ul>
		{if $isEditer}
			{if !isset($smarty.get.mode) || $smarty.get.mode != 'edit'}
				<li><a href="{$smarty.server.REDIRECT_URL}?mode=edit">EDIT</a></li>
			{else}
				<li><a href="{$smarty.server.REDIRECT_URL}">CLOSE</a></li>
			{/if}
			{*<a href="/logout">LOGOUT</a>&nbsp;&nbsp;&nbsp;&nbsp;*}
			<li><a href="/user.php?action=forceLogout" onclick="return General.logout()">LOGOUT</a></li>
		{else}
			{*<a href="/login">LOGIN</a> need a fix for javascript-less browsers - have that user.php display a form or something*}
			<li><a href="/user.php?action=forceLogin" onclick="return General.login()">LOGIN</a></li>
		{/if}
		{if $isEditer && $is404}
			<li><a href="/newPage">MAKE IT A PAGE NOW!!!</a></li>
		{/if}
		</ul>
	</div>
</body>
</html>
{*$smarty.server|@print_r*}
