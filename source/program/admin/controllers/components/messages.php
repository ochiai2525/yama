<?php
/**
 * Messages Component,
 */
class MessagesComponent extends Object
{
	var $config = array();

	/**
     * iniファイルから文字列を取得する。
     *
     * @access    public
     */
	function get($type, $msgKey, $process_sections=false, $replace_flag=true) {
		$str = null;

		if( !empty($this->config[$type]) ){
			if (isset($this->config[$type][$msgKey])) {
		        $str = $this->config[$type][$msgKey];
			} else {
				$str = "";
			}
		}else{
			$file = dirname(dirname(dirname(__FILE__))) . '/config/messages/' .$type . '.ini';
			if (file_exists($file)) {
				$this->config[$type] = parse_ini_file($file, $process_sections);
				if (isset($this->config[$type][$msgKey])) {
			        $str = $this->config[$type][$msgKey];
				} else {
					$str = "";
				}
	        }
		}
		if ($process_sections) {
			return $str;
		} else {
			if ($replace_flag && $str!="") {
				$search = array();
				$replace = array();
				if (preg_match_all('/\{%([^\.]+)\.([^%]+)%\}/', $str, $matches)) {
					$matches = $this->_trim($matches, Configure::read('App.encoding'));
					for ($num = 0; $num<count($matches); $num++ ) {
						if (isset($matches[1][$num])) {
							if ($matches[1][$num] == 'define') {
								$search[]  = $matches[0][$num];
								$replace[] = constant($matches[2][$num]);
							} elseif ($matches[1][$num] == 'env') {
								$search[]  = $matches[0][$num];
								$replace[] = env($matches[2][$num]);
							} else {
								if ($matches[1][$num] != "" && $matches[2][$num] != "") {
									$search[]  = $matches[0][$num];
									$replace[] = $this->get($matches[1][$num], $matches[2][$num]);
								}
							}
						}
					}
					return str_replace($search, $replace, $str);
				} else {
					return $str;
				}
			} else {
				return $str;
			}
		}
	}

	// 一覧取得
	function getList($type, $msgKey) {
		return $this->get($type, $msgKey, true, false);
	}

	/**
     * 空白を取り除く
     *
     * @access    protected
     */
     function _trim($data, $charset = 'UTF-8') {
		if (is_array($data)) {
    		return array_map( array(&$this, '_trim'), $data );
    	}
		return trim( mb_convert_kana( $data, "s", $charset));
    }
}
?>