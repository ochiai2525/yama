<?php
/**
 * 共通エラー処理
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/10/30
 * @author          matsuyama
 * @version         1.00
 */
class AppError extends ErrorHandler {
/**
 * Controller instance.
 *
 * @var object
 * @access public
 */
	var $controller = null;

	function _errorpage($params) {
		AppController::log($params, 'ERROR');
		$this->controller->header('Location: ' . 'http://' . env('HTTP_HOST') . '/404.html');
	}

/**
 * Displays an error page (e.g. 404 Not found).
 *
 * @param array $params Parameters for controller
 * @access public
 */
	function error($params) {
		if (Configure::read()) {
			parent::error($params);
		} else {
			$this->_errorpage($params);
		}
	}
/**
 * Convenience method to display a 404 page.
 *
 * @param array $params Parameters for controller
 * @access public
 */
	function error404($params) {
		if (Configure::read()) {
			parent::error404($params);
		} else {
			$this->_errorpage($params);
		}
	}
}
?>