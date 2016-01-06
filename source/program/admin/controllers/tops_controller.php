<?php
/**
 * ログインの表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class TopsController extends AppController {
	var $name = 'Tops';
    var $uses = array();
	var $components = array();
	var $layout = 'login_logout';

    function beforeFilter() {
    	parent::beforeFilter();

    	// 自動認証の前に値チェック
    	if ($this->RequestHandler->isPost() && $this->action  == 'login') {
	    	$this->Admin->set($this->data);
			$this->Admin->validateLogin($this->data);
		}
		$this->Auth->allow('login','logout');
    }

    /**
     * デフォルトのアクション
     *
     * @access    public
     */
    function index() {
		$this->redirect('/tops/login');
    }

    /**
     * ログイン
     *
     * @access    public
     */
    function login() {
    	if ($this->RequestHandler->isGet()) {
    		$this->Auth->logout();
    		$this->Session->del('admin.menu_list');
    	} elseif ($this->RequestHandler->isPost()) {
	    	$this->set('err_msg', $this->Session->read('Message.auth.message'));
			$user = $this->Auth->user();
	    	if (!empty($user)) {
				// 管理者メニューの取得
			   	$menu_list = array();
				if (isset($user['Admin']['id'])) {
					$auth_group_list = $this->Admin->getAuthGroupList($user['Admin']['id']);
					$this->Session->write('admin.auth_group_list', $auth_group_list);
				}
				$this->redirect('/menus/');
	    	}
    	}
    }

    /**
     * ログアウト
     *
     * @access    public
     */
    function logout() {
	    $this->Auth->logout();
	    $this->redirect('/tops/login');
    }
}
?>