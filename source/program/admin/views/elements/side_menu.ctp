	<h3>管理メニュー</h3>
	<div id="localNav">
		<ul>
		<?php if (is_array($auth_group_list)): foreach ($auth_group_list as $group): ?>
		<?php if ($group['Group']['id']==$auth_group_id): ?>
		<?php foreach ($group['Menu'] as $menu): ?>
			<li><?php echo $html->link($menu['name'], $menu['url']); ?></li>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php endforeach; endif; ?>
		</ul>
		<?php if ($auth_group_id==-1): ?>
		<li><?php echo $html->link('パスワード変更', '/change_password/'); ?></li>
		<?php endif; ?>
	</div>


