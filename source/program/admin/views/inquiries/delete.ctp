<?php e($msg->get('info', 'delete_confirm')); ?><br />

<?php echo $form->create( 'Inquiry', array('type'=>'post', 'url' => '/inquiries/delete/'.$data['Inquiry']['id'])); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<tbody>

<?php require(dirname(__FILE__).DS.'parts_detail.ctp'); ?>

<tr>
	<th>備考</th>
	<td colspan="4">
	<?php e(nl2br(h($data['Inquiry']['note']))); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>回答ステータス</th>
	<td colspan="4">
	<?php e(h(ife(array_key_exists($data['Inquiry']['answer_status'], $inquiry_answer_status_list), $inquiry_answer_status_list[$data['Inquiry']['answer_status']], ''))); ?>&nbsp;
	</td>
</tr>
</tbody>
</table>

<div class="buttons1">
      <?php echo $form->submit( '詳細へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
      <?php echo $form->submit( '削除する', array('div'=>false, 'name' => 'commit_btn')); ?>
</div>

<?php echo $form->end(); ?>
