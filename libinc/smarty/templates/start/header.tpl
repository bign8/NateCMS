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
  <script src="/js/jquery.validate.min.js" ></script>
  <script src="/js/jquery.cookie.js"></script>
  <script src="/js/jquery-ui-1.8.16.custom.min.js" ></script>
  <script src="/js/all.js" ></script>
  {*
  <link rel="stylesheet" type="text/css" href="/dynamic/blank/css.css" id="toSwitch" />
  <script>
	{literal}
	if($.cookie("css")) {
		$("link#toSwitch").attr("href",$.cookie("css"));
	}
	$(document).ready(function() { 
		$("#styleNav li a").click(function() { 
			$("link#toSwitch").attr("href",$(this).attr('rel'));
			$.cookie("css",$(this).attr('rel'), {expires: 365, path: '/'});
			return false;
		});
	});
	{/literal}
  </script>
  
  <link href='http://fonts.googleapis.com/css?family=Great+Vibes' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Just+Me+Again+Down+Here' rel='stylesheet' type='text/css'>
 
  <script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Great+Vibes::latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); </script>
  *}
  {if $smarty.get.mode == 'edit'}
	<script src="/js/EditAll.js" ></script>
  {/if}
  
  {include file="genHeader.tpl"}
</head>
<body>
	<div id="wrapper">
		<div id="header">
			<h1>CS389 Template demo server</h1>
			<span style="text-align:center;"><a href="/">HOME</a></span>
		</div>
		<div id="body">
