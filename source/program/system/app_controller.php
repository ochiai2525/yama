<?php
/**
 * 共通コントローラ
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         system
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class AppController extends Controller {
    var $components = array('Messages', 'RequestHandler');
    var $helpers = array('Form', 'Html', 'Javascript', 'Msg', 'Output');

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
		mb_detect_order(Configure::read('App.encoding'));
		mb_regex_encoding(Configure::read('App.encoding'));
   	}

    /**
     * アクション前処理
     *
     * @access    public
     */
	function beforeFilter() {
		// デフォルトタイトル設定
        $this->_setTitleId(Inflector::underscore($this->name)."_".$this->action);

		if (!empty($this->data)) {
			// 空白を取り除く
			$this->data = $this->_trim($this->data);
        }
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

	/**
     * トークンをセット
     *
     * @access    protected
     */
    function _setToken() {
	    $token_key = Security::generateAuthKey();
		$this->params['_Token']['key'] = $token_key;
		$this->Session->write('_Token.key', $token_key);
    }

	/**
     * トークンチェック
     *
     * @access    protected
     */
    function _checkToken() {
		$token_key = $this->Session->read('_Token.key');
		if ($token_key == $this->data['_Token']['key']) {
			return true;
		} else {
			return false;
		}
    }

    function _errorpage() {
    	$this->redirect($this->Messages->get('const', 'HTTP_URL') . '404.html');
    }
}
?>