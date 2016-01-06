<tbody>
<tr>
	<th>一言コメント</th>
	<td>
	<?php e(nl2br(h($data['Rates']['comment']))); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>公開日</th>
	<td>
		<?php if (isset($data['Rates']['open_start_date_ymd']) && $data['Rates']['open_start_date_ymd'] != ''
			&& isset($data['Rates']['open_start_date_h']) && $data['Rates']['open_start_date_h'] != ''): ?>
			<?php 
				$open_start_date = sprintf('%s %s', $data['Rates']['open_start_date_ymd'], $data['Rates']['open_start_date_h']);
				e(h($output->dt($open_start_date, 'Y年m月d日 H時')));
			?>
		<?php endif; ?>
		から
		<?php if (isset($data['Rates']['open_end_date_ymd']) && $data['Rates']['open_end_date_ymd'] != ''
		&& isset($data['Rates']['open_end_date_h']) && $data['Rates']['open_end_date_h'] != ''): ?>
			<?php 
				$open_end_date = sprintf('%s %s', $data['Rates']['open_end_date_ymd'], $data['Rates']['open_end_date_h']);
				e(h($output->dt($open_end_date, 'Y年m月d日 H時')));
			?>
			&nbsp;まで
		<?php endif; ?>&nbsp;
	</td>
</tr>
</tbody>
