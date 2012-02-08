<div id="{$item['contentID']}" class="block-edit text">
	<span class="controls">
		<span class="edit ui-icon ui-icon-pencil" style="float:left;" onClick="textEditObj.init({$item['contentID']});"></span>{* dont need to store js editor object in db *}
		<span class="move ui-icon ui-icon-transferthick-e-w" style="float:left;"></span>
		<span class="delete ui-icon ui-icon-closethick" style="float:left;" onClick="Editer.killMe(this);" ></span>
	</span>
	<div class="content">
		{$item['content']}
	</div>
</div>