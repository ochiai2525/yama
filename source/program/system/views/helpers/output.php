<?php

// 表示出力
class OutputHelper extends AppHelper
{
	/**
	 * 日時を表示
	 *
	 * @access    public
	 * @param string 日時 strtotimeで変換可能なもの
	 * @param string 変換後の形式
	 */
	function dt($date, $format='Y/m/d H:i') {
		if (empty($date)) {
			return '';
		}
		$time = strtotime($date);
		if(!$time) {
			return '';
		}
		return date($format, $time);
	}

	/**
	 * リストの値を表示
	 *
	 * @access    public
	 * @param array key=>valueのリスト
	 * @param string 配列から値を取得するkey
	 */
	function l($list, $id) {
		if (!is_array($list) || empty($list) || $id=="") {
			return '';
		}
		if (!isset($list[$id])) {
			return '';
		}
		return $list[$id];
	}
}

?>