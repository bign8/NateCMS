{if isset($smarty.get.mode) && $smarty.get.mode == 'edit'}
	<div id="{$id}" class="sortable">
		{foreach from=$content[$id] item=foo}{include file=$foo['editer'] item=$foo}
		{/foreach}
	</div>
	{* Add new content form *}
	<div class="block add-new" onClick="Editer.displayAddForm(this)">
		<span class="add-new-text">Click Here to add a new content block</span>
		<form class="add-new-form" style="display:none;" onreset="Editer.revert(this)" onsubmit="Editer.addContent({$vfsID}, '{$id}', this); return false;" >
			<select name="type_id" onchange="Editer.loadDesc(this)">
				<option value="null" disabled="disabled">-- Select --</option>
				{foreach from=$blocks item=foo}
					<option value="{$foo.blockID}" title="{$foo.description}">{$foo.name}</option>
				{/foreach}
			</select>&nbsp;
			<span class="add-new-form-desc">Content type</span>
			<br/>
			<input type="submit" value="Add Content" />
			<input type="reset" value="Cancel" />
			<img class="loader" src="/images/ajax-loader.gif" style="display:none;" />
		</form>
	</div>
{else}
	{foreach from=$content[$id] item=foo}{include file=$foo['renderer'] item=$foo}{/foreach}
{/if}