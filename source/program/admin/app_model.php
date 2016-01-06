<?php
/**
 * 共通モデル処理
 *
 * @copyright       Copyright (C) iTEC Hankyu Hanshin Co., Ltd.
 * @package         admin
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

	/**
	  * 期間チェック
	  *
	  * @access public
	 **/
	function checkBetween($params) {
		App::import('Component', 'Messages');
		$msg = new MessagesComponent();

		$fields  = array($params['start'], $params['end']);
		$cmpdate = array();
		foreach ($fields as $param) {
			$field = $param['field'];
			if (isset($param['time_field'])) {
				$time_field = $param['time_field'];
			} else {
				$time_field = '';
			}
			if ($this->data[$this->name][$field]=="") {
				if ($param['required']) {
					$this->invalidate($field, sprintf($msg->get('error', 'commons_search_date_empty'), $params['name'], $param['name']));
				}
			} else {
				$result = true;
				if (!preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $this->data[$this->name][$field], $matches)) {
					$result = false;
				}
				if ($time_field != '' && !preg_match('/^([0-9]|[0-1][0-9]|[2][0-3]):[0-5][0-9]$/', $this->data[$this->name][$time_field], $matches)) {
					$result = false;
				}

				if ($result) {
					list($yy, $mm, $dd) = explode('/', $this->data[$this->name][$field]);
					if (isset($this->data[$this->name][$time_field]) && $this->data[$this->name][$time_field] != '') {
						list($hh, $ii) = explode(':', $this->data[$this->name][$time_field]);
					} else {
						list($hh, $ii) = array(0, 0);
					}

					if (!checkdate($mm, $dd, $yy)) {
						$result = false;
					}
					if (!$this->checktime($hh, $ii)) {
						$result = false;
					}

					if (!$result) {
						$this->invalidate($field, sprintf($msg->get('error', 'commons_search_date_format'), $params['name'], $param['name']));
					} else {
						$cmpdate[$field] = date('Y-m-d H:i', mktime($hh, $ii, 0, $mm, $dd, $yy));
					}
				} else {
					$this->invalidate($field, sprintf($msg->get('error', 'commons_search_date_format'), $params['name'], $param['name']));
				}
			}
		}
		if (isset($cmpdate[$params['start']['field']]) && isset($cmpdate[$params['end']['field']])) {
			if ($cmpdate[$params['start']['field']]>$cmpdate[$params['end']['field']]) {
				$this->invalidate($params['start']['field'], sprintf($msg->get('error', 'commons_search_date_compare'), $params['name'], $params['start']['name'], $params['end']['name']));
			}
		}
	}

	/**
	 * 日付のフォーマットチェック
	 *
	 */
	function isDateFormat($params) {
		$result = true;

		$val = array_shift($params);

		if (preg_match('/^[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/', $val, $matches)) {
			list($yy, $mm, $dd) = explode('/', $val);
			if (!checkdate($mm, $dd, $yy)) {
				$result = false;
			}
		} else {
			$result = false;
		}

		return $result;
	}

/**
 * Some complex patterns needed in multiple places
 *
 * @var array
 * @access private
 */
	var $__pattern = array(
		'ip' => '(?:(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])\.){3}(?:25[0-5]|2[0-4][0-9]|(?:(?:1[0-9])?|[1-9]?)[0-9])',
		'hostname' => '(?:[a-z0-9][-a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,4}|museum|travel)'
	);
/**
 * Checks that a value is a valid URL according to http://www.w3.org/Addressing/URL/url-spec.txt
 *
 * The regex checks for the following component parts:
 * 	a valid, optional, scheme
 * 		a valid ip address OR
 * 		a valid domain name as defined by section 2.3.1 of http://www.ietf.org/rfc/rfc1035.txt
 *	  with an optional port number
 *	an optional valid path
 *	an optional query string (get parameters)
 *	an optional fragment (anchor tag)
 *
 * Validation::url()にチルダ(~)を追加
 *
 * @param string $check Value to check
 * @return boolean Success
 * @access public
 */
	function url($data, $strict = false) {
		$value = array_shift($data);

		$validChars = '([' . preg_quote('!"$&\'()*+,-.@_:;=') . '\/\~0-9a-z]|(%[0-9a-f]{2}))';
		$regex = '/^(?:(?:https?|ftps?|file|news|gopher):\/\/)' . ife($strict, '', '?') .
			'(?:' . $this->__pattern['ip'] . '|' . $this->__pattern['hostname'] . ')(?::[1-9][0-9]{0,3})?' .
			'(?:\/?|\/' . $validChars . '*)?' .
			'(?:\?' . $validChars . '*)?' .
			'(?:#' . $validChars . '*)?$/i';
		if (!preg_match($regex, $value)) {
			return false;
		}
		return true;
	}

	function onError() {
//		$db =& ConnectionManager::getDataSource($this->useDbConfig);
//		AppController::log($db->lastError(), 'SQL');
	}
}
?>