<?php
/**
 * お問い合わせ情報モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/28
 * @version         1.00
 */
class Inquiry extends AppModel
{
	var $name = 'Inquiry';

    /**
     * 共通部分の登録チェック
     *
     * @access    public
     */
	function validates($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			// お問い合わせ製品名
			'product_name' => array(
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_PRODUCT_NAME')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_product_name_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_product_name_peculiar'),
					),
				),
			// 御社名
			'company_name' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_company_name_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_COMPANY_NAME')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_company_name_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_company_name_peculiar'),
					),
				),
			// 氏名
			'last_name' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_last_name_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_LAST_NAME')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_last_name_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_last_name_peculiar'),
					),
				),
			'first_name' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_first_name_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_FIRST_NAME')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_first_name_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_first_name_peculiar'),
					),
				),
			// カナ
			'last_kana' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_last_kana_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_LAST_KANA')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_last_kanalength'),
					),
				array(
					'rule' =>  array('is_katakana'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_last_kana_format'),
					),
				),
			'first_kana' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_first_kana_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_FIRST_KANA')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_first_kana_length'),
					),
				array(
					'rule' =>  array('is_katakana'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_first_kana_format'),
					),
				),
			'email' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_email_empty'),
					),
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_MAIL')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_email_length'),
					),
				array(
					'rule' => 'email',
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_email_format'),
					),
				),
			// 郵便番号
			'post1' => array(
				array(
					'rule' => array('fillAll', 'Inquiry.post1', 'Inquiry.post2'),
					'message' => $msg->get('error', 'inquiry_post1_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_POST1')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_post1_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_post1_format'),
					),
				),
			// 郵便番号
			'post2' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_POST2')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_post2_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_post2_format'),
					),
				),
			// 住所
			'add' => array(
				array(
					'rule' => array('max_length', $msg->get('const', 'MAXLENGTH_ADD')),
					'last' => true,
					'message' => $msg->get('error', 'inquiry_add_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_add_peculiar'),
					),
				),
			// 電話番号
			'tel1' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel1_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_TEL1')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_tel1_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel1_format'),
					),
				array(
					'rule' => array('chkLenAll', $msg->get('const', 'MAXLENGTH_INQUIRY_TEL'), '-', 'Inquiry.tel1', 'Inquiry.tel2', 'Inquiry.tel3'),
					'message' => $msg->get('error', 'inquiry_tel_length'),
					),
				),
			'tel2' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel2_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_TEL2')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_tel2_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel2_format'),
					),
				),
			'tel3' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel3_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_TEL3')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_tel3_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_tel3_format'),
					),
				),
			// FAX番号
			'fax1' => array(
				array(
					'rule' => array('fillAll', 'Inquiry.fax1', 'Inquiry.fax2', 'Inquiry.fax3'),
					'message' => $msg->get('error', 'inquiry_fax1_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_FAX1')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_fax1_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_fax1_format'),
					),
				array(
					'rule' => array('chkLenAll', $msg->get('const', 'MAXLENGTH_INQUIRY_FAX'), '-', 'Inquiry.fax1', 'Inquiry.fax2', 'Inquiry.fax3'),
					'message' => $msg->get('error', 'inquiry_fax_length'),
					),
				),
			'fax2' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_FAX2')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_fax2_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_fax2_format'),
					),
				),
			'fax3' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_FAX3')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_fax3_length'),
					),
				array(
					'rule' => array('is_digit'),
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_fax3_format'),
					),
				),
			// 本文
			'body' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'inquiry_body_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_INQUIRY_BODY')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_body_length'),
					),
				array(
					'rule' =>  array('peculiar'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'inquiry_body_peculiar'),
					),
				),
			);

		return parent::validates($options);
	}
	/**
	 * 引数で与えられたフィールドが、一つでも空欄が無いかチェックするバリデーションルール
	 * @return boolean
	 */
	function fillAll()
	{
		$args = func_get_args();
		$max = count($args) - 1;
		$stat = true;
		$no_count = 0;
		for ($i = 1; $i < $max; $i++) {
			$model = null;
			$field = null;
			if (preg_match("/^([^\.]+)\.([^\.]+)/", $args[$i], $matches)) {
				$model = $matches[1];
				$field = $matches[2];
			}
			if ((! empty($model)) && (! empty($field))) {
				if (empty($this->data[$model][$field])) {
					$no_count++;
				}
			}
		}
		if ( $no_count != 0 && $no_count < ($max - 1) ) {
			$stat = false;
		}
		return $stat;
	}
	/**
	 * 複数のフィールドの合計文字数をチェックするバリデーションルール
	 * @access    public
	 * @return boolean
	 */
	function chkLenAll()
	{
		$args    = func_get_args();
		$max     = count($args) - 1;
		$maxlen  = $args[1];
		$joint   = $args[2];
		$stat    = true;
		$tmp_str = null;
		for ($i = 3; $i < $max; $i++) {
			$model = null;
			$field = null;
			if (preg_match("/^([^\.]+)\.([^\.]+)/", $args[$i], $matches)) {
				$model = $matches[1];
				$field = $matches[2];
			}
			if ((! empty($model)) && (! empty($field))) {
				if ($tmp_str) {
					$tmp_str .= $joint;
				}
				if (!empty($this->data[$model][$field])) {
					$tmp_str .= $this->data[$model][$field];
				}
			}
		}
		if ( strlen($tmp_str) > $maxlen) {
			$stat = false;
		}
		return $stat;
	}
}
?>