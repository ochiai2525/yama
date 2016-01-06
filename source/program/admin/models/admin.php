<?php
/**
 * 管理者モデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @version         1.00
 */
class Admin extends AppModel
{
	var $name = 'Admin';

    var $hasAndBelongsToMany = array(
	        'Group' => array(
	                'className'              => 'Group',
	                'joinTable'              => 'admins_groups',
	                'foreignKey'             => 'admin_id',
	                'associationForeignKey'  => 'group_id',
	                'conditions'             => 'Group.active = 1',
	                'order'                  => '',
	                'limit'                  => '',
	                'uniq'                   => true,
	                'finderQuery'            => '',
	                'deleteQuery'            => '',
	                'insertQuery'            => ''
                    )
        );

	/**
	  * 有効な情報を取得
	  *
	  * @access public
	 **/
	function getData($id) {
		if (!is_numeric($id)) {
			return false;
		}

		$params = array();
   		$params['conditions'] = array('Admin.id'=> $id, 'Admin.active' => 1);
		return $this->find('first', $params);
	}

	/**
	  * 情報を無効にする
	  *
	  * @access public
	 **/
	function invalidData($admin_id) {
		if (!is_numeric($admin_id)) {
			return false;
		}

		$this->create();
    	$this->id = $admin_id;
    	$save_data = array();
    	$save_data['Admin']['active'] = 0;
		$this->set($save_data);
		if ($this->save(null, false)) {
			return true;
		}

		return false;
	}

    /**
     * 新規登録チェック
     *
     * @access    public
     */
	function validates($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			'new_username' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_username_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_USERNAME')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_username_length'),
					),
				array(
					'rule' =>  array('custom', '/^[0-9A-Za-z]+$/'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_username_format'),
					),
				array(
					'rule' =>  'existUsername',
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_username_exist'),
					),
				),
			'new_password' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_password_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_format'),
					),
				),
			'new_password_cfm' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_password_cfm_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_cfm_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_cfm_format'),
					),
				array(
					'rule' =>  array('equalTo', $this->data['Admin']['new_password']),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_match'),
					),
				),
			'admintype' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_admintype_empty'),
					),
				),
			'name' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_name_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_NAME')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_name_length'),
					),
				),
			'email' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_EMAIL')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_email_length'),
					),
				array(
					'rule' => 'email',
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'managers_email_format'),
					),
				),
			);

		// グループ権限をまとめてチェック
		$this->_checkAuthMenu();

		return parent::validates($options);
	}

    /**
     * 編集チェック
     *
     * @access    public
     */
	function validatesEdit($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			'new_password' => array(
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_format'),
					),
				array(
					'rule' =>  array('equalTo', $this->data['Admin']['new_password_cfm']),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_match'),
					),
				),
			'new_password_cfm' => array(
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_cfm_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_cfm_format'),
					),
				array(
					'rule' =>  array('equalTo', $this->data['Admin']['new_password']),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_password_match'),
					),
				),
			'admintype' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_admintype_empty'),
					),
				),
			'name' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'managers_name_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_NAME')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_name_length'),
					),
				),
			'email' => array(
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_MANAGERS_EMAIL')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'managers_email_length'),
					),
				array(
					'rule' => 'email',
					'allowEmpty' => true,
					'last' => true,
					'message' => $msg->get('error', 'managers_email_format'),
					),
				),
			);

		// グループ権限をまとめてチェック
		$this->_checkAuthMenu();

		return parent::validates($options);
	}

    /**
     * 削除チェック
     *
     * @access    public
     */
	function validatesDelete($user, $options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array();

		// ログインIDと削除管理者IDが同じ場合は削除不可
		if ($this->id == $user['Admin']['id']) {
			$this->invalidate('id', $msg->get('error', 'managers_as_id'));
		}
		return parent::validates($options);
	}

	/**
	  * グループ権限をまとめてチェック
	  *
	  * @access protected
	 **/
	function _checkAuthMenu() {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$auth_count = 0;
		// システム管理者以外の場合はメニューの選択チェックを行う
		$admintype_id_list = $msg->getList('list', 'ADMINTYPE_ID');
		if ($this->data['Admin']['admintype'] != $admintype_id_list['SYSTEM']) {
			foreach ($this->data['Admin'] as $key => $value) {
				if (preg_match('/^auth_menu_status:(\d+)$/', $key, $matches)) {
					if ($value == "") {
						$this->invalidate('auth_menu_status:'.$matches[1], $msg->get('error', 'managers_auth_menu_empty'));
					}
					if ($value != -1) {
						$auth_count++;
					}
				}
			}
			// すべて権限なしの場合もエラー
			if ($auth_count == 0) {
				$this->invalidate('admintype', $msg->get('error', 'managers_auth_menu_select'));
			}
		}
	}

    /**
     * ログインID存在チェック
     *
     * @access    public
     */
	function existUsername($data) {
		$username = array_shift($data);
	    $params = array();
   		$params['conditions'] = array('Admin.username'=> $username, 'Admin.active' => 1);
		$count = $this->find('count', $params);
		return ($count==0) ? true : false;
	}

    /**
     * パスワードチェック
     *
     * @access    public
     */
	function is_password($data) {
		$text = array_shift($data);

	    if(empty($text)) {
		    return false;
        }
		if (mb_ereg("^[0-9A-Za-z!#\_&\/\@\?]+$",$text)) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * ログイン値チェック
     *
     * @access    public
     */
    function validateLogin() {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$this->validate = array(
			'username' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'login_username_empty'),
					),
				array(
					'rule' =>  array('max_length', $msg->get('const', 'MAXLENGTH_LOGIN_USERNAME')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'login_username_length'),
					),
				array(
					'rule' =>  array('custom', '/^[0-9A-Za-z]+$/'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'login_username_format'),
					),
				),
			'password' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'login_password_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_LOGIN_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'login_password_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'login_password_format'),
					),
				),
			);

		$options = array();
		return parent::validates($options);
	}

    /**
     * パスワード変更チェック
     *
     * @access    public
     */
	function validatesChangePassword($options = array()) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		if (empty($this->id)) {
			return false;
		}

		$this->validate = array(
			'now_password' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'change_password_now_password_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_now_password_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_now_password_format'),
					),
				array(
					'rule' =>  array('matchPassword', $this->id),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_now_password_match'),
					),
				),
			'new_password' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'change_password_password_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_password_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_password_format'),
					),
				),
			'new_password_cfm' => array(
				array(
					'rule' => VALID_NOT_EMPTY,
					'last' => true,
					'message' => $msg->get('error', 'change_password_password_cfm_empty'),
					),
				array(
					'rule' =>  array('between', $msg->get('const', 'MINLENGTH_LOGIN_PASSWORD'), $msg->get('const', 'MAXLENGTH_MANAGERS_PASSWORD')),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_password_cfm_length'),
					),
				array(
					'rule' =>  array('is_password'),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_password_cfm_format'),
					),
				array(
					'rule' =>  array('equalTo', $this->data['Admin']['new_password']),
					'last' => true,
					'allowEmpty' => true,
					'message' => $msg->get('error', 'change_password_password_match'),
					),
				),

			);

		return parent::validates($options);
	}

    /**
     * パスワードチェック
     *
     * @access    public
     */
	function matchPassword($data, $id) {
		$password = array_shift($data);
	    $params = array();
   		$params['conditions'] = array('Admin.id'=>$id, 'Admin.password'=> AppController::password($password), 'Admin.active' => 1);
		$count = $this->find('count', $params);
		return ($count==1) ? true : false;
	}

    /**
     * 管理者IDから有効なメニューを取得
     *
     * @access    public
     */
	function getAuthGroupList($admin_id) {
		if (!is_numeric($admin_id)) {
			return false;
		}
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();
		App::import('Model', 'Group');
		$group = new Group();

		// システム管理者の場合はすべてのメニューを取得
		$admin_data = $this->getData($admin_id);
		$admintype_id_list = $msg->getList('list', 'ADMINTYPE_ID');
		if ($admin_data['Admin']['admintype'] == $admintype_id_list['SYSTEM']) {
			$ret_list = $group->getAll(array('order'=>array('Group.ord'=>'ASC')));
		} else {
		    $params = array();
	   		$params['conditions'] = array('Admin.id'=> $admin_id, 'Admin.active' => 1);
	   		$params['order'] = array();
			$admin_data = $this->find('first', $params);
			$ret_list = array();
			foreach ($admin_data['Group'] as $data) {
				$group_data = $group->getData($data['id']);
				if (!empty($group_data)) {
					$group_data['Group']['AdminsGroup'] = $data['AdminsGroup'];
					$ret_list[] = $group_data;
				}
			}
		}
		return $ret_list;
	}

    /**
     * 管理者情報を保存
     *
     * @access    public
     */
	function saveData(&$data) {
		App::import('Model', 'AdminGroup');
		$admin_group = new AdminGroup();
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$result = true;

		$this->set($data);
		$this->begin();
		if (!$this->save(null, false)) {
			$result = false;
		}
		// システム管理者以外はメニュー紐付けを保存
		$admintype_id_list = $msg->getList('list', 'ADMINTYPE_ID');
		$operation_auth_status_id = $msg->getList('list', 'OPERATION_AUTH_STATUS_ID');

		if ($data['Admin']['admintype'] != $admintype_id_list['SYSTEM']) {
			// 権限なし以外は紐付けを追加登録
			foreach ($data['Admin'] as $key => $value) {
				if (preg_match('/^auth_menu_status:(\d+)$/', $key, $matches)) {
					if($value!=$operation_auth_status_id['AUTHNONE']) {
						$admin_group->create();
						$save_data = array();
						$save_data['AdminGroup']['admin_id'] = $this->id;
						$save_data['AdminGroup']['group_id'] = $matches[1];
						$save_data['AdminGroup']['authtype'] = $value;
						// 紐付けIDがある場合は更新
						if ($data['Admin']['id:'.$matches[1]]!="") {
							$admin_group->id = $data['Admin']['id:'.$matches[1]];
						}
						$admin_group->set($save_data);
						if (!$admin_group->save(null, false)) {
							$result = false;
						}
					} else {
						// 権限のない紐付けは削除
						if ($data['Admin']['id:'.$matches[1]]!="") {
							$admin_group->del($data['Admin']['id:'.$matches[1]]);
						}
					}
				}
			}
		} else {
			// システム管理者は管理者IDから紐付けを削除
			$admin_group->deleteAllFromAdminId($this->id);
		}

		if ($result) {
			$this->commit();
		} else {
			$this->rollback();
		}
		return $result;
	}

    /**
     * パスワード変更を保存
     *
     * @access    public
     */
	function saveChangePassword(&$data) {
		$result = true;

		$this->set($data);
		$this->begin();
		if (!$this->save(null, false)) {
			$result = false;
		}
		if ($result) {
			$this->commit();
		} else {
			$this->rollback();
		}
		return $result;
	}

    /**
     * 管理者情報を削除（無効）
     *
     * @access    public
     */
	function updateInvalidData(&$data) {
		$this->set($data);
		if ($this->save(null, false)) {
			$result = false;
		}
		return $result;
	}
}
?>