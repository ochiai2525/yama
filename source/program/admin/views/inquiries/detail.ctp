<?php echo $form->create( 'Inquiry', array('type'=>'post', 'url' => '/inquiries/detail/'.$data['Inquiry']['id'])); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<tbody>

<?php
	if (isset($message) && $message != '') {
		e(h($message));
	}
?>

<?php require(dirname(__FILE__).DS.'parts_detail.ctp'); ?>
<tr>
	<th>備考</th>
	<td colspan="4">
		<?php echo $form->input('note', array(
									'type'  => 'textarea',
									'div'   => false,
									'label' => false,
									'error' => false,
									'cols'  => 100,
									'rows'  => 20,
		)); ?>
		<?php echo $form->error('note'); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>回答ステータス <span>※</span></th>
	<td colspan="4">
		<?php echo $form->input('answer_status', array(
									'type'    => 'select',
									'options' => $inquiry_answer_status_list,
									'div'     => false,
									'label'   => false,
									'error'   => false,
									'empty'   => '',
		)); ?>
		<?php echo $form->error('answer_status'); ?>
	</td>
</tr>

</tbody>

</table>

<div class="buttons1">
      <?php echo $form->submit( '一覧へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
      <?php echo $form->submit( '入力内容を保存', array('div'=>false, 'name' => 'save_btn')); ?>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $form->submit( '削除する（確認）', array('div'=>false, 'name' => 'delete_btn')); ?>
</div>

<?php echo $form->end(); ?>
