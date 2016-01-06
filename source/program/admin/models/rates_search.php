<?php
/**
 * 相場情報検索モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/16
 * @version         1.00
 */
class RatesSearch extends AppModel
{
	var $name = 'RatesSearch';
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

		);

		// 更新日をチェック
		$params = array(
			'name' => $msg->get('const', 'NAME_RATE_SEARCH_RECEPT_DATE'),
			'start' => array(
					'name' => $msg->get('const', 'NAME_RATE_SEARCH_RECEPT_START'),
					'required' => false,
					'field' => 'recept_start_date',
				),
			'end' => array(
					'name' => $msg->get('const', 'NAME_RATE_SEARCH_RECEPT_END'),
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
		$db =& ConnectionManager::getDataSource($this->useDbConfig);

		$conditions = array();

		// 一言コメント
		if (isset($this->data['RatesSearch']['comment']) && $this->data['RatesSearch']['comment'] != "") {
			$conditions[] = array('Rates.comment LIKE ' . $db->value('%' . $this->escapeLike($this->data['RatesSearch']['comment']) . '%'));
		}
		// 公開期間(開始)
		if (isset($this->data['RatesSearch']['recept_start_date']) && $this->data['RatesSearch']['recept_start_date']!="") {
			$conditions[]['to_char(Rates.open_start_date, \'YYYY-MM-DD\') >='] = date('Y-m-d', strtotime($this->data['RatesSearch']['recept_start_date']));
		}
		if (isset($this->data['RatesSearch']['recept_end_date']) && $this->data['RatesSearch']['recept_end_date']!="") {
			$conditions[]['to_char(Rates.open_start_date, \'YYYY-MM-DD\') <='] = date('Y-m-d', strtotime($this->data['RatesSearch']['recept_end_date']));
		}

		return $conditions;
	}

}
?>