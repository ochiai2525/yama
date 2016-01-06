<?php echo $form->create('Admin', array('url' => '/tops/login')); ?>
<div class="head">
	<?php echo $html->image('login_4.gif', array('alt' => 'ユーザ認証', 'width' => '347', 'height' => '29') );?>
</div>
<div class="form">
	<div id="loginFalut"><?php echo isset($err_msg) ? $err_msg : ""; ?></div>

	<table border="0" cellpadding="0" cellspacing="0">
	<tr>
	<th width="110">
		<?php echo $html->image('login_1.gif', array('alt' => 'ユーザID', 'width' => '110', 'height' => '17') );?>
	</th>
	<td>
		<?php echo $form->input('username', array('div'=>false,'label'=>false,'error'=>false, 'maxlength' => $msg->get('const', 'MAXLENGTH_LOGIN_USERNAME'),'style' => 'width:140px','onFocus' => 'msOver(this)','onBlur' => 'msOut(this)'))?>
	</td>
	</tr>
	<tr>
	<td colspan="2" class="error">
        <?php echo $form->error('Admin.username'); ?>
	</tr>
	<tr>
	<td>
		<img width="1" height="15" src="/img/spacer.gif" alt="" />
	</td>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<th width="110">
		<?php echo $html->image('login_2.gif', array('alt' => 'パスワード', 'width' => '110', 'height' => '17') );?>
	</th>
	<td><?php echo $form->password('password',array('div'=>false,'label'=>false,'error'=>false, 'value' => '', 'maxlength' => $msg->get('const', 'MAXLENGTH_LOGIN_PASSWORD'),'style' => 'width:140px','onFocus' => 'msOver(this)','onBlur' => 'msOut(this)'))?></td>
	</tr>
	<tr>
	<td colspan="2" class="error">
        <?php echo $form->error('Admin.password'); ?>
	</td>
	</tr>
	</table>
</div>
<div id="submit"><input type="image" src="<?php echo $html->url('/img/login_3.gif');?>" value="ログイン" onclick="this.form.submit(); return false;" /></div>
<?php echo $form->end(); ?>
