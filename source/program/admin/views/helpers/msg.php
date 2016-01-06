<?php

//メッセージ
class MsgHelper extends AppHelper
{
	function get($type, $code) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		return $msg->get($type, $code);
	}
}

?>