<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<title><?php echo ife($title_for_layout, $title_for_layout . " | ", "");?>山田為商店</title>
<script type="text/javascript" src="<?php echo $html->url('/js/jquery.js'); ?>"></script>
<script type="text/javascript" src="<?php echo $html->url('/js/common.js'); ?>"></script>
<?php
	echo $html->meta('icon');
	echo $scripts_for_layout;
?>
<!--[if lt IE 7.]><script type="text/javascript" src="<?php echo $html->url('/js/iepngfix.js');?>"></script><![endif]-->
<?php echo $html->css('main');?>

</head>

<body>
<div id="layout">

<div id="Header"><!--HEADER_START-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
	<?php echo $html->image('logo.gif', array('alt' => '株式会社　山田為商店') );?>
</td>
<td align="right">&nbsp;</td>
</tr>
</table>
<!--HEADER_END--></div>

<!--MAINCONTENTS_START--><div id="Container">
<div id="loginBox">
<div id="login">
	<?php if ($session->check('Message.flash'))
			{
				$session->flash();
			}
			echo $content_for_layout;
	?>
	<?php echo $cakeDebug; ?>

</div>
</div>
<!--MAINCONTENTS_END--></div>

<!--FOOTER_START-->
<?php echo $this->element('footer'); ?>
<!--FOOTER_END-->

</div>
</body>
</html>
