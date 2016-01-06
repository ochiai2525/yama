<?php
/**
 * お問い合わせ申し込み
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
 * @since           2009/09/28
 * @version         1.00
 */
class InquiriesController extends AppController {

	var $name = 'Inquiries';

	var $components = array('Qdmail');

	var $uses = array('Inquiry');
	var $helpers = array('Output');
	var $product_name = null;

    /**
     * アクション前処理
     *
     * @access    public
     */
    function beforeFilter() {
    	// アクションが数値の場合引数扱いとしてデフォルトアクションを実行
    	if (is_numeric($this->action)) {
			// お問合せ製品名キーをセット
			$this->product_name = $this->action;
			// 一覧画面処理を行う
			$this->setAction('index');
		}
    	parent::beforeFilter();
    }

    /**
     * デフォルトアクション
     *
     * @access    public
     */
	function index() {
		$this->setAction('register');
	}

    /**
     * お問い合わせ
     *
     * @access    public
     */
	function register() {

		// お問合せ製品名キーがセットされている場合初期値を投入
		if ( $this->product_name ) {
			$product_name_list = $this->Messages->getList('list', 'PRODUCT_NAME_LIST');
			$this->data['Inquiry']['product_name'] = @$product_name_list[$this->product_name];
		}
		if ($this->RequestHandler->isPost()) {
			if (array_key_exists('confirm_img_x', $this->params['form'])) { // 確認
				$this->Inquiry->set($this->data);
				if ($this->Inquiry->validates()) {
					$this->Session->write($this->name.'.form', $this->data);
					$this->_setTitleId('inquiries_register_confirm');
					$this->render('confirm');
				}
			} elseif (array_key_exists('commit_btn_x', $this->params['form'])) { // 送信
				$save_data = $this->Session->read($this->name.'.form');
				$this->Session->del($this->name.'.form');
				if (!empty($save_data)) {
					$this->Inquiry->set($save_data);
					if ($this->Inquiry->validates()) {
						$save_data = $this->_setSaveField($save_data);
						if (!$this->Inquiry->save($save_data)) {
							// 登録失敗
							$this->log('お問い合わせ登録失敗', 'ERROR');
						} else {
							// 登録成功
							// ユーザ宛メール送信
							// $this->_sendUserMail($save_data);
							// 管理者宛メール送信
							$this->_sendAdminMail($save_data);
							$this->set('data', $save_data);
							$this->_setTitleId('inquiries_register_complete');
							$this->render('complete');
						}
					} else {
						$this->log('お問い合わせ登録失敗', 'ERROR');
					}
				}
			} elseif (array_key_exists('back_btn_x', $this->params['form'])) { // 入力に戻る
				$this->data = $this->Session->read($this->name.'.form');
			} elseif (array_key_exists('reset_btn_x', $this->params['form'])) { // リセット
				$this->data = array();
			}
		}
	}

    /**
     * 保存フィールドに合わせてデータを加工
     *
     * @access    protected
     * @param    array    $data    入力データ
     * @return   array
     */
    function _setSaveField(&$data) {
		$ret = $data;
		// 参加者1
		// 郵便番号
		if (isset($data['Inquiry']['post1']) && isset($data['Inquiry']['post2'])
			&& $data['Inquiry']['post1'] != ''  && $data['Inquiry']['post2'] != '') {
			$ret['Inquiry']['post'] = sprintf('%s-%s', $data['Inquiry']['post1'], $data['Inquiry']['post2']);
		}
		// 電話番号
		if (isset($data['Inquiry']['tel1']) && isset($data['Inquiry']['tel2']) && isset($data['Inquiry']['tel3'])
			&& $data['Inquiry']['tel1'] != ''  && $data['Inquiry']['tel2'] != '' && $data['Inquiry']['tel3'] != '') {
			$ret['Inquiry']['tel'] = sprintf('%s-%s-%s', $data['Inquiry']['tel1'], $data['Inquiry']['tel2'], $data['Inquiry']['tel3']);
		}
		// FAX番号
		if (isset($data['Inquiry']['fax1']) && isset($data['Inquiry']['fax2']) && isset($data['Inquiry']['fax3'])
			&& $data['Inquiry']['fax1'] != ''  && $data['Inquiry']['fax2'] != '' && $data['Inquiry']['fax3'] != '') {
			$ret['Inquiry']['fax'] = sprintf('%s-%s-%s', $data['Inquiry']['fax1'], $data['Inquiry']['fax2'], $data['Inquiry']['fax3']);
		}
		return $ret;
	}

   /**
    * 登録者完了メール送信(ユーザ宛)
    *
    * @access    protected
    * @return   boolean
    */
/*
   function _sendUserMail(&$data) {
		$subject      = $this->Messages->get('mail', 'inquiry_user_subject');
		$from         = $this->Messages->get('mail', 'inquiry_user_from');
		$from_name    = $this->Messages->get('mail', 'inquiry_user_from_name');
		$envelopeFrom = $this->Messages->get('mail', 'inquiry_user_envelope_from');
		if ($from_name == '') {
			$from_name = null;
		}

		$params = array();
		$params = $data['Inquiry'];
		// お問い合わせ種別名
		$params['inquiry_type_name'] = '';
		$inquiry_type_list = $this->Messages->getList('list', 'INQUIRY_TYPE');
		if (isset($data['Inquiry']['inquiry_type']) && isset($inquiry_type_list[$data['Inquiry']['inquiry_type']])) {
			$params['inquiry_type_name'] = $inquiry_type_list[$data['Inquiry']['inquiry_type']];
		}

		$this->Qdmail->to( $data['Inquiry']['email'] );
		$this->Qdmail->subject($subject);
		$this->Qdmail->from($from, $from_name);
		$this->Qdmail->replyto($envelopeFrom);
		$this->Qdmail->cakeText($params, 'inquiry_user');
		$this->Qdmail->send();
   }
*/
   /**
    * 登録者完了メール送信(管理者宛)
    *
    * @access    protected
    * @return   boolean
    */
   function _sendAdminMail(&$data) {
		
		$subject      = $this->Messages->get('mail', 'inquiry_admin_subject');
		$from         = $this->Messages->get('mail', 'inquiry_admin_from');
		$from_name    = $this->Messages->get('mail', 'inquiry_admin_from_name');
		$envelopeFrom = $this->Messages->get('mail', 'inquiry_admin_envelope_from');
		if ($from_name == '') {
			$from_name = null;
		}
		$to = $this->Messages->get('mail', 'inquiry_admin_to');

		$params = array();
		$params = $data['Inquiry'];

		$params['date'] = date('Y/m/d H:i:s');
		$params['admin_url'] = $this->Messages->get('const', 'ADMIN_URL');
		
		$this->Qdmail->to( $to );
		$this->Qdmail->subject($subject);
		$this->Qdmail->from($from, $from_name);
		$this->Qdmail->replyto($envelopeFrom);
		$this->Qdmail->cakeText($params, 'inquiry_admin');
		$this->Qdmail->send();
   }
}
?>