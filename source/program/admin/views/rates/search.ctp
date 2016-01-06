<?php $this->addScript($javascript->link("/js/jkl-calendar.js")); ?>
<?php $this->addScript($javascript->link("/js/form/rates_search.js")); ?>

<?php echo $form->create( null, array('type'=>'post', 'url' => '/rates/create')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="actions">
<tr>
	<td class="button">
     <?php echo $form->submit( '新規登録', array('div'=>false, 'name' => 'create_btn')); ?>
	</td>
</tr>
</table>
<?php echo $form->end(); ?>
<br />

<?php echo $form->create( 'RatesSearch', array('url' => '/rates/search', 'id'=>'frm')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="searchConditionTable2">
<tbody>
<tr>
	<th>一言コメント</th>
	<td>
		<?php echo $form->input('comment', array(
			'type' => 'text', 'div' => false, 'label' => false, 'error' => false, 'maxlength' => $msg->get('const', 'MAXLENGTH_RATE_COMMENT')
		)); ?>
	</td>
	<td rowspan="2" class="button">
     <?php echo $form->submit( '検　　索', array('div'=>false, 'name' => 'search_btn')); ?>
	</td>
</tr>
<tr>
	<th>公開期間</th>
	<td>
	<?php echo $form->input('recept_start_date', array('class'=>'select_datepick', 'div'=>false,'label'=>false,'error'=>false, 'maxlength'=>$msg->get('const', 'MAXLENGTH_COMMONS_DATE'))); ?>
	&nbsp;～&nbsp;
	<?php echo $form->input('recept_end_date', array('class'=>'select_datepick', 'div'=>false,'label'=>false,'error'=>false, 'maxlength'=>$msg->get('const', 'MAXLENGTH_COMMONS_DATE'))); ?>
	<?php echo $form->error('RatesSearch.recept_start_date'); ?>
	<?php echo $form->error('RatesSearch.recept_end_date'); ?>
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
</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<thead>
<tr>
<th><?php echo $paginator->sort('一言コメント', 'comment'); ?></th>
<th><?php echo $paginator->sort('公開開始日時', 'open_start_date'); ?></th>
<th><?php echo $paginator->sort('公開終了日時', 'open_end_date'); ?></th>
<th><br /></th>
</tr>
</thead>
<tbody>
<?php if (is_array($data)) : foreach ($data as $key => $param) : ?>
<tr>
	<td><?php e(nl2br(h($param['Rates']['comment']))); ?>&nbsp;</td>
	<td>
		<?php e(h(ife(!empty($param['Rates']['open_start_date']), $output->dt($param['Rates']['open_start_date'], 'Y年m月d日 H時'), ''))); ?>&nbsp;
	</td>
	<td>
		<?php e(h(ife(!empty($param['Rates']['open_end_date']), $output->dt($param['Rates']['open_end_date'], 'Y年m月d日 H時'), ''))); ?>&nbsp;
	</td>
	<td>
	<input type="button" name="detail_btn" value="詳細" onclick="location.href='<?php echo $html->url('/rates/detail/'.$param['Rates']['id']); ?>'" />
	<input type="button" name="edit_btn" value="編集" onclick="location.href='<?php echo $html->url('/rates/edit/'.$param['Rates']['id']); ?>'" />
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
