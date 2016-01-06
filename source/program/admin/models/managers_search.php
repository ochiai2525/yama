<?php
/**
 * 管理者検索モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @version         1.00
 */
class ManagersSearch extends AppModel
{
	var $name = 'ManagersSearch';
	var $useTable = false;

	function validates($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			'username' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_SEARCH_USERNAME')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_search_title_length'),
					),
				),
			);

		return parent::validates($options);
	}

	/**
	  * 検索条件を取得
	  *
	  * @access public
	 **/
	function getConditions() {
		$conditions = array();

		// タイトル
		if (isset($this->data['ManagersSearch']['title']) && $this->data['ManagersSearch']['title']!="") {
			$conditions['Admin.title LIKE ? ESCAPE ?'] = array("%".$this->escapeLike($this->data['ManagersSearch']['title'])."%", '#');
		}
		$conditions['Admin.active'] = 1;

		return $conditions;
	}
}
?>