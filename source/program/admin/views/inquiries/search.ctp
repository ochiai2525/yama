<?php $this->addScript($javascript->link("/js/form/inquiries_search.js")); ?>

<?php echo $form->create( 'InquirySearch', array('url' => '/inquiries/search', 'id'=>'frm')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="searchConditionTable2">
<tbody>
<tr>
	<th>申込日</th>
	<td>
	<?php echo $form->input('recept_start_date', array('class'=>'select_datepick', 'div'=>false,'label'=>false,'error'=>false, 'size'=>20, 'maxlength'=>$msg->get('const', 'MAXLENGTH_COMMONS_DATE'))); ?>
	&nbsp;～&nbsp;
	<?php echo $form->input('recept_end_date', array('class'=>'select_datepick', 'div'=>false,'label'=>false,'error'=>false, 'size'=>20, 'maxlength'=>$msg->get('const', 'MAXLENGTH_COMMONS_DATE'))); ?>
	<?php echo $form->error('InquirySearch.recept_start_date'); ?>
	<?php echo $form->error('InquirySearch.recept_end_date'); ?>
	</td>
	<td rowspan="2" class="button">
     <?php echo $form->submit( '検　　索', array('div'=>false, 'name' => 'search_btn')); ?>
	</td>
</tr>
<tr>
	<th>回答ステータス</th>
	<td>
		<?php e($form->input('answer_status',
			array('type'=>'select', 'options'=>$inquiry_answer_status_list, 'div'=>false, 'label'=>false, 'error'=>false, 'empty'=>'', ))); ?>
		<?php echo $form->error('InquirySearch.answer_status'); ?>
	</td>
</tr>
</tbody>
</table>
<?php echo $form->end(); ?>

<br />

<?php if (isset($paginator)): ?>
<?php if ($paginator->counter(array('format' =>'%count%'))=='0') : ?>
該当する情報はありません。
<?php else: ?>
<table border="0" cellpadding="0" cellspacing="00" class="actions">
<tr>
<td class="pager" width="100">
	全件数：<?php echo $paginator->counter(array('format' =>'%count%')); ?>件
</td>
<td class="pager">
	<input type="button" name="csv_btn" value="CSV出力" onClick="location.href='<?php echo $html->url('/inquiries/csv/'); ?>'" />
</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<thead>
<tr>
<th><?php echo $paginator->sort('申込日時', 'Inquiry.created'); ?></th>
<th><?php echo $paginator->sort('お問い合わせ製品名', 'Inquiry.product_name'); ?></th>
<th><?php echo $paginator->sort('社名', 'Inquiry.company_name'); ?></th>
<th><?php echo $paginator->sort('氏名', 'Inquiry.first_name'); ?></th>
<th><?php echo $paginator->sort('回答ステータス', 'Inquiry.answer_status'); ?></th>
<?php /* <th>email</th> */ ?>
<th><br /></th>
</tr>
</thead>
<tbody>
<?php if (is_array($data)) : foreach ($data as $param) : ?>
<tr>
	<td><?php e(h(ife($param['Inquiry']['created']!='', date('Y/m/d H:i:s', strtotime($param['Inquiry']['created'])), ''))); ?>&nbsp;</td>
	<td><?php e(h($param['Inquiry']['product_name'])); ?>&nbsp;</td>
	<td><?php e(h($param['Inquiry']['company_name'])); ?>&nbsp;</td>
	<td><?php e(h($param['Inquiry']['last_name'])); ?>&nbsp;<?php e(h($param['Inquiry']['first_name'])); ?></td>
	<td><?php e(h(ife(array_key_exists($param['Inquiry']['answer_status'], $inquiry_answer_status_list), $inquiry_answer_status_list[$param['Inquiry']['answer_status']], ''))); ?>&nbsp;</td>
	<td>
	<input type="button" name="detail_btn" value="詳細" onClick="location.href='<?php echo $html->url('/inquiries/detail/'.$param['Inquiry']['id']); ?>'" />
	</td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="pageNation2">
<tbody>
<tr>
<td>
<?php echo $paginator->prev('<< 前のページ ', null, null, array('class' => 'disabled', 'style' => 'display:inline;')); ?>
<?php echo $paginator->numbers(array('separator' => ' ')); ?>
<?php echo $paginator->next(' 次のページ >>', null, null, array('class' => 'disabled', 'style' => 'display:inline;')); ?>
</td>
</tr>
</tbody>
</table>

<?php endif; ?>
<?php endif; ?>

