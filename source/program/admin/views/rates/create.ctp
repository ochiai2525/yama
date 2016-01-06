<?php $this->addScript($javascript->link("/js/form/rates.js")); ?>

<?php echo $form->create( 'Rates', array('type'=>'post', 'enctype' => 'multipart/form-data', 'url' => '/rates/create/', 'id'=>'frm')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<?php require(dirname(__FILE__).DS.'parts_input.ctp'); ?>

</table>

<div class="buttons1">
      <?php echo $form->submit( '一覧へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
      <?php echo $form->submit( '登録確認', array('div'=>false, 'name' => 'confirm_btn')); ?>
</div>

<?php echo $form->end(); ?>
