<?php e($msg->get('info', 'create_confirm')); ?><br />

<?php echo $form->create( 'Admin', array('type'=>'post', 'url' => '/managers/create/')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<tbody>
<tr>
	<th>ログインID</th>
	<td>
	<?php e(h($this->data['Admin']['new_username'])); ?>
	</td>
</tr>
<tr>
	<th>パスワード</th>
	<td>
	********
	</td>
</tr>
<tr>
	<th>管理者名</th>
	<td>
	<?php e(h($this->data['Admin']['name'])); ?>
	</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>
	<?php e(h($this->data['Admin']['email'])); ?>
	</td>
</tr>
<tr>
	<th>権限</th>
	<td>
	<?php e(h($admintype_list[$this->data['Admin']['admintype']])); ?>
	</td>
</tr>
<tr>
	<th>メニュー</th>
	<td>
	<?php if ($this->data['Admin']['admintype'] == 1): ?>
	すべて
	<?php else: ?>
	<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
	<tbody>
	<?php foreach ($group_list as $id => $name): ?>
	<tr>
		<th><?php e(h($name)) ?></th>
		<td>
		<?php e(h($operation_auth_status_list[$this->data['Admin']['auth_menu_status:'.$id]])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>
	</td>
</tr>
</tbody>

</table>

<div class="buttons1">
      <?php echo $form->submit( '入力へ戻る', array('div'=>false, 'name' => 'confirm_back_btn')); ?>
      <?php echo $form->submit( '　登録　', array('div'=>false, 'name' => 'commit_btn')); ?>
</div>

<?php echo $form->end(); ?>
