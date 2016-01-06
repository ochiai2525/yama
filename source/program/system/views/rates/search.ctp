<div id="content" class="clearfix">
	<p id="pankuzu"><a href="/index.html">HOME</a> &gt; 相場情報一覧</p>
	<!-- MAIN START -->
		<div id="main">
			<p id="mainvisual"><img src="/images/marketiinfo/index_keyvisaul.jpg" alt="相場情報" width="642" height="129" /></p>
			<h1><img src="/images/marketiinfo/index_tiltle.gif" alt="相場情報一覧" width="642" height="30" border="0" usemap="#Map" />
<map name="Map" id="Map"><area shape="rect" coords="578,0,643,29" href="http://www.yamatame.com/system/rates/search.rss" alt="RSS" />
</map></h1>
			<?php if (isset($paginator)): ?>
				<?php if ($paginator->counter(array('format' =>'%count%')) == '0') : ?>
					<p>ただいま相場情報はございません。</p>
				<?php else: ?>
					<?php if (is_array($data)) : ?>
						<dl class="info">
						<?php foreach ($data as $key => $param) : ?>
							<dt><?php e(h(ife(!empty($param['Rates']['open_start_date']), date('Y.m.d', strtotime($param['Rates']['open_start_date'])), ''))); ?>&nbsp;</dt>
							<dd><?php e(nl2br(h($param['Rates']['comment']))); ?></dd>
						<?php endforeach; ?>
						</dl>
						<!-- 改ページ -->
						<?php if($paginator->counter(array('format' =>'%pages%')) > 1) : ?>
							<div id="page" class="clearfix">
								<p id="prev">
									<?php echo $paginator->prev('<　戻る', null, null, null); ?>
								</p>
								<p id="next">
									<?php echo $paginator->next('次へ　>', null, null, null); ?>
								</p>
							</div>
						<?php endif; ?>
						<!-- 改ページ -->
					<?php endif; ?>
				<?php endif; ?>
			<?php else: ?>
				<p>ただいま相場情報はございません。</p>
			<?php endif; ?>
		</div>
	<!-- MAIN END -->
	<?php include PUBLIC_HTML_DIR . 'common' . DS . 'inc' . DS . 'localnav.inc'; ?>
</div>
