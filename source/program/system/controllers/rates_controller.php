<?php
/**
 * 相場情報の表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/17
 * @version         1.00
 */
class RatesController extends AppController {

	var $name = 'Rates';
	var $uses = array('Rates', 'RatesSearch');
	var $components = array('RequestHandler');

	var $paginate = array(
		'Rates' => array(
						'limit' => 10,
						'order' => array(
						'Rates.open_start_date'  => 'desc',
						'Rates.open_end_date'  => 'desc',
						'Rates.id'  => 'desc',
						),
					),
				);

	// 初回一覧表示
	var $firstView = true;

    /**
     * アクション前処理
     *
     * @access    public
     */
    function beforeFilter() {
		$this->paginate['Rates']['limit'] = $this->Messages->get('const', 'RATE_SEARCH_LIMIT');
    	parent::beforeFilter();
    }

	/**
	 * 初期表示のアクション
	 *
	 * @access    public
	 */
	function index() {

		// 初回一覧表示
		if ($this->firstView) {
			// paginate用検索条件取得
			$conditions = $this->RatesSearch->getConditions();
		}

		$this->setAction('search');
	}

	/**
	 * 一覧画面用
	 *
	 */
	function search() {

		$this->paginate['Rates']['limit'] = $this->Messages->get('const', 'RATE_SEARCH_LIMIT');

		$conditions = $this->RatesSearch->getConditions();
		// 検索条件設定
		$this->paginate['Rates']['conditions'] = $conditions;
		// 検索結果取得設定
		$this->paginate['Rates']['fields'] = array(
				'Rates.id',
				'Rates.comment',
				'Rates.open_start_date',
				'Rates.open_end_date',
		);
		// ページ取得
		$data = $this->paginate('Rates');
		$this->set(compact('data'));
	}

	/**
	 * トップ画面用一覧
	 *
	 */
	function top() {
		//
		$this->paginate['Rates']['limit'] = $this->Messages->get('const', 'RATE_TOP_LIMIT');

		// 検索
		$conditions = $this->RatesSearch->getConditionsTop();
		// 検索条件設定
		$this->paginate['Rates']['conditions'] = $conditions;
		// 検索結果取得設定
		$this->paginate['Rates']['fields'] = array(
				'Rates.id',
				'Rates.comment',
				'Rates.open_start_date',
				'Rates.open_end_date',
		);

		// ページ取得
		$data = $this->paginate('Rates');
		$this->set(compact('data'));
		$this->layout = 'parts';
	}
}
?>