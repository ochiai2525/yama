<tbody>
<tr>
	<th>一言コメント <span>※</span></th>
	<td>
		<?php echo $form->input('comment', array(
			'type' => 'textarea', 'div' => false, 'label' => false, 'error' => false, 'cols' => '80', 'rows' => 2,
		)); ?>
		<?php echo $form->error('comment'); ?>
	</td>
</tr>
<tr>
	<th>公開日 <span>※</span></th>
	<td>
	<?php echo $form->input('open_start_date_ymd',
		array('type' => 'text',
			'class'=>'select_datepick', 'div'=>false, 'label'=> false, 'error' => false, 'size'=>20, 'maxlength' => $msg->get('const', 'MAXLENGTH_COMMONS_DATE')
		)); ?>
		<?php echo $form->select('open_start_date_h', $time_list); ?>
時
から
	<?php echo $form->input('open_end_date_ymd',
		array('type' => 'text',
			'class'=>'select_datepick', 'div' => false, 'label' => false, 'error' => false, 'size'=>20, 'maxlength' => $msg->get('const', 'MAXLENGTH_COMMONS_DATE')
		)); ?>
		<?php echo $form->select('open_end_date_h', $time_list); ?>
時
まで
	<?php echo $form->error('open_start_date_ymd'); ?>
	<?php echo $form->error('open_end_date_ymd'); ?>
	</td>
</tr>

</tbody>
