<?php
/**
 * 共通コントローラ
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class AppController extends Controller {
    var $uses = array('Admin');
    var $components = array('Messages', 'CheckArgs', 'Auth', 'RequestHandler');
    var $helpers = array('Form', 'Html', 'Javascript', 'Msg', 'Output');
    // 権限グループID
    var $auth_group_id = null;

	// SSLリダイレクト設定
	var $ssl_flag = false;
	var $ssl_actions = array();

    /**
     * 生成時処理
     *
     * @access    public
     */
   	function constructClasses() {
		parent::constructClasses();

		// 文字コード設定
		mb_language('ja');
		mb_internal_encoding(Configure::read('App.encoding'));
		mb_regex_encoding(Configure::read('App.encoding'));
		// 引数チェック設定
		$this->CheckArgs->autoRedirect = true;
		$this->CheckArgs->redirectUrl = '/errors/msg/input/';

   		// SSLリダイレクト設定
		$ssl_redirect = $this->Messages->get('const', 'SSL_REDIRECT');
		if ($ssl_redirect != '') {
			$this->ssl_flag = ($ssl_redirect==1) ? true : false;
		}
   	}

    /**
     * アクション前処理
     *
     * @access    public
     */
	function beforeFilter() {
		// ログイン認証設定
		$this->Auth->loginAction = '/tops/login';
		//$this->Auth->loginRedirect = '/menus/index';
		$this->Auth->autoRedirect = false;
		$this->Auth->userModel = 'Admin';
		$this->Auth->loginError = $this->Messages->get('error', 'login_login');
		$this->Auth->authError = $this->Messages->get('error', 'login_auth');
		$this->Auth->authorize = "controller";
		$this->Auth->authenticate = &$this;
		$this->Auth->userScope = array('Admin.active' => 1 );

		// ログイン情報とメニューをセット
		$user = $this->Auth->user();
		$this->set('user', $user);
		if ($this->name != 'tops') {
			$auth_group_list = $this->Session->read('admin.auth_group_list');
			$this->set('auth_group_list', $this->Session->read('admin.auth_group_list'));
			$this->set('auth_group_id', $this->auth_group_id);

			if( !is_null($this->auth_group_id) && $this->auth_group_id != '-1' ) {
				$redirect_flag = true;
				if( is_array($auth_group_list) ) {
					foreach($auth_group_list as $group_data) {
						if($group_data['Group']['id'] == $this->auth_group_id) {
							$redirect_flag = false;
							break;
						}
					}
				}

				// 権限エラー時はリダイレクト処理
				if( $redirect_flag ) {
					$this->redirect('/tops/login');
				}
			}
		}

		// デフォルトタイトル設定
        $this->_setTitleId(Inflector::underscore($this->name)."_".$this->action);

        // 遷移情報を記録
        if ($this->Session->valid('info.display')) {
	        $this->Session->write('info.referer', $this->Session->read('info.display'));
        }
        $this->Session->write('info.display', Inflector::underscore($this->name)."_".$this->action);

		if (!empty($this->data)) {
			// 空白を取り除く
			$this->data = $this->_trim($this->data);
        }
	}

    /**
     * アクション後処理
     *
     * @access    public
     */
	function afterFilter() {
	}

    /**
     * パスワード暗号化カスタム処理
     *
     * $this->Auth->authenticate = $this;
     * このメソッドが有効
     *
     * @access    public
     */
	function hashPasswords($data) {
		if (is_array($data) && isset($data[$this->Auth->userModel])) {
			if (isset($data[$this->Auth->userModel][$this->Auth->fields['username']]) && isset($data[$this->Auth->userModel][$this->Auth->fields['password']])) {
				$data[$this->Auth->userModel]['password'] = $this->password($data[$this->Auth->userModel]['password']);
			}
		}
		return $data;
	}

	function password($data) {
		return md5($data);
	}

    /**
     * 認証追加
     *
     * $this->Auth->authorize = "controller";
     * このメソッドが有効
     *
     * @access    public
     */
	function isAuthorized() {
		$user = $this->Auth->user();
		if (empty($user)) {
			return false;
		}

		return true;
	}

    /**
     * タイトル設定（Messages利用）
     *
     * @access    protected
     */
	function _setTitleId($column) {
        $this->pageTitle = $this->Messages->get('title', $column);
	}

	/**
     * キャッシュなしヘッダー設定
     *
     * @access    protected
     */
    function _nocache_header() {
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
    }

	/**
     * 空白を取り除く
     *
     * @access    protected
     */
     function _trim($data) {
		if (is_array($data)) {
    		return array_map( array(&$this, '_trim'), $data );
    	}
    	return preg_replace('/^[ 　]*(.*?)[ 　]*$/u', '$1', $data);
    }

    /**
	 * リダイレクトをオーバライド
	 * SSLリダイレクト設定が有効な場合はhttpsに遷移させる
	 *
	 * @param string URL
	 * @param string エラー
	 * @access public
	 */
	function redirect($url, $status = null) {
		if (is_array($url)) {
			$_url = $url;
		} else {
			$_url = Router::parse($url);
		}

		// リダイレクトURLがホスト内のみ書き換え対象
		if (isset($_url['controller']) && $_url['controller'] != 'http:' && $_url['controller'] != 'https:') {
			// リダイレクト先コントローラのssl_flagとssl_actionsを取得
			App::import('Controller', Inflector::camelize($_url['controller']));
			$controller_name = Inflector::camelize($_url['controller']) . 'Controller';
			$redirect_controller =& new $controller_name;
			$redirect_controller->constructClasses();
			$ssl_flag = $redirect_controller->ssl_flag;
			$ssl_actions = $redirect_controller->ssl_actions;

			// ssl_flagが有効でssl_actionsが指定なしか、ssl_actionsに含む場合httpsに変更
	    	if( $ssl_flag && (empty($ssl_actions) || in_array($_url['action'], $ssl_actions))) {
				// さくらサーバではHTTPSでのアクセス時 $_SERVER['HTTP_HOST'] に www が省略されてしまうため www を補完する
				$url = 'https://www.' . $_SERVER['HTTP_HOST'] . Router::url($url);
	    	}
		}
		parent::redirect($url, $status);
		exit;
	}

	/**
     * HTTPS判別
     *
     * @access    protected
     */
    function _isHttps() {
    	return  (env('SERVER_PORT')==443 || env('SERVER_PORT')==8443 ) ? true : false;
    }

	/**
     * DB登録成功時対応
     *
     * @access    protected
     */
    function _succeeded(&$model) {
		$user = $this->Auth->user();
    	$msg = sprintf("controller:%s action:%s 詳細ID:%s 結果:%s 管理者ID:%s",
						$this->name, $this->action, $model->id, '成功', $user['Admin']['id']);
    	$this->log($msg, 'ACCESS');
    }

	/**
     * DB登録失敗時対応
     *
     * @access    protected
     */
    function _failed(&$model) {
		$user = $this->Auth->user();
    	$msg = sprintf("controller:%s action:%s 詳細ID:%s 結果:%s 管理者ID:%s",
						$this->name, $this->action, $model->id, '失敗', $user['Admin']['id']);
    	$this->log($msg, 'ACCESS');

    	$this->set('message', $this->Messages->get('error', 'db_save'));
    }

    /**
     * 名称     log
     * 処理概要 ログ出力
     *
     * @access  public
     */
     function log($msg, $type)
     {
        if (!defined('LOG4PHP_CONFIGURATION')) {
			define('LOG4PHP_CONFIGURATION', CONFIGS . 'log4php.properties');
        }

        $old_level = error_reporting(0);
        App::import('vendor', 'LoggerManager', array('file' => 'log4php' . DS . 'LoggerManager.php'));
		error_reporting($old_level);

        $remoteAddr = getenv( "REMOTE_ADDR" );
        $remoteHost = /*$_SERVER["REMOTE_HOST"];*/getenv( "REMOTE_HOST" );

        switch ($type) {
            case "ACCESS":
	        $logger =& LoggerManager::getLogger('access.Php');
	        //LoggerMDC::put( 'CARRIER', CARRIER );
	        LoggerMDC::put( 'ADDR', $remoteAddr );
	        LoggerMDC::put( 'HOST', $remoteHost );
	        LoggerMDC::put( 'URI', $_SERVER['REQUEST_URI'] );
	        LoggerMDC::put( 'S', session_id() );
	        $logger->info($msg);
            break;
            case "ERROR":
	        $logger =& LoggerManager::getLogger('er.Php');
	        //LoggerMDC::put( 'CARRIER', CARRIER );
	        LoggerMDC::put( 'ADDR', $remoteAddr );
	        LoggerMDC::put( 'HOST', $remoteHost );
	        LoggerMDC::put( 'URI', $_SERVER['REQUEST_URI'] );
	        LoggerMDC::put( 'S', session_id() );
	        $logger->error($msg);
            break;
            case "SQL":
	        $logger =& LoggerManager::getLogger('sql.Php');
	        //LoggerMDC::put( 'CARRIER', CARRIER );
	        LoggerMDC::put( 'ADDR', $remoteAddr );
	        LoggerMDC::put( 'HOST', $remoteHost );
	        LoggerMDC::put( 'URI', $_SERVER['REQUEST_URI'] );
	        LoggerMDC::put( 'S', session_id() );
	        $logger->error($msg);
            break;
        }
     }

    /**
     * 名称     logShutdown
     * 処理概要 log4phpをシャットダウンする（ログファイルへの書き出し）
     * @access  public
     */
    function logShutdown(){
		App::import('vendor', 'LoggerManager', array('file' => 'log4php' . DS . 'LoggerManager.php'));

		$logger =& LoggerManager::getLogger('access.Php');
        $logger->shutdown();
    }
}
?>