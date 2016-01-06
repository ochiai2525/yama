<?php $this->addScript($javascript->link("/js/jkl-calendar.js")); ?>
<?php $this->addScript($javascript->link("/js/jquery.clockpick.js")); ?>
<?php $this->addScript($html->css("clockpick")); ?>

<?php echo $form->create( null, array('type'=>'post', 'url' => '/managers/create')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="actions">
<tr>
	<td class="button">
     <?php echo $form->submit( '新規登録', array('div'=>false, 'name' => 'create_btn')); ?>
	</td>
</tr>
</table>
<?php echo $form->end(); ?>

<br />

<?php if (isset($paginator)): ?>
<?php if ($paginator->counter(array('format' =>'%count%'))=='0') : ?>
該当する情報はありません。
<?php else: ?>
<table border="0" cellpadding="0" cellspacing="00" class="actions">
<tr>
<td class="pager">
	全件数：<?php echo $paginator->counter(array('format' =>'%count%')); ?>件
</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
<thead>
<tr>
<th><?php echo $paginator->sort('ログインID', 'username'); ?></th>
<th><?php echo $paginator->sort('管理者名', 'name'); ?></th>
<th><?php echo $paginator->sort('メールアドレス', 'email'); ?></th>
<th><?php echo $paginator->sort('管理者種別', 'admintype'); ?></th>
<th>権限</th>
<th><br /></th>
</tr>
</thead>
<tbody>
<?php if (is_array($data)) : foreach ($data as $param) : ?>
<tr>
	<td><?php e(h($param['Admin']['username'])); ?>&nbsp;</td>
	<td><?php e(h($param['Admin']['name'])); ?>&nbsp;</td>
	<td><?php e(h($param['Admin']['email'])); ?>&nbsp;</td>
	<td><?php e(h(ife(array_key_exists($param['Admin']['admintype'],$admintype_list), $admintype_list[$param['Admin']['admintype']], ''))); ?></td>
	<td><?php if ($param['Admin']['admintype'] == 1): ?>
			すべて
		<?php else: ?>
		<?php foreach ($param['Group'] as $row): ?>
		<?php e($row['name']); ?> - <?php e(h($operation_auth_status_list[$row['AdminsGroup']['authtype']])); ?><br />
		<?php endforeach; ?>
		<?php endif; ?>&nbsp;
	</td>
	<td>
	<input type="button" name="detail_btn" value="詳細" onclick="location.href='<?php echo $html->url('/managers/detail/'.$param['Admin']['id']); ?>'" />
	<input type="button" name="edit_btn" value="編集" onclick="location.href='<?php echo $html->url('/managers/edit/'.$param['Admin']['id']); ?>'" />
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