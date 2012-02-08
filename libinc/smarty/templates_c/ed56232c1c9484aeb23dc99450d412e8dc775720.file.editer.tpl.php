<?php /* Smarty version Smarty 3.1.4, created on 2011-11-24 17:32:55
         compiled from "/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/blocks/text/editer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17417148524ec16fcf50a8e5-05184336%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ed56232c1c9484aeb23dc99450d412e8dc775720' => 
    array (
      0 => '/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/blocks/text/editer.tpl',
      1 => 1322173866,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17417148524ec16fcf50a8e5-05184336',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ec16fcf5867c',
  'variables' => 
  array (
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ec16fcf5867c')) {function content_4ec16fcf5867c($_smarty_tpl) {?><div id="<?php echo $_smarty_tpl->tpl_vars['item']->value['contentID'];?>
" class="block-edit text">
	<span class="controls">
		<span class="edit ui-icon ui-icon-pencil" style="float:left;" onClick="textEditObj.init(<?php echo $_smarty_tpl->tpl_vars['item']->value['contentID'];?>
);"></span>
		<span class="move ui-icon ui-icon-transferthick-e-w" style="float:left;"></span>
		<span class="delete ui-icon ui-icon-closethick" style="float:left;" onClick="Editer.killMe(this);" ></span>
	</span>
	<div class="content">
		<?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>

	</div>
</div><?php }} ?>