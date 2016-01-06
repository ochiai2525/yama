<?php
/**
 * メニューの表示
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class MenusController extends AppController {
	var $name = 'Menus';
    var $uses = array();

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
    }
}
?>