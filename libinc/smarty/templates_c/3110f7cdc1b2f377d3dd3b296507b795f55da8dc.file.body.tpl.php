<?php /* Smarty version Smarty 3.1.4, created on 2011-11-14 14:45:19
         compiled from "/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/body.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11414868524ec16fcf2d4626-00152814%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3110f7cdc1b2f377d3dd3b296507b795f55da8dc' => 
    array (
      0 => '/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/body.tpl',
      1 => 1321172226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11414868524ec16fcf2d4626-00152814',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ec16fcf33683',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ec16fcf33683')) {function content_4ec16fcf33683($_smarty_tpl) {?><div id="right">
<?php echo $_smarty_tpl->getSubTemplate ('blocks/blocker.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('id'=>'main','content'=>$_smarty_tpl->tpl_vars['content']->value), 0);?>

</div>
<div id="left">
<?php echo $_smarty_tpl->getSubTemplate ('blocks/blocker.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('id'=>'nav','content'=>$_smarty_tpl->tpl_vars['content']->value), 0);?>

</div>
<?php }} ?>