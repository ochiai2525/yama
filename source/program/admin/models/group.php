<?php
/**
 * グループマスタモデル
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/03/18
 * @version         1.00
 */
class Group extends AppModel
{
	var $name = 'Group';

    var $hasMany = array(
        'Menu' => array(
            'className'     => 'Menu',
            'foreignKey'    => 'group_id',
            'conditions'    => array('Menu.active' => 1),
            'order'    => 'Menu.ord ASC',
            'dependent'=> false
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
   		$params['conditions'] = array('Group.id'=> $id, 'Group.active' => 1);
		return $this->find('first', $params);
	}

    /**
     * 有効な一覧を取得
     *
     * @access    public
     */
	function getAll($options=array()) {
	    $params = array();
   		$params['conditions'] = array('Group.active'=> 1);
  		$params = Set::merge($params, $options);
		$list = $this->find('all', $params);
		return $list;
	}

    /**
     * 有効な一覧を取得
     *
     * @access    public
     */
	function getSelectList() {
    	$params = array();
    	$params['fields'] = array('Group.id', 'Group.name');
		$params['conditions'] = array( 'Group.active'=> 1);
		return $this->find('list', $params);
	}
}
?>