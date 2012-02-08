<!doctype html>
<html>
<head>
  <title>{$title}</title>
  <meta name="description" content="{$desc}">
  <meta name="keywords" content="{$keywords}">
  <meta name="author" content="Nate Woods">
  <meta charset="UTF-8" />
  
  <link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.8.16.custom.css" />
  <link rel="stylesheet" type="text/css" href="/css/Default.css" />
  <script src="/js/jquery-1.7.min.js" ></script>
  <script src="/js/jquery-ui-1.8.16.custom.min.js" ></script>
  
  {if $smarty.get.mode == 'edit'}
	<script src="/js/EditAll.js" ></script>
  {/if}
  
  {include file="genHeader.tpl"}
</head>
<body>
	<div id="wrapper">
		<div id="header">
			Name of the Site and Other Header info
		</div>
		<div id="body">