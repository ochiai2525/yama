<?php
/**
 * 管理者-グループモデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @version         1.00
 */
class AdminGroup extends AppModel
{
	var $name = 'AdminGroup';
	var $useTable = 'admins_groups';

    /**
     * 管理者IDから紐付けを削除
     *
     * @access    public
     */
	function deleteAllFromAdminId($admin_id) {
		return $this->deleteAll(array('AdminGroup.admin_id' => $admin_id));
	}
}
?>