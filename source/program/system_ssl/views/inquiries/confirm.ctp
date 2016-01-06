<div id="content" class="clearfix">

<!-- MAIN START -->
<div id="main">
<?php echo $form->create('Inquiry', array('type'=>'post', 'url' => '/inquiries/register/')); ?>
<h1><img src="/images/keyviaul.jpg" alt="お問い合わせ" width="899" height="137" /></h1>
<h2><img src="/images/index_subtitle02.gif" alt="内容のご確認" width="901" height="31" /></h2>
<table class="form" summary="お問い合わせ">
<tr>
<th>お問合せ製品名</th>
<td>
	<?php e(h($this->data['Inquiry']['product_name'])); ?>&nbsp;
</td>
</tr>
<tr>
<th>御社名</th>
<td>
	<?php e(h($this->data['Inquiry']['company_name'])); ?>&nbsp;
</td>
</tr>
<tr>
<th>氏名</th>
<td>
	<?php e(h($this->data['Inquiry']['last_name'])); ?>&nbsp;<?php e(h($this->data['Inquiry']['first_name'])); ?>
</td>
</tr>
<tr>
<th>氏名(フリガナ)</th>
<td>
	<?php e(h($this->data['Inquiry']['last_kana'])); ?>&nbsp;<?php e(h($this->data['Inquiry']['first_kana'])); ?>
</td>
</tr>
<tr>
<th>メールアドレス</th>
<td>
	<?php e(h($this->data['Inquiry']['email'])); ?>&nbsp;
</td>
</tr>
<tr>
<th>郵便番号</th>
<td>
	<?php
		if ($this->data['Inquiry']['post1'] && $this->data['Inquiry']['post2']):
			e(h($this->data['Inquiry']['post1'] . '-' . $this->data['Inquiry']['post2']));
		endif;
	?>
</td>
</tr>
<tr>
<th>住所</th>
<td>
	<?php e(h($this->data['Inquiry']['add'])); ?>&nbsp;
</td>
</tr>
<tr>
<th>電話番号</th>
<td>
	<?php e(h($this->data['Inquiry']['tel1'] . '-' . $this->data['Inquiry']['tel2'] . '-' . $this->data['Inquiry']['tel3'])); ?>
</td>
</tr>
<tr>
<th>FAX番号</th>
<td>
	<?php
		if ($this->data['Inquiry']['fax1'] && $this->data['Inquiry']['fax2'] && $this->data['Inquiry']['fax3']):
			e(h($this->data['Inquiry']['fax1'] . '-' . $this->data['Inquiry']['fax2'] . '-' . $this->data['Inquiry']['fax3']));
		endif;
	?>
</td>
</tr>
<tr>
<th>お問合せ内容 <br />(コメント)</th>
<td>
	<?php e(nl2br(h($this->data['Inquiry']['body']))); ?>&nbsp;
</td>
</tr>
</table>

<div id="check">
<p>上記の内容でよろしければ送信ボタンを押してください。</p>
<p class="check_radio">
<input type="image" src="/images/index_btn03.jpg" class="rollover" alt="戻る" id="back_btn" name="back_btn" />&nbsp;&nbsp;
<input type="image" src="/images/index_btn02.jpg" class="rollover" alt="送信" id="commit_btn" name="commit_btn" />
</p>
</div>
<?php echo $form->end(); ?>
</div>
<!-- MAIN END -->
</div>
