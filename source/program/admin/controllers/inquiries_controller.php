<?php
/**
 * お問い合わせ情報の表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/17
 * @version         1.00
 */
class InquiriesController extends AppController {

	var $name = 'Inquiries';
	var $uses = array('Inquiry', 'InquirySearch');
	var $components = array();
	var $helpers = array('Csv');

	var $paginate = array(
		'Inquiry' => array(
						'limit' => 10,
						'order' => array(
						'Inquiry.id'  => 'desc',
						),
					),
			    );

	// 初回一覧表示
	var $firstView = true;

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
    	$this->paginate['Inquiry']['limit'] = $this->Messages->get('const', 'INQUIRY_SEARCH_LIMIT');
    	// 権限グループID
    	$auth_group = $this->Messages->getList('list', 'AUTH_GROUP_ID');
    	$this->auth_group_id = $auth_group['INQUIRY'];

    	parent::beforeFilter();
    }

    /**
     * デフォルトのアクション
     *
     * @access    public
     */
    function index() {
       	// 保存している検索パラメータを削除
    	$this->Session->del('admin.inquiry_search');

    	// 初回一覧表示
    	if ($this->firstView) {
			// paginate用検索条件取得
			$conditions = $this->InquirySearch->getConditions();
			$this->Session->write('admin.inquiry_search.conditions', $conditions);
    	}

    	$this->setAction('search');
    }

	/**
	 * 一覧表示
	 *
	 * @access    public
	 */
	function search() {
		// 回答ステータス
		$this->set('inquiry_answer_status_list', $this->Messages->getList('list', 'INQUIRY_ANSWER_STATUS'));

	   	if ($this->RequestHandler->isPost()) {
			if (array_key_exists('search_btn', $this->params['form'])) { // 検索
				$this->InquirySearch->set($this->data);
				if ($this->InquirySearch->validates()) {
					// paginate用検索条件取得
					$conditions = $this->InquirySearch->getConditions();
					$this->Session->write('admin.inquiry_search.conditions', $conditions);
					$this->Session->write('admin.inquiry_search.data', $this->data);
				} else {
					// 入力エラー。保存している検索パラメータを削除
					$this->Session->del('admin.inquiry_search');
				}
			}
		} else {
			if (in_array($this->Session->read('info.referer'), array('inquiries_detail','inquiries_edit'))) { // 詳細、編集からの戻り
				// 遷移前のページ情報を読出す
				$this->passedArgs = $this->Session->read('admin.inquiry_search.params');
				if (!is_array($this->passedArgs)) {
					$this->passedArgs = array();
				}
			}
		}

		// 検索
		if ($this->Session->check('admin.inquiry_search.conditions')) {
			$conditions = $this->Session->read('admin.inquiry_search.conditions');
			$this->data = $this->Session->read('admin.inquiry_search.data');
			// 検索条件設定
			$this->paginate['Inquiry']['conditions'] = $conditions;
			// 検索結果取得設定
			$this->paginate['Inquiry']['fields'] = array(
				'Inquiry.id',
				'Inquiry.product_name',
				'Inquiry.company_name',
				'Inquiry.last_name',
				'Inquiry.first_name',
				'Inquiry.last_kana',
				'Inquiry.first_kana',
				'Inquiry.email',
				'Inquiry.add',
				'Inquiry.tel',
				'Inquiry.fax',
				'Inquiry.body',
				'Inquiry.answer_status',
				'Inquiry.note',
				'Inquiry.active',
				'Inquiry.created',
				'Inquiry.modified',
			);
			// ページ取得
			$data = $this->paginate('Inquiry');
			$this->set(compact('data'));
		}
		// ページ情報を保存
		if (isset($this->params['named']['page'])) {
			$this->Session->write('admin.inquiry_search.params', $this->passedArgs);
		}
	}

	/**
	 * 詳細
	 *
	 * @access    public
	 */
	function detail($inquiry_id) {
		// 回答ステータス
		$this->set('inquiry_answer_status_list', $this->Messages->getList('list', 'INQUIRY_ANSWER_STATUS'));

		// お問い合わせ情報
		$inquiry_data = $this->Inquiry->getData($inquiry_id);
		if (empty($inquiry_data)) {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}
		$this->set('data', $inquiry_data);

		if ($this->RequestHandler->isPut() || $this->RequestHandler->isPost()) {
			if (array_key_exists('back_btn', $this->params['form'])) { // 一覧に戻る
				$this->redirect('/inquiries/search/');
    		} elseif (array_key_exists('edit_btn', $this->params['form'])) { // 編集する
    			// 戻り先をセット
    			$this->Session->write($this->name.'.back', $this->Session->read('info.display'));

				$this->redirect('/inquiries/edit/'.$inquiry_id);
			} elseif (array_key_exists('delete_btn', $this->params['form'])) { // 削除する
				$this->redirect('/inquiries/delete/'.$inquiry_id);
			} elseif (array_key_exists('save_btn', $this->params['form'])) { // 入力内容を保存
				if (!empty($this->data)) {
					$this->Inquiry->id = $inquiry_id;
					if (!$this->Inquiry->save($this->data)) {
						$this->log('編集失敗', 'ERROR');
					} else {
						$this->set('message', $this->Messages->get('info', 'save_complete'));
					}
				}
			}
		} else {
			// データをフォームにセット
			$this->data = $this->_setFormField($inquiry_data);
		}
	}

	/**
	 * 削除
	 *
	 * @access    public
	 */
	function delete($inquiry_id) {
		// 回答ステータス
		$this->set('inquiry_answer_status_list', $this->Messages->getList('list', 'INQUIRY_ANSWER_STATUS'));

		// お問い合わせ情報
		$inquiry_data = $this->Inquiry->getData($inquiry_id);
		if (empty($inquiry_data)) {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
	   	}
		$this->set('data', $inquiry_data);

		$this->set('inquiry_id', $inquiry_id);
		if ($this->RequestHandler->isPut() || $this->RequestHandler->isPost()) {
			if (array_key_exists('commit_btn', $this->params['form'])) { // 削除
				$save_data = array();
				// 論理削除
				$this->Inquiry->activeOff($inquiry_id);
				$this->redirect('/inquiries/search/');
			} elseif (array_key_exists('back_btn', $this->params['form'])) { // 詳細に戻る
				$this->redirect('/inquiries/detail/'.$inquiry_id);
			}
		}
	}

	/**
	 * CSV出力
	 *
	 * @access    public
	 */
	function csv() {
		// お問い合わせ情報
		$conditions = $this->Session->read('admin.inquiry_search.conditions');
		$options['conditions'] = $conditions;
		$data = $this->Inquiry->getAll($options);
		// 出力項目名一覧
		$column_list = $this->Messages->getList('csv', 'INQUIRY_COLUMNS');
		// 出力フィールド一覧
		$field_list = $this->Messages->getList('csv', 'INQUIRY');
		// お問い合わせタイプ一覧
		$this->set('inquiry_type_list', $this->Messages->getList('list', 'INQUIRY_TYPE'));
		// 回答ステータス
		$this->set('inquiry_answer_status_list', $this->Messages->getList('list', 'INQUIRY_ANSWER_STATUS'));
		// クラス
		$this->set('inquiry_rank_list', $this->Messages->getList('list', 'INQUIRY_RANK'));
		$this->set('data', $data);
		$this->set('column_list', $column_list);
		$this->set('field_list', $field_list);
		$this->set('csv_file', $this->name.'_'.date('YmdHis').'.csv');

		$this->layout = null;
		Configure::write('debug', 0);
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
		return $ret;
	}

}
?>