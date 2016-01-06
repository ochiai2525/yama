<?php e($msg->get('info', 'delete_confirm')); ?><br />

<?php echo $form->create( 'Rates', array('type'=>'post', 'url' => '/rates/delete/'.$data['Rates']['id'])); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<?php require(dirname(__FILE__).DS.'parts_detail.ctp'); ?>

</table>

<div class="buttons1">
      <?php echo $form->submit( '詳細へ戻る', array('div'=>false, 'name' => 'back_btn')); ?>
      <?php echo $form->submit( '削除する', array('div'=>false, 'name' => 'commit_btn')); ?>
</div>

<?php echo $form->end(); ?>
