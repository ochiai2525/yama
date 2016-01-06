<?php $this->addScript($javascript->link("/js/form/managers.js")); ?>

<?php echo $form->create( 'Admin', array('type'=>'post', 'url' => '/managers/create/', 'id'=>'frm')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<tbody>
<tr>
	<th>ログインID</th>
	<td>
	<?php echo $form->input('new_username', array('div'=>false,'label'=>false,'error'=>false, 'size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_USERNAME'))); ?>
	<?php echo $form->error('new_username'); ?>
	</td>
</tr>
<tr>
	<th>パスワード</th>
	<td>
	<?php echo $form->password('new_password', array('size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD'))); ?>
	<?php echo $form->error('new_password'); ?>
	</td>
</tr>
<tr>
	<th>パスワード（確認）</th>
	<td>
	<?php echo $form->password('new_password_cfm', array('size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD'))); ?>
	<?php echo $form->error('new_password_cfm'); ?>
	</td>
</tr>
<tr>
	<th>管理者名</th>
	<td>
	<?php echo $form->input('name', array('div'=>false,'label'=>false,'error'=>false, 'size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_NAME'))); ?>
	<?php echo $form->error('name'); ?>
	</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>
	<?php echo $form->input('email', array('div'=>false,'label'=>false,'error'=>false, 'size'=>50, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_EMAIL'))); ?>
	<?php echo $form->error('email'); ?>
	</td>
</tr>
<tr>
	<th>種別</th>
	<td>
    <?php echo $form->radio('admintype', $admintype_list, array('label'=>true, 'legend'=>'', 'class' => 'auth_menu_flag')); ?>
	<?php echo $form->error('admintype'); ?>
	</td>
</tr>
<tr>
	<th>メニュー</th>
	<td>
	<div id="auth_group_list">
	<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
	<tbody>
	<?php foreach ($group_list as $id => $name): ?>
	<tr>
		<th><?php e(h($name)) ?></th>
		<td>
		<?php echo $form->hidden('id:'.$id); ?>
	    <?php echo $form->radio('auth_menu_status:'.$id, $operation_auth_status_list, array('label'=>true, 'legend'=>'')); ?>
		<?php echo $form->error('auth_menu_status:'.$id); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	</div>
	</td>
</tr>
</tbody>

</table>

<div class="buttons1">
      <?php echo $form->submit( '一覧へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
      <?php echo $form->submit( '登録確認', array('div'=>false, 'name' => 'confirm_btn')); ?>
</div>

<?php echo $form->end(); ?>