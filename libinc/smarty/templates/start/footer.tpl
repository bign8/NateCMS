		</div> {* body *}
		<div id="footer" style="text-align:center;">
			Produced by NW PRODUCTIONS, CMS AND ALL <br /><br /> 
			{if $isEditer}
				{if $smarty.get.mode != 'edit'}
					<a href="{$smarty.server.REDIRECT_URL}?mode=edit">EDIT</a>&nbsp;&nbsp;&nbsp;&nbsp;
				{else}
					<a href="{$smarty.server.REDIRECT_URL}">CLOSE</a>&nbsp;&nbsp;&nbsp;&nbsp;
				{/if}
				{*<a href="/logout">LOGOUT</a>&nbsp;&nbsp;&nbsp;&nbsp;*}
				<a href="/user.php?action=forceLogout" {*onclick="General.logout()"*}>LOGOUT</a>
			{else}
				{*<a href="/login">LOGIN</a> need a fix for javascript-less browsers - have that user.php display a form or something*}
				<a href="/user.php?action=forceLogin" {*onclick="return General.login()"*}>LOGIN</a>
			{/if}
			{if $isEditer && $is404}
				<br /><br /><a href="/newPage">MAKE IT A PAGE NOW!!!</a>
			{/if}
		</div>
	</div> {* wrapper *}
	<div id="styleNav">
		<ul>
			<li>Styles: </li>
			<li><a href="" rel="/dynamic/blank/css.css">Default</a></li>
			<li><a href="" rel="/dynamic/syd/css.css">Sydney</a></li>
			<li><a href="" rel="/dynamic/tay/css.css">Taylor</a></li>
			<li><a href="" rel="/dynamic/dev/css.css">Devon</a></li>
			<li><a href="" rel="/dynamic/alex/css.css">Alex</a></li>
		</ul>
	</div>
</body>
</html>
{*$smarty.server|@print_r*}