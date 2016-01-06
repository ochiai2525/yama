<?php
/**
 * 共通モデル処理
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         system
 * @since           2009/03/18
 * @author          matsuyama
 * @version         1.00
 */
class AppModel extends Model {
	var $actsAs = array('Containable');

	/**
	 * CakePHP Validation用
     * 最大文字数。最大文字数内ならtrue
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function max_length( $data, $max ) {
		$str = array_shift($data);
		return $this->_max_length($str, $max);
	}

    /**
	 * CakePHP Validation用
     * 最小文字数。最小文字数内ならtrue
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function min_length( $data, $min ) {
		$str = array_shift($data);
		return $this->_min_length($str, $min);
	}

    /**
     * CakePHP Validation用
     * 全角ひらがな
     * 事前にmb_regex_encoding設定必要
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function is_hiragana($data) {
		$text = array_shift($data);
		return $this->_is_hiragana($text);
	}

    /**
     * CakePHP Validation用
     * 全角カタカナ
     * 事前にmb_regex_encoding設定必要
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function is_katakana($data) {
		$text = array_shift($data);
		return $this->_is_katakana($text);
	}

    /**
     * CakePHP Validation用
     * 数字
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function is_tel($data) {
		$tel = array_shift($data);
		return $this->_is_tel($tel);
	}

    /**
     * CakePHP Validation用
     * 数字
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function is_digit($data) {
		$value = array_shift($data);
		return $this->_is_digit($value);
	}

    /**
     * CakePHP Validation用
     * 必須組み合わせ
     * validateのallowEmptyはtrueを指定しないこと
     *
     * @access    public
     */
	function required($data, $pair) {
		$value = array_shift($data);
		if ($value=="" && $pair!="") {
			return false;
		}
		return true;
	}

    /**
     * CakePHP Validation用
     * 機種依存文字
     *
     * @access    public
     * @return true:機種依存なし false:機種依存あり
     */
	function peculiar($data) {
		$value = array_shift($data);
		return $this->_peculiar($value);
	}

    /**
     * 空。空文字ならばtrue
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _is_empty($value) {
		if (is_null($value) || $value == "") {
			return true;
		} else {
			return false;
		}
	}

	/**
     * 最大文字数。最大文字数内ならtrue
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _max_length( $str, $max ) {
		if (!is_string($str)) {
			return false;
		}
		if (!is_numeric($max)) {
			return false;
		}
		return mb_strlen($str)<=$max ? true : false;
	}

    /**
     * 最小文字数。最小文字数内ならtrue
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _min_length( $str, $min ) {
		if (!is_string($str)) {
			return false;
		}
		if (!is_numeric($min)) {
			return false;
		}
		return mb_strlen($str)>=$min ? true : false;
	}

    /**
     * 全角ひらがな
     * 事前にmb_regex_encoding設定必要
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _is_hiragana($text) {
	    if(empty($text)) {
		    return false;
        }
		if (mb_ereg("^[ぁ-んー　]+$",$text)) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * 全角カタカナ
     * 事前にmb_regex_encoding設定必要
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _is_katakana($text) {
	    if(empty($text)) {
		    return false;
        }
		if (mb_ereg("^[ァ-ヶー　 ]+$",$text)) {
			return true;
		} else {
			return false;
		}
	}

    /**
     * 数字
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _is_tel($tel) {
        if(empty($tel)) {
		    return false;
        }
	    if(!preg_match("/^\d{2,5}-?\d{2,4}-?\d{2,4}$/", $tel)){
		    return false;
	    }
        return true;
	}

    /**
     * 数字
     *
     * @access    protected
     * @return true:一致 false:不一致
     */
	function _is_digit($value) {
		if (!preg_match("/^-?[0-9]+$/", $value)) {
			return false;
		}
		return true;
	}

    /**
     * 機種依存文字
     *
     * @access    protected
     * @return true:機種依存なし false:機種依存あり
     */
	function _peculiar($str, $cmp_charset='SJIS') {
		$cmp = mb_convert_encoding(mb_convert_encoding($str, $cmp_charset, 'UTF-8'), 'UTF-8', $cmp_charset);
		if ($str == $cmp) {
			return true;
		} else {
			return false;
		}
	}

	/**
     * PostgreSQL LIKE文のエスケープ
     *
     * @access    public
     */
	function escapeLike($str, $escape='\\') {
		$str = str_replace($escape, $escape.$escape, $str);
		$str = str_replace('%', $escape.'%', $str);
		$str = str_replace('_', $escape.'_', $str);
		return $str;
	}

    /**
     * 時間チェック
     *
     * @access    public
     * @return true:一致 false:不一致
     */
	function checktime($hour, $minute) {
	    if ($hour > -1 && $hour < 24 && $minute > -1 && $minute < 60) {
	        return true;
	    }
	    return false;
	}

	function onError() {
		$db =& ConnectionManager::getDataSource($this->useDbConfig);
		AppController::log($db->lastError(), 'SQL');
	}
}
?>