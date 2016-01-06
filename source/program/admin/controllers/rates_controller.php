<?php
/**
 * 相場情報の表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/16
 * @version         1.00
 */
class RatesController extends AppController {

	var $name = 'Rates';
	var $uses = array('Rates', 'RatesSearch');
	var $components = array();

	// 初回一覧表示
	var $firstView = true;

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

    /**
     * 生成時処理
     *
     * @access    public
     */
   	function constructClasses() {
		parent::constructClasses();

		// アクション引数型チェック
		$this->CheckArgs->arg_types = array(
							'detail' => array(array('type'=>'digit')),
							'edit' => array(array('type'=>'digit')),
							'delete' => array(array('type'=>'digit')));
   	}

    /**
     * アクション前処理
     *
     * @access    public
     */
    function beforeFilter() {
    	// LIMIT設定
    	$this->paginate['Rates']['limit'] = $this->Messages->get('const', 'RATE_SEARCH_LIMIT');
    	// 権限グループID
    	$auth_group = $this->Messages->getList('list', 'AUTH_GROUP_ID');
    	$this->auth_group_id = $auth_group['RATE'];

    	// 時間
    	$time_list = array();
    	for ($i=0; $i<24; $i++) {
    		$time_list[sprintf("%02d:00",$i)] = $i;
    	}
    	$this->set('time_list', $time_list);

    	parent::beforeFilter();
    }

    /**
     * デフォルトのアクション
     *
     * @access    public
     */
    function index() {
       	// 保存している検索パラメータを削除
    	$this->Session->del('admin.rate_search');

    	// 初回一覧表示
    	if ($this->firstView) {
			// paginate用検索条件取得
			$conditions = $this->RatesSearch->getConditions();
			$this->Session->write('admin.rate_search.conditions', $conditions);
    	}

    	$this->setAction('search');
    }

	/**
	 * 一覧表示
	 *
	 * @access    public
	 */
	function search() {

		$this->Session->del($this->name.'.form');

	   	if ($this->RequestHandler->isPost()) {
			if (array_key_exists('search_btn', $this->params['form'])) { // 検索
				$this->RatesSearch->set($this->data);
				if ($this->RatesSearch->validates()) {
					// paginate用検索条件取得
					$conditions = $this->RatesSearch->getConditions();
					$this->Session->write('admin.rate_search.conditions', $conditions);
					$this->Session->write('admin.rate_search.data', $this->data);
				} else {
					// 入力エラー。保存している検索パラメータを削除
					$this->Session->del('admin.rate_search');
				}
			}
		} else {
			if (in_array($this->Session->read('info.referer'), array('rates_detail','rates_edit'))) { // 詳細、編集からの戻り
				// 遷移前のページ情報を読出す
				$this->passedArgs = $this->Session->read('admin.rate_search.params');
				if (!is_array($this->passedArgs)) {
					$this->passedArgs = array();
				}
			}
		}

		// 検索
		if ($this->Session->check('admin.rate_search.conditions')) {
			$conditions = $this->Session->read('admin.rate_search.conditions');
			$this->data = $this->Session->read('admin.rate_search.data');
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
		// ページ情報を保存
		if (isset($this->params['named']['page'])) {
			$this->Session->write('admin.rate_search.params', $this->passedArgs);
		}

	}

    /**
     * 詳細
     *
     * @access    public
     */
    function detail($rate_id) {
		$this->Session->del($this->name.'.form');
		$rate_data = $this->Rates->getData($rate_id);
		if (!empty($rate_data)) {
			$rate_data = $this->_setFormField($rate_data);
			$this->set('data', $rate_data);
		} else {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}
		if ($this->RequestHandler->isPost()) {
			if (array_key_exists('back_btn', $this->params['form'])) { // 一覧に戻る
				$this->redirect('/rates/search/');
			} elseif (array_key_exists('edit_btn', $this->params['form'])) { // 編集する
				// 戻り先をセット
				$this->Session->write($this->name.'.back', $this->Session->read('info.display'));
				$this->redirect('/rates/edit/'.$rate_id);
			} elseif (array_key_exists('delete_btn', $this->params['form'])) { // 削除する
				$this->redirect('/rates/delete/'.$rate_id);
			}
		}
	}

    /**
     * 新規登録
     *
     * @access    public
     */
    function create() {
		$data = array();
		$session_data = $this->Session->read($this->name.'.form');
		if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('confirm_btn', $this->params['form'])) { // 登録確認
    			$this->Rates->set($this->data);
				if ($this->Rates->validates()) {
					$data = array_merge_recursive($data, $this->data);
					$this->Session->write($this->name.'.form', $data);
					$this->set('data', $data);
					$this->render('confirm');
				}
    		} elseif (array_key_exists('commit_btn', $this->params['form'])) { // 登録
    			$save_data = $this->Session->read($this->name.'.form');
    			$this->Session->del($this->name.'.form');
    			if (!empty($save_data)) {
    				$save_data = $this->_setSaveField($save_data);
					$this->Rates->create();
    				$this->Rates->set($save_data);
					if (!$this->Rates->save($save_data)) {
						// 保存失敗
						$this->log('新規登録失敗', 'ERROR');
					}
					$this->render('complete');
    			}
    		} elseif (array_key_exists('back_btn', $this->params['form'])) { // 一覧に戻る
				$this->redirect('/rates/');
    		} elseif (array_key_exists('confirm_back_btn', $this->params['form'])) { // 入力に戻る
    			$this->data = $this->Session->read($this->name.'.form');
    		} elseif (array_key_exists('reset_btn', $this->params['form'])) { // リセット
				$this->data = array();
    		} elseif (array_key_exists('create_btn', $this->params['form'])) { // リセット
				$this->Session->del($this->name.'.form');
				$data = array();
    		}
		} else {
			$this->Session->del($this->name.'.form');
			$data = array();
		}
		$this->set('data', $data);
    }

    /**
     * 編集
     *
     * @access    public
     */
    function edit($rate_id) {
		if ($this->RequestHandler->isGet() &&
		in_array($this->Session->read('info.referer'), array('rates_index', 'rates_search'))) {
			$this->Session->write($this->name.'.back', $this->Session->read('info.referer'));
		}
		// 戻り場所
		if (in_array($this->Session->read($this->name.'.back'), array('rates_detail'))) {
			$this->set('back', 'detail');
		} else {
			$this->set('back', 'search');
		}

		$data = array();
		$rate_data = $this->Rates->getData($rate_id);
		if (!empty($rate_data)) {
			$this->set('data', $rate_data);
		} else {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}

		if ($this->RequestHandler->isPost()) {
			if (array_key_exists('confirm_btn', $this->params['form'])) { // 編集確認
				$this->Rates->set($this->data);
				if ($this->Rates->validates()) {
					$data = array_merge_recursive($data, $this->data);
					$this->Session->write($this->name.'.form', $data);
					$data['Rates']['id'] = $rate_data['Rates']['id'];
					$this->set('data', $data);
					$this->render('edit_confirm');
				}
			} elseif (array_key_exists('commit_btn', $this->params['form'])) { // 編集
				$save_data = $this->Session->read($this->name.'.form');
				$this->Session->del($this->name.'.form');
				if (!empty($save_data)) {
					$save_data = $this->_setSaveField($save_data);
					$this->Rates->id = $rate_id;
					$this->Rates->set($save_data);
					if (!$this->Rates->save($save_data)) {
						// 保存失敗
						$this->log('編集失敗', 'ERROR');
					}
					$this->render('complete');
				}
			} elseif (array_key_exists('back_btn', $this->params['form'])) { // 詳細に戻る
				$this->redirect('/rates/detail/'.$rate_id);
			} elseif (array_key_exists('confirm_back_btn', $this->params['form'])) { // 入力に戻る
				$this->data = $this->Session->read($this->name.'.form');
			} elseif (array_key_exists('reset_btn', $this->params['form'])) { // リセット
				$this->data = array();
			}
		} else {
			$this->data = $this->_setFormField($rate_data);
			$this->Session->del($this->name.'.form');
			if (isset($rate_data['Rates']['upload_pdf'])) {
				$this->Session->write($this->name.'.form', $rate_data);
			}
		}
	}

	/**
	 * 削除
	 *
	 * @access    public
	 */
	function delete($rate_id) {
		// お知らせ情報
		$rate_data = $this->Rates->getData($rate_id);
		if (empty($rate_data)) {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}
		$rate_data = $this->_setFormField($rate_data);
		$this->set('data', $rate_data);

		$this->set('rate_id', $rate_id);
		if ($this->RequestHandler->isPut() || $this->RequestHandler->isPost()) {
			if (array_key_exists('commit_btn', $this->params['form'])) { // 削除
				$save_data = array();
				$this->Rates->del($rate_id);
				$this->redirect('/rates/search/');
			} elseif (array_key_exists('back_btn', $this->params['form'])) { // 詳細に戻る
				$this->redirect('/rates/detail/'.$rate_id);
			}
		}
	}

    /**
     * フォームフィールドに合わせてデータを加工
     *
     * @access   protected
     * @param    array    $data    入力データ
     * @return   array
     */
    function _setFormField(&$data) {
    	$ret = $data;

		// 公開期間（開始）
    	if (isset($data['Rates']['open_start_date']) && $data['Rates']['open_start_date'] != "") {
		    $set_date = strtotime($data['Rates']['open_start_date']);
	    	$ret['Rates']['open_start_date_ymd'] = sprintf('%04d/%02d/%02d',
		    	date('Y', $set_date), date('m', $set_date), date('d', $set_date)
		    	);
	    	$ret['Rates']['open_start_date_h'] = sprintf('%02d:%02d',
		    	date('H', $set_date), date('i', $set_date));
    	}
		// 公開期間（終了）
    	if (isset($data['Rates']['open_end_date']) && $data['Rates']['open_end_date'] != "") {
		    $set_date = strtotime($data['Rates']['open_end_date']);
	    	$ret['Rates']['open_end_date_ymd'] = sprintf('%04d/%02d/%02d',
		    	date('Y', $set_date), date('m', $set_date), date('d', $set_date)
		    	);
	    	$ret['Rates']['open_end_date_h'] = sprintf('%02d:%02d',
		    	date('H', $set_date), date('i', $set_date));
		}
		return $ret;
	}

    /**
     * 保存フィールドに合わせてデータを加工
     *
     * @access   protected
     * @param    array    $data    入力データ
     * @return   array
     */
    function _setSaveField(&$data) {
		$ret = $data;
		// 公開期間（開始）
		if (isset($data['Rates']['open_start_date_ymd']) && $data['Rates']['open_start_date_ymd']!=""
			&& isset($data['Rates']['open_start_date_h']) && $data['Rates']['open_start_date_h']!="") {
			$ret['Rates']['open_start_date'] = sprintf('%s %s',
									$data['Rates']['open_start_date_ymd'],
									$data['Rates']['open_start_date_h']);
		} else {
			$ret['Rates']['open_start_date'] = null;
		}

		// 公開期間（終了）
		if (isset($data['Rates']['open_end_date_ymd']) && $data['Rates']['open_end_date_ymd']!=""
			 && isset($data['Rates']['open_end_date_h']) && $data['Rates']['open_end_date_h']!="" ) {
			$ret['Rates']['open_end_date'] = sprintf('%s %s',
									$data['Rates']['open_end_date_ymd'],
									$data['Rates']['open_end_date_h']);
		} else {
		 	$ret['Rates']['open_end_date'] = null;
		}
		return $ret;
    }
}
?>