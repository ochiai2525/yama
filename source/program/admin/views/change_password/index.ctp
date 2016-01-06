
<?php echo $form->create( 'Admin', array('type'=>'post', 'url' => '/change_password/')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<tbody>
<tr>
	<th>現在のパスワード</th>
	<td>
	<?php echo $form->password('now_password', array('div'=>false,'label'=>false,'error'=>false, 'size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD'))); ?>
	<?php echo $form->error('now_password'); ?>
	</td>
</tr>
<tr>
	<th>新しいパスワード</th>
	<td>
	<?php echo $form->password('new_password', array('div'=>false,'label'=>false,'error'=>false, 'size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD'))); ?>
	<?php echo $form->error('new_password'); ?>
	</td>
</tr>
<tr>
	<th>新しいパスワード（確認）</th>
	<td>
	<?php echo $form->password('new_password_cfm', array('div'=>false,'label'=>false,'error'=>false, 'size'=>30, 'maxlength'=>$msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD'))); ?>
	<?php echo $form->error('new_password_cfm'); ?>
	</td>
</tr>
</tbody>
<tfoot>
<tr>
<td colspan="2" class="foot">
  <?php echo $form->submit( '変更', array('div'=>false, 'name' => 'commit_btn')); ?>
</td>
</tr>
</tfoot>
</table>
<?php echo $form->end(); ?>