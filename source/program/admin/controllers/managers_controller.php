<?php
/**
 * 管理者の表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/01/06
 * @author          matsuyama
 * @version         1.00
 */
class ManagersController extends AppController {
	var $name = 'Managers';
    var $uses = array('Admin', 'Group', 'ManagersSearch');
	var $components = array();

	var $paginate = array(
		'Admin' => array(
						'limit' => 20,
						'order' => array(
						'Admin.id' => 'desc'
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
    	$this->paginate['Admin']['limit'] = $this->Messages->get('const', 'MANAGERS_SEARCH_LIMIT');
    	// 権限グループID
    	$auth_group = $this->Messages->getList('list', 'AUTH_GROUP_ID');
    	$this->auth_group_id = $auth_group['SYSTEM'];

    	parent::beforeFilter();
    }

    /**
     * デフォルトのアクション
     *
     * @access    public
     */
    function index() {
       	// 保存している検索パラメータを削除
    	$this->Session->del('admin.managers_search');

    	// 初回一覧表示
    	if ($this->firstView) {
			// paginate用検索条件取得
			$conditions = $this->ManagersSearch->getConditions();
    		$this->Session->write('admin.managers_search.conditions', $conditions);
    	}

    	$this->setAction('search');
    }

    /**
     * 一覧表示
     *
     * @access    public
     */
    function search() {
    	// 管理者種別リスト
		$this->set('admintype_list', $this->Messages->getList('list', 'ADMINTYPE'));
	   	// 管理者権限選択リスト
    	$operation_auth_status_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS');
	   	$this->set('operation_auth_status_list', $operation_auth_status_list);

       	if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('search_btn', $this->params['form'])) { // 検索
	    		$this->ManagersSearch->set($this->data);
    			if ($this->ManagersSearch->validates()) {
					// paginate用検索条件取得
					$conditions = $this->ManagersSearch->getConditions();
	    			$this->Session->write('admin.managers_search.conditions', $conditions);
	    			$this->Session->write('admin.managers_search.data', $this->data);
    			} else {
    				// 入力エラー。保存している検索パラメータを削除
			    	$this->Session->del('admin.managers_search');
    			}
    		}
    	} else {
    		if (in_array($this->Session->read('info.referer'), array('managers_detail','managers_edit'))) { // 詳細、編集からの戻り
    			// 遷移前のページ情報を読出す
    			$this->passedArgs = $this->Session->read('admin.managers_search.params');
    			if (!is_array($this->passedArgs)) {
	    			$this->passedArgs = array();
    			}
    		}
    	}

    	// 検索
    	if ($this->Session->check('admin.managers_search.conditions')) {
	    	$conditions = $this->Session->read('admin.managers_search.conditions');
			$this->data = $this->Session->read('admin.managers_search.data');
			// 検索条件設定
		    $this->paginate['Admin']['conditions'] = $conditions;
		    // 検索結果取得設定
		    $this->paginate['Admin']['fields'] = array(
		    	'Admin.id','Admin.username','Admin.name','Admin.email','Admin.admintype',
		    );
	    	// ページ取得
		    $data = $this->paginate('Admin');
			$this->set(compact('data'));
    	}
    	// ページ情報を保存
    	if (isset($this->params['named']['page'])) {
    		$this->Session->write('admin.managers_search.params', $this->passedArgs);
    	}
    }

    /**
     * 詳細
     *
     * @access    public
     */
    function detail($admin_id) {
       	// グループリスト
    	$group_list = $this->Group->getSelectList();
	   	$this->set('group_list', $group_list);
	   	// 管理者種別リスト
    	$admintype_list = $this->Messages->getList('list', 'ADMINTYPE');
	   	$this->set('admintype_list', $admintype_list);
	   	// 管理者権限選択リスト
    	$operation_auth_status_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS');
	   	$this->set('operation_auth_status_list', $operation_auth_status_list);

		$admin_data = $this->Admin->getData($admin_id);
		if (!empty($admin_data)) {
			$this->set('data', $admin_data);
		} else {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}

		if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('back_btn', $this->params['form'])) { // 一覧に戻る
				$this->redirect('/managers/search/');
    		} elseif (array_key_exists('edit_btn', $this->params['form'])) { // 編集する
    			// 戻り先をセット
    			$this->Session->write($this->name.'.back', $this->Session->read('info.display'));

				$this->redirect('/managers/edit/'.$admin_id);
    		} elseif (array_key_exists('delete_btn', $this->params['form'])) { // 削除する
				$this->redirect('/managers/delete/'.$admin_id);
    		}
    	}
    }

    /**
     * 新規登録
     *
     * @access    public
     */
    function create() {
    	// グループリスト
    	$group_list = $this->Group->getSelectList();
	   	$this->set('group_list', $group_list);
	   	// 管理者種別リスト
    	$admintype_list = $this->Messages->getList('list', 'ADMINTYPE');
	   	$this->set('admintype_list', $admintype_list);
	   	// 管理者権限選択リスト
    	$operation_auth_status_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS');
	   	$this->set('operation_auth_status_list', $operation_auth_status_list);

		if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('confirm_btn', $this->params['form'])) { // 登録確認
    			$this->Admin->set($this->data);
				if ($this->Admin->validates()) {
					$this->Session->write($this->name.'.form', $this->data);
					$this->render('confirm');
				}
    		} elseif (array_key_exists('commit_btn', $this->params['form'])) { // 登録
    			$save_data = $this->Session->read($this->name.'.form');
    			$this->Session->del($this->name.'.form');
    			if (!empty($save_data)) {
    				$save_data = $this->_setSaveField($save_data);
    				$this->Admin->set($save_data);
					if (!$this->Admin->saveData($save_data)) {
						// 保存失敗
						$this->log('管理者新規登録失敗', 'ERROR');
					}
					$this->render('complete');
    			}
    		} elseif (array_key_exists('back_btn', $this->params['form'])) { // 一覧に戻る
				$this->redirect('/managers/');
    		} elseif (array_key_exists('confirm_back_btn', $this->params['form'])) { // 入力に戻る
    			$this->data = $this->Session->read($this->name.'.form');
    		} elseif (array_key_exists('reset_btn', $this->params['form'])) { // リセット
				$this->data = array();
    		}
		}
    }

    /**
     * 編集
     *
     * @access    public
     */
    function edit($admin_id) {
       	if ($this->RequestHandler->isGet() &&
   			in_array($this->Session->read('info.referer'), array('managers_index', 'managers_search'))) {
	    	$this->Session->write($this->name.'.back', $this->Session->read('info.referer'));
		}
    	// 戻り場所
    	if (in_array($this->Session->read($this->name.'.back'), array('managers_detail'))) {
    		$this->set('back', 'detail');
    	} else {
    		$this->set('back', 'search');
    	}

    	// グループリスト
    	$group_list = $this->Group->getSelectList();
	   	$this->set('group_list', $group_list);
	   	// 管理者種別リスト
    	$admintype_list = $this->Messages->getList('list', 'ADMINTYPE');
	   	$this->set('admintype_list', $admintype_list);
	   	// 管理者権限選択リスト
    	$operation_auth_status_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS');
	   	$this->set('operation_auth_status_list', $operation_auth_status_list);

		$admin_data = $this->Admin->getData($admin_id);
		if (!empty($admin_data)) {
			$this->set('data', $admin_data);
		} else {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}

		if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('confirm_btn', $this->params['form'])) { // 編集確認
    			$this->Admin->set($this->data);
				if ($this->Admin->validatesEdit()) {
					$this->Session->write($this->name.'.form', $this->data);
					$this->render('edit_confirm');
				}
    		} elseif (array_key_exists('commit_btn', $this->params['form'])) { // 編集
    			$save_data = $this->Session->read($this->name.'.form');
    			$this->Session->del($this->name.'.form');
    			if (!empty($save_data)) {
    				$save_data = $this->_setSaveField($save_data);
    				$this->Admin->id = $admin_id;
    				$this->Admin->set($save_data);
					if (!$this->Admin->saveData($save_data)) {
						// 保存失敗
						$this->log('管理者編集失敗', 'ERROR');
					}
					$this->render('complete');
    			}
    		} elseif (array_key_exists('back_btn', $this->params['form'])) { // 詳細に戻る
				$this->redirect('/managers/detail/'.$admin_id);
       		} elseif (array_key_exists('confirm_back_btn', $this->params['form'])) { // 入力に戻る
    			$this->data = $this->Session->read($this->name.'.form');
    		} elseif (array_key_exists('reset_btn', $this->params['form'])) { // リセット
    			$this->data = array();
    		} elseif (array_key_exists('delete_btn', $this->params['form'])) { // 削除
	    		$this->Admin->id = $admin_id;
		    	if ($this->Admin->validatesDelete($this->Auth->user())) {
	    			if ($this->Admin->invalidData($admin_id)) {
						$this->redirect('/managers/');
	    			}
		    	}
    		}
		} else {
			$this->data = $this->_setFormField($admin_data);
		}
    }

    /**
     * 削除
     *
     * @access    public
     */
    function delete($admin_id) {
       	// グループリスト
    	$group_list = $this->Group->getSelectList();
	   	$this->set('group_list', $group_list);
	   	// 管理者種別リスト
    	$admintype_list = $this->Messages->getList('list', 'ADMINTYPE');
	   	$this->set('admintype_list', $admintype_list);
	   	// 管理者権限選択リスト
    	$operation_auth_status_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS');
	   	$this->set('operation_auth_status_list', $operation_auth_status_list);

		$admin_data = $this->Admin->getData($admin_id);
		if (!empty($admin_data)) {
			$this->set('data', $admin_data);
		} else {
			// 取得失敗
			$this->redirect('/errors/msg/notfound');
		}

		if ($this->RequestHandler->isPut() || $this->RequestHandler->isPost()) {
    		if (array_key_exists('commit_btn', $this->params['form'])) { // 削除
	    		$save_data = array();
    			$save_data = $this->_setSaveFieldDelete($save_data);
    			$this->Admin->id = $admin_id;
    			$this->Admin->updateInvalidData($save_data);
    			$this->redirect('/managers/search/');
			} elseif (array_key_exists('back_btn', $this->params['form'])) { // 詳細に戻る
				$this->redirect('/managers/detail/'.$admin_id);
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
	   	// 管理者種別IDリスト
    	$admintype_id_list = $this->Messages->getList('list', 'ADMINTYPE_ID');
	   	// 管理者権限選択リスト
    	$operation_auth_status_id_list = $this->Messages->getList('list', 'OPERATION_AUTH_STATUS_ID');

       	$group_list = $this->Group->getAll();

    	$ret = $data;
    	// グループ権限
    	if ($data['Admin']['admintype'] != $admintype_id_list['SYSTEM']) {
	    	foreach ($data['Group'] as $group) {
		    	$ret['Admin']['id:'.$group['id']] = $group['AdminsGroup']['id'];
	    		$ret['Admin']['auth_menu_status:'.$group['id']] = $group['AdminsGroup']['authtype'];
	    	}
	    	// 権限なしにチェック
	    	foreach ($group_list as $group) {
	    		if (!isset($ret['Admin']['auth_menu_status:'.$group['Group']['id']])) {
		    		$ret['Admin']['auth_menu_status:'.$group['Group']['id']] = $operation_auth_status_id_list['AUTHNONE'];
	    		}
	    	}
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
    	// ログインID
    	if (isset($data['Admin']['new_username']) && $data['Admin']['new_username']!="") {
	    	$ret['Admin']['username'] = $data['Admin']['new_username'];
    	}
    	// パスワード
    	if (isset($data['Admin']['new_password']) && $data['Admin']['new_password']!="") {
	     	$ret['Admin']['password'] = $this->password($data['Admin']['new_password']);
    	}

    	return $ret;
    }

    /**
     * 保存フィールドに合わせてデータを加工（削除）
     *
     * @access   protected
     * @param    array    $data    入力データ
     * @return   array
     */
    function _setSaveFieldDelete(&$data) {
    	$ret = $data;

		$user = $this->Auth->user();

       	// 作成者
       	$ret['Admin']['modified_id'] = $user['Admin']['id'];
		// 有効／無効
		$ret['Admin']['active'] = 0;

    	return $ret;
    }
}
?>