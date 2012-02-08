		</div> {* body *}
		<div id="footer" style="text-align:center;">
			Produced by NW PRODUCTIONS, CMS AND ALL <br /><br /> 
			{if $isEditer}
				{if $smarty.get.mode != 'edit'}
					<a href="{$smarty.server.SCRIPT_URI}?mode=edit">EDIT</a>&nbsp;&nbsp;&nbsp;&nbsp;
				{else}
					<a href="{$smarty.server.SCRIPT_URI}">CLOSE</a>&nbsp;&nbsp;&nbsp;&nbsp;
				{/if}
				<a href="/logout">LOGOUT</a>&nbsp;&nbsp;&nbsp;&nbsp;
			{else}
				<a href="/login">LOGIN</a>
			{/if}
			{if $isEditer && $is404}
				<br /><br /><a href="/newPage">MAKE IT A PAGE NOW!!!</a>
			{/if}
		</div>
	</div> {* wrapper *}
</body>
</html>