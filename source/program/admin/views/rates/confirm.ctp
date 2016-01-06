<?php e($msg->get('info', 'create_confirm')); ?><br />

<?php echo $form->create( 'Admin', array('type'=>'post', 'url' => '/rates/create/')); ?>
<table border="0" cellpadding="0" cellspacing="0" class="dataListTable2 fullwidth">

<?php require(dirname(__FILE__).DS.'parts_detail.ctp'); ?>

</table>

<div class="buttons1">
      <?php echo $form->submit( '入力へ戻る', array('div'=>false, 'name' => 'confirm_back_btn')); ?>
      <?php echo $form->submit( '　登録　', array('div'=>false, 'name' => 'commit_btn')); ?>
</div>

<?php echo $form->end(); ?>
