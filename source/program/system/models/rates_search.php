<?php
/**
 * お知らせ情報検索モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/17
 * @version         1.00
 */
class RatesSearch extends AppModel
{
	var $name = 'RatesSearch';
	var $useTable = false;


	/**
	  * 検索条件を取得
	  *
	  * @access public
	 **/
	function getConditions() {
		$conditions = array();

		// 公開期間中
		$tmp_condition['OR'] = array();
		$tmp_condition['OR'][] = array('AND' => array(
			array('OR' => array(
					array('Rates.open_start_date <= \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_start_date' => null ),
				)),
			array('OR' => array(
					array('Rates.open_end_date > \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_end_date' => null ),
				)),
		));

		$conditions[] = $tmp_condition;


		return $conditions;
	}

	/**
	  * TOP画面用条件を取得
	  *
	  * @access public
	 **/
	function getConditionsTop() {
		$conditions = array();

		// 公開期間中
		$tmp_condition['OR'] = array();
		$tmp_condition['OR'][] = array('AND' => array(
			array('OR' => array(
					array('Rates.open_start_date <= \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_start_date' => null ),
				)),
			array('OR' => array(
					array('Rates.open_end_date > \'' . date('Y-m-d H:00:00') .'\''),
					array('Rates.open_end_date' => null ),
				)),
		));

		$conditions[] = $tmp_condition;

		return $conditions;
	}
}
?>