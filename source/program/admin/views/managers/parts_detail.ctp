<tbody>
<tr>
	<th>ログインID</th>
	<td>
	<?php e(h($data['Admin']['username'])); ?>&nbsp;
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
	<?php e(h($data['Admin']['name'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>
	<?php e(h($data['Admin']['email'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>権限</th>
	<td>
	<?php e(h(ife(array_key_exists($data['Admin']['admintype'], $admintype_list), $admintype_list[$data['Admin']['admintype']], ''))); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>メニュー</th>
	<td>
	<?php if ($data['Admin']['admintype'] == 1): ?>
	すべて
	<?php else: ?>
	<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">
	<tbody>
	<?php foreach ($data['Group'] as $group): ?>
	<tr>
		<th><?php e(h($group['name'])) ?></th>
		<td>
		<?php e(h($operation_auth_status_list[$group['AdminsGroup']['authtype']])); ?>&nbsp;
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>&nbsp;
	</td>
</tr>
</tbody>