<?php
/**
 * エラー画面表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class ErrorsController extends AppController {

	var $name = 'Errors';
    var $uses = array();

    /**
     * エラー表示
     *
     * @access    public
     */
    function msg($error_id) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

        $this->set('message', $msg->get('error', 'system_'.$error_id));
    }
}
?>