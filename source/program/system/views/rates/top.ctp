<?php if (is_array($data)) : ?>
	<dl class="info">
<?php foreach ($data as $key => $param) : ?>
	<dt><?php e(h(ife(!empty($param['Rates']['open_start_date']), date('Y.m.d', strtotime($param['Rates']['open_start_date'])), ''))); ?>&nbsp;</dt>
	<?php if (count($data) == $key+1) : ?>
	<dd class="end">
	<?php else: ?>
	<dd>
	<?php endif; ?>
		<?php e(nl2br(h($param['Rates']['comment']))); ?></dd>
<?php endforeach; ?>
	</dl>
<?php endif; ?>
