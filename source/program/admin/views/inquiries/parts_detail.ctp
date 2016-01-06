<tr>
	<th>申込日時</th>
	<td>
	<?php e(h(ife($data['Inquiry']['created']!='', date('Y/m/d H:i:s', strtotime($data['Inquiry']['created'])), ''))); ?>
	</td>
</tr>
<tr>
	<th>お問い合わせ製品名</th>
	<td>
	<?php e(h($data['Inquiry']['product_name'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>社名</th>
	<td>
	<?php e(h($data['Inquiry']['company_name'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>氏名</th>
	<td>
	<?php e(h($data['Inquiry']['last_name'])); ?>&nbsp;<?php e(h($data['Inquiry']['first_name'])); ?>
	</td>
</tr>
<tr>
	<th>氏名フリガナ</th>
	<td>
	<?php e(h($data['Inquiry']['last_kana'])); ?>&nbsp;<?php e(h($data['Inquiry']['first_kana'])); ?>
	</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>
	<?php e(h($data['Inquiry']['email'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>郵便番号</th>
	<td class="data">
	<?php e(h($data['Inquiry']['post'])); ?>
	</td>
</tr>
<tr>
	<th>住所</th>
	<td>
	<?php e(h($data['Inquiry']['add'])); ?>&nbsp;
	</td>
</tr>
<tr>
	<th>電話番号</th>
	<td class="data">
	<?php e(h($data['Inquiry']['tel'])); ?>
	</td>
</tr>
<tr>
	<th>FAX番号</th>
	<td class="data">
	<?php e(h($data['Inquiry']['fax'])); ?>
	</td>
</tr>
<tr>
	<th>お問い合わせ内容</th>
	<td>
	<?php e(nl2br(h($data['Inquiry']['body']))); ?>&nbsp;
	</td>
</tr>
