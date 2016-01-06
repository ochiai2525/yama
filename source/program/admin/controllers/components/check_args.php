<?php
/**
 * CheckArgsComponent
 *
 * アクション引数型チェック
 * コントローラに変数を追加
 * var $this->CheckArgs->arg_types = array( [アクション] => array(オプション,,,);
 * var $this->CheckArgs->arg_types = array( 'index' => array(array('type'=>'digit'),array('type'=>'alnum','max'=>10));
 */
class CheckArgsComponent extends Object
{
	var $autoRedirect = false;
	var $redirectUrl = '/';

	var $result = false;

	var $arg_types = array();

	/**
     * アクション引数型チェック
     *
     * @access    public
     */
	function startup(&$controller) {

		$this->result = $this->_checkArgs($controller);
		if (!$this->result && $this->autoRedirect) {
			$controller->redirect($this->redirectUrl, null, true);
		}
		return true;
	}

    /**
     * 引数が有効か
     *
     * @access    public
     */
	function valid() {
		return $this->result;
	}

    /**
     * アクション引数型チェック
     *
     * @access    protected
     */
	function _checkArgs(&$controller) {
		if (!isset($this->arg_types[$controller->action])) {
			return true;
		} else {
			$args = $this->arg_types[$controller->action];

			foreach ($args as $index => $options) {
				if (!isset($controller->params['pass'][$index])) {
					continue;
				}
				if ($options['type'] == 'digit') {
					$options = array_merge(array('maxlength' => 10, 'max' => 2147483647), $options);
					if(!preg_match('/^[0-9]+$/', $controller->params['pass'][$index])) {
			  			return false;
			  		}
			  		if ($controller->params['pass'][$index]>$options['max']) {
			  			return false;
			  		}
					if (strlen($controller->params['pass'][$index])>$options['maxlength']) {
			  			return false;
			  		}
				} elseif ($options['type'] == 'alnum') {
					$options = array_merge(array('maxlength' => 100), $options);
					if(!preg_match('/^[A-Za-z0-9]+$/', $controller->params['pass'][$index])) {
			  			return false;
			  		}
					if (strlen($controller->params['pass'][$index])>$options['maxlength']) {
			  			return false;
			  		}
				} elseif ($options['type'] == 'custom') {
					$options = array_merge(array('maxlength' => 100), $options);
					if($options['pattern']!='' && !preg_match($options['pattern'], $controller->params['pass'][$index])) {
			  			return false;
			  		}
				}
			}
		}

		return true;
	}
}
?>