<?php
/**
 * パスワード変更
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class ChangePasswordController extends AppController {
	var $name = 'ChangePassword';
    var $uses = array();
	var $components = array('RequestHandler', 'Messages');

    /**
     * アクション前処理
     *
     * @access    public
     */
    function beforeFilter() {
    	// 権限グループID
    	$auth_group = $this->Messages->getList('list', 'AUTH_GROUP_ID');
    	$this->auth_group_id = $auth_group['TOP'];

    	parent::beforeFilter();
    }

    /**
     * デフォルトのアクション
     *
     * @access    public
     */
    function index() {
   		if ($this->RequestHandler->isPost()) {
    		if (array_key_exists('commit_btn', $this->params['form'])) { // 変更
    			// チェック前に現在ログイン中のIDをセットしておく
    			$user = $this->Auth->user();
    			$this->Admin->id = $user['Admin']['id'];
    			$this->Admin->set($this->data);
				if ($this->Admin->validatesChangePassword()) {
    				$save_data = $this->_setSaveField($this->data);
					if (!$this->Admin->saveChangePassword($save_data)) {
						// 保存失敗
						$this->log('パスワード変更失敗', 'ERROR');
					} else {
						// ログイン情報の更新
						$data['Admin']['username'] = $user['Admin']['username'];
						$data['Admin']['password'] = $this->data['Admin']['new_password'];
						$this->Auth->login($data);
						$this->data = array();
						$this->Session->setFlash("パスワード変更が完了しました。");
					}
				}
    		}
		}

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
    	// パスワード
    	if (isset($data['Admin']['new_password']) && $data['Admin']['new_password']!="") {
	     	$ret['Admin']['password'] = $this->password($data['Admin']['new_password']);
    	}

    	return $ret;
    }
}
?>