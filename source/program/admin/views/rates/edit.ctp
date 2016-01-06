<?php $this->addScript($javascript->link("/js/form/rates.js")); ?>

<?php echo $form->create( 'Rates', array('type'=>'post', 'enctype' => 'multipart/form-data', 'url' => '/rates/edit/'.$data['Rates']['id'], 'id'=>'frm')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<?php require(dirname(__FILE__).DS.'parts_input.ctp'); ?>

</table>

<div class="buttons1">
      <?php if (!isset($back) || $back == 'search'): ?>
      <input type="button" name="search_btn" value="一覧へ戻る" onclick="location.href='<?php echo $html->url('/rates/search/'); ?>'" />
      <?php else: ?>
      <input type="button" name="detail_btn" value="詳細へ戻る" onclick="location.href='<?php echo $html->url('/rates/detail/'.$data['Rates']['id']); ?>'" />
      <?php endif; ?>
      <?php echo $form->submit( '編集確認', array('div'=>false, 'name' => 'confirm_btn')); ?>
</div>

<?php echo $form->end(); ?>
