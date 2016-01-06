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
<title><?php echo ife($title_for_layout, $title_for_layout . " | ", "");?>株式会社　山田為商店</title>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.cssmenu.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.treeview.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.cookie.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/common.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.datepick.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo $html->url('/js/jquery.datepick-ja.js'); ?>"></script>
	<?php echo $html->css('redmond.datepick'); ?>
	<?php
		echo $scripts_for_layout;
	?>
<?php echo $html->css('import');?>
</head>

<body>
<div id="layout">
<div id="header">
	<h1><?php echo $html->image('logo02.gif', array('alt' => '株式会社　山田為商店')); ?></h1>
	<div id="headerTool">
		<div id="nowDate"><p>
			<?php list($y,$m,$d,$n)=explode('/',date('Y/n/j/N')); ?>
			<?php $week=array('日','月','火','水','木','金','土'); ?>
			<?php e($y); ?>年<?php e($m); ?>月<?php e($d); ?>日 <?php e($week[$n]); ?>曜日</p></div>
		<div id="toolNav">
			<ul>
			 <li class="admin"><?php e($user['Admin']['name'])?></li>
			 <li class="logout"><a href="<?php echo $html->url('/')?>tops/logout"><?php echo $html->image('logo_out.jpg', array('alt' => 'ログアウト')) ?></a></li>
			</ul>
		</div>
	</div>
</div>

<?php echo $this->element('header', array('auth_group_list' => $auth_group_list, 'auth_group_id' => $auth_group_id)); ?>

<!--MAINCONTENTS_START--><div id="container">
<table id="col2Frame">
<tr>
<td id="sideBar">
<?php echo $this->element('side_menu', array('auth_group_list' => $auth_group_list, 'auth_group_id' => $auth_group_id)); ?>
</td>
<td id="mainContents">
<h2><?php echo ife($title_for_layout, $title_for_layout, "");?>&nbsp;</h2>
  <?php if ($session->check('Message.flash')) : ?>
  <?php $session->flash(); ?>
  <?php endif; ?>
  <?php echo $content_for_layout; ?>
</td>
</tr>
</table>
<!--MAINCONTENTS_END--></div>

<?php echo $this->element('footer'); ?>
</div>
</body>
</html>
