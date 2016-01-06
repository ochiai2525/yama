登録が完了しました。

<?php echo $form->create( 'Inquiry', array('type'=>'post', 'url' => '/inquiries/search/')); ?>

<div class="buttons1">
      <?php if (!isset($back) || $back == 'search'): ?>
      <input type="button" name="search_btn" value="一覧へ戻る" onclick="location.href='<?php echo $html->url('/inquiries/search/'); ?>'" />
      <?php else: ?>
      <input type="button" name="detail_btn" value="詳細へ戻る" onclick="location.href='<?php echo $html->url('/inquiries/detail/'.$data['Inquiry']['id']); ?>'" />
      <?php endif; ?>
</div>

<?php echo $form->end(); ?>
