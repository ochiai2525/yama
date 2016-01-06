<?php
/**
 * お問い合わせ情報モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/18
 * @version         1.00
 */
class Inquiry extends AppModel
{
	var $name = 'Inquiry';

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
   		$params['conditions'] = array('Inquiry.id'=> $id, 'Inquiry.active'=> 1,);
		return $this->find('first', $params);
	}

	/**
	 * 有効な一覧を取得
	 *
	 * @access	public
	 */
	function getAll($options=array()) {
		$params = array();
 		$params['conditions'] = array('Inquiry.active'=> 1);
 		$params['order'] = array('Inquiry.created'=> 'desc');
 		$params = Set::merge($params, $options);
		$list = $this->find('all', $params);
		return $list;
	}

	/**
	 * 指定IDのデータを論理削除
	 *
	 * @access	public
	 */
	function activeOff($id) {
		if (empty($id)) {
			return false;
		}
		$save_data['id']     = $id;
		$save_data['active'] = 0;
		return $this->save($save_data, false);
	}
}
?>