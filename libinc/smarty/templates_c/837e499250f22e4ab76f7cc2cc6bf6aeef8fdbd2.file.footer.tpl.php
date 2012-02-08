<?php /* Smarty version Smarty 3.1.4, created on 2012-01-10 00:27:37
         compiled from "/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8906237614ef40b75265293-86789928%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '837e499250f22e4ab76f7cc2cc6bf6aeef8fdbd2' => 
    array (
      0 => '/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/footer.tpl',
      1 => 1326173107,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8906237614ef40b75265293-86789928',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ef40b7546357',
  'variables' => 
  array (
    'isEditer' => 0,
    'is404' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ef40b7546357')) {function content_4ef40b7546357($_smarty_tpl) {?>		</div> 
		<div id="footer" style="text-align:center;">
			Produced by NW PRODUCTIONS, CMS AND ALL <br /><br /> 
			<?php if ($_smarty_tpl->tpl_vars['isEditer']->value){?>
				<?php if ($_GET['mode']!='edit'){?>
					<a href="<?php echo $_SERVER['SCRIPT_URI'];?>
?mode=edit">EDIT</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php }else{ ?>
					<a href="<?php echo $_SERVER['SCRIPT_URI'];?>
">CLOSE</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<?php }?>
				<a href="/logout">LOGOUT</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }else{ ?>
				<a href="/login">LOGIN</a>
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['isEditer']->value&&$_smarty_tpl->tpl_vars['is404']->value){?>
				<br /><br /><a href="/newPage">MAKE IT A PAGE NOW!!!</a>
			<?php }?>
		</div>
	</div> 
</body>
</html><?php }} ?>