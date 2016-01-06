<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>お問い合わせ | 株式会社　山田為商店</title>
<meta name="keywords" content="電線,絶縁材料,加工,山田為商店" />
<meta name="description" content="製品情報やその他に関するお問い合わせフォームです。山田為商店は電線、絶縁材料、加工品をトータルにご提供します。" />
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
<!-- HEADER START -->
<div id="header">
<div class="inner clearfix">
<div>
<p id="logo"><img src="/images/rogo.jpg" alt="山田為商店" width="900" height="53" /></p>
</div>
</div>
</div>
<!-- HEADER END -->
<!-- CONTENT START -->
<?php $session->flash(); ?>
<?php echo $content_for_layout; ?>
<?php echo $cakeDebug; ?>
<!-- CONTENT END-->
<!-- FOOTER START-->
<div id="footer" class="clearfix">
<div class="inner clearfix">
<div class="clearfix">
<address><img src="/images/footer_address.jpg" alt="株式会社　山田為商店　大阪府 大阪市浪速区 恵美須東1丁目22-16" width="255" height="22" />
</address>
<p id="copyright"><img src="/images/footer_copyright.jpg" alt="(C)Yamada Tame Shoten Co.,Ltd. All Right Reserved" width="252" height="20" /></p>
</div>
</div>
</div>
<!-- FOOTER END -->
</div>
<!-- CONTAINER END -->
</body>
</html>
