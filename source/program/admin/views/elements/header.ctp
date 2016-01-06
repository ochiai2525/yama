<div id="globalNav" class="jquerycssmenu">
	<ul>
	<li <?php if ($auth_group_id==-1): ?>class="on"<?php endif; ?>><?php echo $html->link('Top', '/menus/'); ?></li>
	<?php foreach ($auth_group_list as $group): ?>
	<?php if (isset($group['Menu'][0]['url'])): ?>
	<li <?php if ($group['Group']['id']==$auth_group_id): ?>class="on"<?php endif; ?>>
		<?php echo $html->link($group['Group']['name'], $group['Menu'][0]['url']); ?>
		<?php if (!empty($group['Menu'])): ?>
		<ul>
		<?php foreach ($group['Menu'] as $menu): ?>
		<li><?php echo $html->link($menu['name'], $menu['url']); ?></li>
		<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>
