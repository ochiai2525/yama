<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title><?php echo ife($title_for_layout, $title_for_layout . " | ", "");?>株式会社　山田為商店</title>
<meta name="keywords" content="電線,絶縁材料,加工,山田為商店" />
<meta name="description" content="相場情報をお届けします。山田為商店は電線、絶縁材料、加工品をトータルにご提供します。" />
<link rel="stylesheet" href="/common/css/import.css" type="text/css" media="screen,print" />
<link rel="stylesheet" href="/common/css/print.css" type="text/css" media="print" />
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript" src="/common/js/jquery.js" language="javascript"></script>
<script type="text/javascript" src="/common/js/default.js"  language="javascript"></script>
<?php
	echo $scripts_for_layout;
?>
</head>
<body>
<!-- CONTAINER START -->
<div id="container">
<?php include PUBLIC_HTML_DIR . 'common' . DS . 'inc' . DS . 'header.inc'; ?>
<!-- GLOBALNAVI START -->
<div id="globalnavi">
<div class="inner">
<ul class="clearfix">
<li><a href="/index.html"><img src="/images/globalnavi01.jpg" alt="ホーム" width="127" height="54" class="rollover" /></a></li>
<li><a href="/chosenreason/index.html"><img src="/images/globalnavi02.jpg" alt="選ばれる理由" width="130" height="54" class="rollover" /></a></li>
<li><a href="/product_wire/index.html"><img src="/images/globalnavi03.jpg" alt="製品情報 電線" width="130" height="54" class="rollover" /></a></li>
<li><a href="/product_insulation/index.html"><img src="/images/globalnavi04.jpg" alt="製品情報 絶縁材料" width="130" height="54" class="rollover" /></a></li>
<li><a href="/product_processed/index.html"><img src="/images/globalnavi05.jpg" alt="製品情報 加工品" width="130" height="54" class="rollover" /></a></li>
<li><a href="/company/index.html"><img src="/images/globalnavi06.jpg" alt="会社情報" width="129" height="54" class="rollover" /></a></li>
<li><a href="https://www.yamatame.com/system/inquiries/" target="_blank"><img src="/images/globalnavi07.jpg" alt="お問い合わせ" width="128" height="54" class="rollover" /></a></li>
</ul>
</div>
</div>
<!-- GLOBALNAVI END -->
<!-- WRAPPER START -->
<div id="wrapper" class="clearfix">
<!-- CONTENT START -->
<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>
<?php echo $cakeDebug; ?>
<!-- CONTENT END-->
</div>
<!-- WRAPPER END -->
<?php include PUBLIC_HTML_DIR . 'common' . DS . 'inc' . DS . 'footer.inc'; ?>
</div>
<!-- CONTAINER END -->
</body>
</html>
