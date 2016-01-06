<?php echo $form->create( 'Rates', array('type'=>'post', 'url' => '/rates/detail/'.$data['Rates']['id'])); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<?php require(dirname(__FILE__).DS.'parts_detail.ctp'); ?>

</table>

<div class="buttons1">
      <?php echo $form->submit( '一覧へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
	  <?php echo $form->submit( '編集', array('div'=>false, 'name' => 'edit_btn')); ?>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <?php echo $form->submit( '削除する（確認）', array('div'=>false, 'name' => 'delete_btn')); ?>
</div>

<?php echo $form->end(); ?>
