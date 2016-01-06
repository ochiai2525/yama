<?php
/**
 * お知らせ情報モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/17
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
		$params['conditions'] = array('AND' => array(
			array('Rates.id'=> $id),
			array('OR' => array(
					array('Rates.open_start_date <= \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_start_date' => null ),
				)),
			array('OR' => array(
					array('Rates.open_end_date > \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_end_date' => null ),
				)),
		));


		return $this->find('first', $params);
	}

}
?>