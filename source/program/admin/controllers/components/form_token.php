<?php
/**
 * FormTokenComponent
 * 同セッションでの多ウィンドウ登録対応
 *
 * ※ Security.level=high不可。SecurityComponentは同時使用不可
 */
class FormTokenComponent extends Object
{
	var $components = array('RequestHandler', 'Session');

	var $controller = null;

	var $base_key = 'form';

	// 最大保持数
	var $max_save = 20;

	/**
     * startup
     *
     * @access    public
     */
	function startup(&$controller) {
		$this->controller = $controller;

		$this->_clean();

		if ($controller->RequestHandler->isGet()) {
			$this->_generateToken($controller);
		} else {
			$controller->params['_Token']['key'] = $controller->data['_Token']['key'];
		}
		return true;
	}

	/**
     * チェック
     *
     * @access    public
     */
	function check() {
		$session_key = $this->base_key . '.' . $this->controller->data['_Token']['key'];
		return $this->Session->check($session_key);
	}

	/**
     * データ削除
     *
     * @access    public
     */
	function del() {
		if (!isset($this->controller->data['_Token']['key']) || $this->controller->data['_Token']['key']=='') {
			return false;
		}

		$session_key = $this->base_key . '.' . $this->controller->data['_Token']['key'];
		$this->Session->delete($session_key);
	}

	/**
     * データ読み込み
     *
     * @access    public
     */
	function read($subkey='default') {
		if (!isset($this->controller->data['_Token']['key']) || $this->controller->data['_Token']['key']=='') {
			return false;
		}

		$session_key = $this->base_key . '.' . $this->controller->data['_Token']['key'];
		$data_key = 'data';
		if ($subkey != '') {
			$data_key .= '.' . $subkey;
		}
		$session_key .= '.' . $data_key;

		return $this->Session->read($session_key);
	}

	/**
     * データ保存
     *
     * @access    public
     */
	function write(&$data, $subkey='default') {
		if (!isset($this->controller->data['_Token']['key']) || $this->controller->data['_Token']['key']=='') {
			return false;
		}

		$session_key = $this->base_key . '.' . $this->controller->data['_Token']['key'];

		$expires = strtotime('+' . Security::inactiveMins() . ' minutes');
		$session_data = array();
		$session_data = $this->Session->read($session_key . '.data');
		if ($subkey != '') {
			$session_data[$subkey] = $data;
		} else {
			$session_data = $data;
		}
		$params = array(
			'expires' => $expires,
			'data' => $session_data,
		);
		$this->Session->write($session_key, $params);

		// 最大保持数を超える場合は古いデータを削除
		$session_data = $this->Session->read($this->base_key);
		if (count($session_data) > $this->max_save) {
			$expires = array();
			foreach ($session_data as $key => $row) {
				$expires[$key]  = $row['expires'];
			}
			array_multisort($expires, SORT_ASC, $session_data);
			for ($i=count($session_data); $i>$this->max_save; $i--) {
				array_shift($session_data);
			}
			$this->Session->write($this->base_key, $session_data);
		}
	}

/**
 * Add authentication key for new form posts
 *
 * @param object $controller Instantiating controller
 * @return bool Success
 * @access protected
 */
	function _generateToken(&$controller) {
		$authKey = Security::generateAuthKey();

		$this->controller->params['_Token']['key'] = $authKey;
		$this->controller->data['_Token']['key'] = $authKey;
		$params = array();
		$this->write($params);

		return true;
	}

	/**
     * 有効期限の切れたデータを削除
     *
     * @access    protected
     */
	function _clean() {
		$session_data = $this->Session->read($this->base_key);
		$expires = array();
		if (is_array($session_data)) {
			foreach ($session_data as $key => $row) {
				if($row['expires']< time()) {
					$this->_del($key);
				}
			}
		}
	}

	/**
     * データ削除
     *
     * @access    protected
     */
	function _del($key) {
		$session_key = $this->base_key . '.' . $key;
		$this->Session->delete($session_key);
	}
}
?>