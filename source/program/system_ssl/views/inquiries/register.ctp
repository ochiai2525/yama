<div id="content" class="clearfix">
<!-- MAIN START -->
<div id="main">
<h1><img src="/images/keyviaul.jpg" alt="お問い合わせ" width="899" height="137" /></h1>
<h2><img src="/images/index_subtitle.gif" alt="注意事項" width="901" height="30" /></h2>
<ul id="attention">
<li>必要事項をご記入し、「<a href="http://www.yamatame.com/policy/policy.html" target="blank">プライバシーポリシー</a>」に承諾の上、｢送信確認｣ボタンを押してください。</li>
<li>文字化けを防ぐために、半角カタカナ、丸数字、特殊文字は使用しないでください。</li>
<li><span>※</span>マークの付いている項目は必須入力になります。</li>
</ul>
<h3>電話でのお問合せ</h3>
<address>TEL（06）6641-7551&nbsp;FAX（06）6641-7559<br />
〒556-0002　大阪市浪速区恵美須東１丁目22番16号　株式会社山田為商店</address>
<?php echo $form->create( 'Inquiry', array('type'=>'post', 'enctype' => 'multipart/form-data', 'url' => '/inquiries/register/', 'id'=>'frm', 'name'=>'frm')); ?>
<table class="form" summary="お問い合わせ">
<tr>
<th>お問合せ製品名</th>
<td>
	<?php e($form->error('product_name', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('product_name', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'long',
		'maxlength' => $msg->get('const', 'MAXLENGTH_PRODUCT_NAME')
	)); ?>
</td>
</tr>
<tr>
<th>御社名&nbsp;<span>※</span></th>
<td>
	<?php e($form->error('company_name', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('company_name', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'long',
		'maxlength' => $msg->get('const', 'MAXLENGTH_COMPANY_NAME')
	)); ?>
</td>
</tr>
<tr>
<th>氏名&nbsp;<span>※</span></th>
<td>
	<?php e($form->error('last_name', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('first_name', array('wrap'=>'span','class'=>'error_message'))); ?>
姓&nbsp;
	<?php echo $form->input('last_name', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'middle',
		'maxlength' => $msg->get('const', 'MAXLENGTH_LAST_NAME')
	)); ?>
　名&nbsp;
	<?php echo $form->input('first_name', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'middle',
		'maxlength' => $msg->get('const', 'MAXLENGTH_LAST_NAME')
	)); ?><br />
【全角】　例）山田　太郎
</td>
</tr>
<tr>
<th>氏名(フリガナ)&nbsp;<span>※</span></th>
<td>
	<?php e($form->error('kana', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('last_kana', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('first_kana', array('wrap'=>'span','class'=>'error_message'))); ?>
セイ&nbsp;
	<?php echo $form->input('last_kana', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'middle',
		'maxlength' => $msg->get('const', 'MAXLENGTH_LAST_KANA')
	)); ?>
　メイ&nbsp;
	<?php echo $form->input('first_kana', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'middle',
		'maxlength' => $msg->get('const', 'MAXLENGTH_LAST_KANA')
	)); ?><br />
【全角】　例）ヤマダ　タロウ
</td>
</tr>
<tr>
<th>メールアドレス&nbsp;<span>※</span></th>
<td>
	<?php e($form->error('email', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('email', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'long',
		'maxlength' => $msg->get('const', 'MAXLENGTH_MAIL')
	)); ?><br />
【半角】　例）info@yamatame.com
</td>
</tr>
<tr>
<th>郵便番号</th>
<td>
	<?php e($form->error('post1', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('post2', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('post1', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'maxlength' => $msg->get('const', 'MAXLENGTH_POST1')
	)); ?>
	&nbsp;-&nbsp;
	<?php echo $form->input('post2', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'maxlength' => $msg->get('const', 'MAXLENGTH_POST2')
	)); ?>　【半角数字】　例）000-0000
</td>
</tr>
<tr>
<th>住所</th>
<td>
	<?php e($form->error('add', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('add', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'long',
		'maxlength' => $msg->get('const', 'MAXLENGTH_ADD')
	)); ?>
</td>
</tr>
<tr>
<th>電話番号&nbsp;<span>※</span></th>
<td>
	<?php e($form->error('tel1', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('tel2', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('tel3', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('tel1', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_TEL1')
	)); ?>
	&nbsp;-&nbsp;
	<?php echo $form->input('tel2', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_TEL2')
	)); ?>
	&nbsp;-&nbsp;
	<?php echo $form->input('tel3', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_TEL3')
	)); ?>
　【半角数字】　例）06-0000-0000
</td>
</tr>
<tr>
<th>FAX番号</th>
<td>
	<?php e($form->error('fax1', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('fax2', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php e($form->error('fax3', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('fax1', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_FAX1')
	)); ?>
	&nbsp;-&nbsp;
	<?php echo $form->input('fax2', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_FAX2')
	)); ?>
	&nbsp;-&nbsp;
	<?php echo $form->input('fax3', array(
		'type'  => 'text',
		'div'   => false,
		'label' => false,
		'error' => false,
		'class' => 'short',
		'maxlength' => $msg->get('const', 'MAXLENGTH_FAX3')
	)); ?>
　【半角数字】　例）06-0000-0000
</td>
</tr>
<tr>
<th>お問合せ内容&nbsp;<span>※</span><br />(コメント)</th>
<td>
	<?php e($form->error('body', array('wrap'=>'span','class'=>'error_message'))); ?>
	<?php echo $form->input('body', array(
		'type'  => 'textarea',
		'div'   => false,
		'label' => false,
		'error' => false,
		'cols'  => '45',
		'rows'  => '8',
		'class' => 'comment',
		'wrap'  => 'hard',
	)); ?>
</td>
</tr>
</table>
<div id="check">
	<p>「<a href="http://www.yamatame.com/policy/policy.html" target="blank">プライバシーポリシー</a>」に関する確認事項を必ずお読みください。<br />
	内容を確認し、承諾される方は下の「承諾する」を選択してください。</p>
	<p class="check_radio">
		<?php $checked = null;if(isset($this->data['Inquiry']['agree']) && $this->data['Inquiry']['agree'] == '0'):$checked = ' checked';endif;?>
		<input type="radio" name="data[Inquiry][agree]" value="0" id="agree"<?php e($checked);?>><label for="agree">&nbsp;承諾する</label>&nbsp;&nbsp;
		<input type="radio" name="data[Inquiry][agree]" value="1" id="disagree"><label for="disagree">&nbsp;承諾しない</label>
	</p> 
	<?php echo $form->error('agree'); ?>
	<p class="center">
		<input type="image" src="/images/index_btn01.jpg" class="rollover" alt="送信確認" name="confirm_img" id="confirm_img"/>
	</p>
</div>
<p class="right"><script src=https://seal.verisign.com/getseal?host_name=www.yamatame.com&size=S&use_flash=YES&use_transparent=YES&lang=ja></script></p>
<p class="right">このページは、プライバシー保護のためSSL暗号化通信を採用しています。</p>
<?php echo $form->end(); ?>
</div>
<!-- MAIN END -->
