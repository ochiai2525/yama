<?php
/**
 * お問い合わせ情報検索モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/18
 * @version         1.00
 */
class InquirySearch extends AppModel
{
	var $name = 'InquirySearch';
	var $useTable = false;

	/**
	 * フォーム値チェック
	 *
	 * @access public
	 **/

	function validates($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			'inquiry_type' => array(
				array(
					'rule' => 'numeric',
					'last' => true,
					'message' => $msg->get('error', 'system_input'),
					'allowEmpty' => true,
					),
				),
			);

		// 受付日をチェック
		$params = array(
			'name' => $msg->get('const', 'NAME_INQUIRY_SEARCH_RECEPT_DATE'),
			'start' => array(
					'name' => $msg->get('const', 'NAME_INQUIRY_SEARCH_RECEPT_START'),
					'required' => false,
					'field' => 'recept_start_date',
				),
			'end' => array(
					'name' => $msg->get('const', 'NAME_INQUIRY_SEARCH_RECEPT_END'),
					'required' => false,
					'field' => 'recept_end_date',
				),
		);
		$this->checkBetween($params);

		return parent::validates($options);
	}

	/**
	  * 検索条件を取得
	  *
	  * @access public
	 **/
	function getConditions() {
		//$db =& ConnectionManager::getDataSource($this->useDbConfig);

		$conditions = array();
		// 受付日
		if (isset($this->data['InquirySearch']['recept_start_date']) && $this->data['InquirySearch']['recept_start_date']!="") {
			$conditions['to_char(Inquiry.created, \'YYYY-MM-DD\') >='] = date('Y-m-d', strtotime($this->data['InquirySearch']['recept_start_date']));
		}
		if (isset($this->data['InquirySearch']['recept_end_date']) && $this->data['InquirySearch']['recept_end_date']!="") {
			$conditions['to_char(Inquiry.created, \'YYYY-MM-DD\') <='] = date('Y-m-d', strtotime($this->data['InquirySearch']['recept_end_date']));
		}
		// お問い合わせ種別
		if (isset($this->data['InquirySearch']['inquiry_type']) && $this->data['InquirySearch']['inquiry_type']!="") {
			$conditions['Inquiry.inquiry_type'] = $this->data['InquirySearch']['inquiry_type'];
		}
		// 回答ステータス
		if (isset($this->data['InquirySearch']['answer_status']) && $this->data['InquirySearch']['answer_status']!="") {
			$conditions['Inquiry.answer_status'] = $this->data['InquirySearch']['answer_status'];
		}

		$conditions['Inquiry.active'] = 1;

		return $conditions;
	}
}
?>