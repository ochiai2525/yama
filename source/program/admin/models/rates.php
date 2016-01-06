<?php
/**
 * 相場情報モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/16
 * @version         1.00
 */
class Rates extends AppModel
{
	var $name = 'Rates';

	/**
	  * 有効な情報を取得
	  *
	  * @access public
	 **/
	function getData($id) {
		if (!is_numeric($id)) {
			return false;
		}

		$params = array();
		$params['conditions'] = array('Rates.id'=> $id,);
		return $this->find('first', $params);
	}

    /**
     * 共通部分の登録チェック
     *
     * @access    public
     */
	function validates($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			// 一言コメント
			'comment' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'rates_comment_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_RATE_COMMENT')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'rates_comment_length'),
					),
				),
			);

		// 有効期間をチェック
		$params = array(
			'name' => $msg->get('const', 'NAME_RATE_INPUT_OPEN_DATE'),
			'start' => array(
					'name' => $msg->get('const', 'NAME_RATE_INPUT_OPEN_START_DATE'),
					'required' => true,
					'field1' => 'open_start_date_ymd',
					'field2' => 'open_start_date_h',
				),
			'end' => array(
					'name' => $msg->get('const', 'NAME_RATE_INPUT_OPEN_END_DATE'),
					'required' => false,
					'field1' => 'open_end_date_ymd',
					'field2' => 'open_end_date_h',
				),
		);
		$this->checkBetweenYmdh($params);

		return parent::validates($options);
	}

	/**
	  * 期間チェック(Y/m/d h)
	  *
	  * @access public
	 **/
	function checkBetweenYmdh($params) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$fields  = array($params['start'], $params['end']);
		$cmpdate = array();
		foreach ($fields as $param) {
			$field1 = $param['field1'];
			$field2 = $param['field2'];
			if ($this->data[$this->name][$field1]=="" || $this->data[$this->name][$field2]=="") {
				if ($param['required']) {
					$this->invalidate($field1, sprintf($msg->get('error', 'commons_search_date_empty'), $params['name'], $param['name']));
				} else if($this->data[$this->name][$field1] == "" XOR $this->data[$this->name][$field2] == "") {
					$this->invalidate($field1, sprintf($msg->get('error', 'commons_search_date_empty'), $params['name'], $param['name']));
				}
			} else {
				if (preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $this->data[$this->name][$field1], $matches1)
					&& preg_match('/^[0-9]{2}:[0-9]{2}$/', $this->data[$this->name][$field2], $matches2) ) {
					list($yy, $mm, $dd) = explode('/', $this->data[$this->name][$field1]);
					list($h, $i) = explode(':', $this->data[$this->name][$field2]);
					// $h = $this->data[$this->name][$field2];
					if (!checkdate($mm, $dd, $yy)) {
						$this->invalidate($field1, sprintf($msg->get('error', 'commons_search_date_format'), $params['name'], $param['name']));
					} else {
						$cmpdate[$field1] = date('Y-m-d H:i', mktime($h, $i, 0, $mm, $dd, $yy));
					}
				} else {
					$this->invalidate($field1, sprintf($msg->get('error', 'commons_search_date_format'), $params['name'], $param['name']));
				}
			}
		}
		if (isset($cmpdate[$params['start']['field1']]) && isset($cmpdate[$params['end']['field1']])) {
			if ($cmpdate[$params['start']['field1']]>$cmpdate[$params['end']['field1']]) {
				$this->invalidate($params['start']['field1'], sprintf($msg->get('error', 'commons_search_date_compare'), $params['name'], $params['start']['name'], $params['end']['name']));
			}
		}
	}

}
?>