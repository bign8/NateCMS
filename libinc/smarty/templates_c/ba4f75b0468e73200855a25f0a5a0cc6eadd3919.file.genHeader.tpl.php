<?php /* Smarty version Smarty 3.1.4, created on 2011-12-24 20:22:18
         compiled from "/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/genHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14492998954ecb32bd9d8377-11891498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba4f75b0468e73200855a25f0a5a0cc6eadd3919' => 
    array (
      0 => '/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/genHeader.tpl',
      1 => 1324776138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14492998954ecb32bd9d8377-11891498',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ecb32bda186c',
  'variables' => 
  array (
    'dynInclude' => 0,
    'foo' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ecb32bda186c')) {function content_4ecb32bda186c($_smarty_tpl) {?><?php  $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['foo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dynInclude']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['foo']->key => $_smarty_tpl->tpl_vars['foo']->value){
$_smarty_tpl->tpl_vars['foo']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['foo']->value['type']=='js'){?>
		<script src="<?php echo $_smarty_tpl->tpl_vars['foo']->value['script'];?>
"></script>
	<?php }elseif($_smarty_tpl->tpl_vars['foo']->value['type']=='css'){?>
		<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['foo']->value['script'];?>
" />
	<?php }else{ ?>
	<?php }?>
<?php } ?>

<?php if (isset($_COOKIE['hash'])){?>
	<script src="/js/private.js"></script>
<?php }?><?php }} ?>