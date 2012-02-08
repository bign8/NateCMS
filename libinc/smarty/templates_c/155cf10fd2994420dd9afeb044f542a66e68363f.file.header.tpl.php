<?php /* Smarty version Smarty 3.1.4, created on 2011-12-04 21:02:57
         compiled from "/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9872207234ec16fcf1355a8-63372484%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '155cf10fd2994420dd9afeb044f542a66e68363f' => 
    array (
      0 => '/hermes/web05/b2386/moo.outsidemediacom/omnate/libinc/smarty/templates/start/header.tpl',
      1 => 1323050576,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9872207234ec16fcf1355a8-63372484',
  'function' => 
  array (
  ),
  'version' => 'Smarty 3.1.4',
  'unifunc' => 'content_4ec16fcf299a6',
  'variables' => 
  array (
    'title' => 0,
    'desc' => 0,
    'keywords' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4ec16fcf299a6')) {function content_4ec16fcf299a6($_smarty_tpl) {?><!doctype html>
<html>
<head>
  <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
  <meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
">
  <meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
  <meta name="author" content="Nate Woods">
  <meta charset="UTF-8" />
  
  <link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.8.16.custom.css" />
  <link rel="stylesheet" type="text/css" href="/css/Default.css" />
  <script src="/js/jquery-1.7.min.js" ></script>
  <script src="/js/jquery-ui-1.8.16.custom.min.js" ></script>
  
  <?php if ($_GET['mode']=='edit'){?>
	<script src="/js/EditAll.js" ></script>
  <?php }?>
  
  <?php echo $_smarty_tpl->getSubTemplate ("genHeader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</head>
<body>
	<div id="wrapper">
		<div id="header">
			Name of the Site and Other Header info
		</div>
		<div id="body"><?php }} ?>