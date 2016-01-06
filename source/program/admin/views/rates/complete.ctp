登録が完了しました。

<?php echo $form->create( 'Rates', array('type'=>'post', 'url' => '/rates/search/')); ?>

<div class="buttons1">
      <?php if (!isset($back) || $back == 'search'): ?>
      <input type="button" name="search_btn" value="一覧へ戻る" onclick="location.href='<?php echo $html->url('/rates/search/'); ?>'" />
      <?php else: ?>
      <input type="button" name="detail_btn" value="詳細へ戻る" onclick="location.href='<?php echo $html->url('/rates/detail/'.$data['Rates']['id']); ?>'" />
      <?php endif; ?>
</div>

<?php echo $form->end(); ?>
