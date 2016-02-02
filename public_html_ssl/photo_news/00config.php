<?php //error_reporting(E_ALL | E_STRICT);//デバッグ
//配列初期化
$userid=array();$password=array();$extensionTypeList=array();
#######################################################################################
##
#  PHP新着情報、お知らせプログラム News02（画像アップ・エディタ機能搭載版）ver1.0.1 (2013.07.22公開)
#
#  トップーページの新着情報やお知らせなどに適しています。
#　インラインフレームでも良いですが、トップページに直接埋め込むことでSEOにも効果的です。
#  改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: k.numata
#  HP: http://www.php-factory.net/
#
#　■□ 設定時の注意点（はじめに必ず読んで下さい） □■　
#　1，値（=の右側）は数字以外の文字列の場合シングルクォーテーション（'）で囲んでいます。
#　2，これをを外したり削除しないでください。後ろのセミコロン「;」も削除しないください。
#　3，またドルマーク（$）が付いている文字列は絶対に変更しないでください。
#　4，数字で設定しているものは必ず「半角数字」。※シングルクォーテーション（'）では囲まない。
#　これらを間違えるとプログラムが正常に動作しない、また最悪の場合データが飛ぶので注意下さい。
##
#######################################################################################
if (version_compare(PHP_VERSION, '5.1.0', '>=')) {//PHP5.1.0以上の場合のみタイムゾーンを定義
	date_default_timezone_set('Asia/Tokyo');//タイムゾーンの設定（日本以外の場合には適宜設定ください）
}
//----------------------------------------------------------------------
// 　必須設定項目 (START)
//----------------------------------------------------------------------

//■管理画面ログイン用パスワード　※必ず変更してください。

$userid[]   = 'admin';   // ユーザーID
$password[] = '1397';   // パスワード

//----------------------------------------------------------------------
// 　必須設定項目 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　任意設定（必要に応じて設定してください） (START)
//----------------------------------------------------------------------

//■登録可能数上限　この値を超えた場合、古いものから消えていきます。負荷を考慮し、ある程度上限を設けていたほうが無難です。無制限にもできますが。
$max_line = 500;
//■無制限にする場合は下記のコメント「//」（スラッシュ2つ）を外して（有効化）ください。
//$max_line = ''; 

//■表示件数（ニュースの表示数）※スマホ、携帯ではファイルで直接指定しています。管理画面はもちろん全件表示されます
$news_dsp_count = 100;

//■管理画面で編集や投稿時にページ上部にメッセージ（登録しました、更新しました等）を表示する（0=しない、1=する）
//※パーミッション未設定時にも表示されるので初めは表示にしててください
$messe_manage = 1;

//■詳細にURLだけを記述した場合はそのURLに直接リンクする（0=しない、1=する）
//※特定のページに飛ばしたいだけの場合に便利。詳細がURLだけの場合のみ設定されます。
$page_link = 1;

//■管理画面の本文（エディタ）の背景色（既存のHPに合わせると投稿結果が分かりやすいです）
$editorBackColor = '#ffffff';

//■管理画面の本文（エディタ）のデフォルト文字色（既存のHPに合わせると投稿結果が分かりやすいです）
$editorFontColor = '#333333';

/* 以下画像処理にはGDライブラリが必要です。※たいていのサーバーであれば入っていますが無い場合はこのプログラムは使えません */

//■画像アップ時に自動縮小後の画像の幅、または高さ（横写真は横、縦写真は縦。単位はpx）。
//※アップ画像が以下より大きければ縮小処理を行います。逆にそれ以下の場合は縮小処理せずそのまま保存、表示します。
$imgWidthHeight = 400;

//■画像アップ時のJPGの画質（0～100）※jpg時のみ　数値が大きいほど→画質良→ファイルサイズ大となる
$img_quality = 80;

//■データファイルのバックアップを作成する（0=しない、1=する）
//※新規投稿時にだけ「Backup_日時分秒.dat」のファイル名で保存されます。古いものは自動で削除。下記で期間指定。
//ファイル自体はそれほど大きくはありませんが、サーバー容量に不安がある場合は「しない」にしてください。
//バックアップファイルを使用する場合は「news.dat」にリネームしてお使いください。
$backup_copy = 0;

//■バックアップファイルを現在から何ヶ月前まで保存するか（月を1～12で指定。デフォルトは3ヶ月前まで保存）※上記で「1」を指定した場合のみ
$del_month = 3;

//■バックアップファイルをメールで送信する（0=しない、1=する）※新規投稿時のみ
//万が一サーバーのデータファイルが消えてしまったなどの状況に備えたオプション機能です
$backup_mail = 0;

//■バックアップファイルを送信するメールアドレス（上記で「1」を選択の場合のみ）※「,」区切りで複数可
$backup_mail_address = 'xxxxxx@xxxx.xxx';

//■日付の表示形式　（0=「例 2013/7/1」、1=「例 2013/07/01」） ※月と日の1桁時に0埋めをするかどうか
$date_detail = 1;

//■日付の区切り文字　20○○/○○/○○の「/」部分です。※半角のみ
$delimiter_text = '/';

//■日付を○年○月○日と表示する（0=しない、1=する）※有効にすると上記区切り文字は無効になります。
$up_ymd_japanese = 0;

//■アップ画像の最大サイズ※単位はバイト　
//※デフォルトは5MB（ただしサーバーのphp.iniの設定による。上限2MBの場合有り。変更可 ※サーバマニュアル等参考）
$maxImgSize = 5024000;

//■MAXアップファイル数 ※サーバー側の容量制限などもあるので多くとも5枚程度が無難です。
//表示側にも影響しますのでなるべく途中では変更しないでください。増やすのはOKですが、減らさないでください。
$photo_count = 3;

//■NEWマークを表示する（0=しない、1=する）
$new_mark_dsp = 1;

//■NEWマークを表示する期間（単位は日）※1，10、60などと指定ください
//たとえば2013/7/21に投稿し「2」に設定した場合、2013/7/24の00：00に非表示となります（23日23：59まで表示する）
$new_mark_days = 5;

//----------------------------------------------------------------------
// 　任意設定（必要に応じて設定してください） (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
// 　変数定義,初期化(START)　※基本的に変更不可（日本語、htmlタグ部分は可）
//----------------------------------------------------------------------
$file_path = 'data/news.dat';//データファイルのパス
$img_updir = "upimg";//画像の保存先を指定
$extensionTypeList = array('jpg','gif','png');
$perm_check01= "データ保存用の<strong>{$file_path}</strong>が書き込みできません。<strong>{$file_path}</strong>のパーミッションを「666」等書き込み可能なものに変更し、<br />パーミッションチェックしてみてください。<a href=\"admin.php?check=permission\">[変更したのでパーミッションチェックしてみる⇒]</a>";
$perm_check02= "画像保存先のパーミッションが正しくありません。<br /><strong>{$img_updir}</strong>ディレクトリに書き込み可能なパーミッション（777等またはサーバのマニュアルなどを参照）を設定してください。<br /><a href=\"admin.php?check=permission\">[変更したのでパーミッションチェックしてみる⇒]</a>";
$perm_check03= "パーミッションOK！投稿してみてください。<a href=\"admin.php\">これを非表示にする</a>";

$backup_comp = "<br>バックアップコピー失敗！<strong>data</strong>ディレクトリを書き込み可能なパーミッション（パーミッション707 or 777等）に変更し、<br>ページを更新して再度投稿してみてください。config.phpにてバックアップを無効にすることもできます。<a href=\"admin.php\">[ページを更新する⇒]</a>";
//説明文（新規、編集で2箇所で使うため変数にセット。詳細本文の文言変更の際はここを）
$detailText = <<<EOM
<p>詳細本文<br />
<span id="acrbtn" style="color:#36f;cursor:pointer;line-height:150%;font-size:13px;text-decoration:underline;">【注意事項、及び操作方法（はじめに必ずご確認下さい】</span>
<span id="commentDescription" style="display:none">
・詳細を記述すれば自動的にこちらへのリンク（ポップアップ）が張られます。<font color="red">※画像アップ時は本文が必須です</font><br />
・文字色や文字サイズ、センタリングや左右寄せ、リンク設定などが可能です。※アイコンを参照ください。カーソルを合わせると注釈が出ます。<br />
・特定のページに直接リンクさせたい場合は一番右側のアイコン（HTML編集モード）を押してからhttpから始まるURLのみを記述します。<br />
　<font color="red">その場合、URL以外（改行、空白含む）は含めないでください。</font><br />
・HTMLタグを使用したい場合も一番右側のアイコンを押してください。<br />
・カンマ「,」は使用不可、シングルクーテーション「’」は全角に変換されます。段落はEnter、改行はShift+Enterです。<br />
・Wordなどのテキストをそのままコピペするとうまく表示できないことがあります。一度メモ帳に貼り付けてからコピペください。<br />
・推奨ブラウザ：IE（8以上）、Firefox、GoogleChrome
</span>
</p>
EOM;
$warningMesse = '<center>著作権表記がありません。削除するには著作権表記削除料金（\2,000）のお支払いが必要です。<br />削除ご希望の際は下記アドレスまでご連絡をお願いします。<br />info@php-factory.net</center>';

//初期化
$extension_error = "";
$messe = "";
$end_flag = "";
$new_mark = "";
$copyright ="";
$img_file_path_array = array();
$backup_gen_res = "";
//----------------------------------------------------------------------
// 　変数定義,初期化 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
// 　関数定義 (START)　※基本的に変更不可（日本語、htmlタグ部分は可）
//----------------------------------------------------------------------

//ニュースリストの並び順（日付順）管理画面用
function newsListSort($lines){
	$jj = 0;
	$index=array();
	$index2=array();
	foreach($lines as $val){
	$lines_array = explode(",",$val);
	$index[] = @strtotime($lines_array[1]);
	$index2[] = $jj++;
	}
	@array_multisort($index,SORT_DESC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$lines);
	return $lines;
}
//ニュースリストの並び順（日付順）ユーザ閲覧ページ用
function newsListSortUser($lines,$encodingType = 'UTF-8'){
	$linesTempArray=array();
	$index=array();
	$index2=array();
	$linesArrayEncoding=array();
	$jj = 0;
	foreach($lines as $lineVal){
	  if(strpos($lineVal, 'no_disp')===false){
		  $linesTempArray[] = $lineVal;
	  }
	}
	foreach($linesTempArray as $val){
		$lines_array = explode(",",$val);
		$index[] = strtotime($lines_array[1]);
		$index2[] = $jj++;
	}
	
	if($encodingType != 'UTF-8'){
		foreach($linesTempArray as $lineVal){
			$linesArrayEncoding[] = mb_convert_encoding($lineVal,$encodingType,'UTF-8');
		}
		array_multisort($index,SORT_DESC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$linesArrayEncoding);
		return $linesArrayEncoding;
	}else{
		array_multisort($index,SORT_DESC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$linesTempArray);
		return $linesTempArray;
	}
}
//タイトルフォーマットの適用
function title_format($str,$str2,$str3,$post_path = './popup.php',$device = 'pc'){
	global $page_link;
	if(empty($str)){
		$title = $str2;
	}elseif($page_link == 1 && preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str)){
		$title = "<a href=\"{$str}\" target=\"_parent\">".$str2."</a>";//詳細にURLだけを記述した場合はそのURLに直接リンクする
	}elseif($device == 'pc'){//PC
		$title = "<a href=\"javascript:openwin('{$post_path}?id={$str3}')\">".$str2."</a>";
	}elseif($device == 'sp'){//スマホ
		$title = "<a href=\"{$post_path}?id={$str3}\">".$str2."</a>";
	}elseif($device == 'mb'){//携帯
		$title = "<a href=\"{$post_path}?id={$str3}\">".$str2."</a>";
	}
	return $title;
}

//バックアップ生成
function backup_gen($file_path){
	global $backup_comp;
	$backup_file_name = 'data/'.'Backup_'.date('YmdHis') .'.dat';
	if(!@copy($file_path,$backup_file_name)){
		return $backup_comp;
	}else{
		@chmod($backup_file_name, 0666);
	}
}
//バックアップ削除
function backup_del($file_path){
	global $del_month;
	$res_dir = @opendir( 'data' );//ディレクトリ・ハンドルをオープン
	$main_file = 'news.dat';
	//ディレクトリ内のファイル名を取得
	while( $file_name = @readdir( $res_dir ) ){
		//取得したファイル名を表示
		$file_name2 = str_replace(array('Backup_','.dat'),'',$file_name);
		//指定日以前のファイルを削除
		if($file_name2 < @date("YmdHis",strtotime("-{$del_month} month")) && $file_name != $main_file){
				$file_dir = str_replace($main_file,'',$file_path);
				@unlink("{$file_dir}{$file_name}");
		}
	}
	closedir( $res_dir );
}

//バックアップファイルのメール送信
function backup_mail($file_path,$title,$comment,$img_file_path_array){
	global $backup_mail,$backup_mail_address;
	mb_language("Ja") ;
	mb_internal_encoding("utf-8");
	
	//メール件名
	$subject = "ニュースプログラムに新規書き込みがありました。";
	
	$body  = "--__PHPFACTORY__\r\n";
	$body .= "Content-Type: text/plain; charset=\"ISO-2022-JP\"\r\n";
	$body .= "\r\n";
	$body.="ニュースプログラムに新規書き込みがありました。\r\n最新のデータファイルをバックアップ用として添付しました。\n万が一サーバ上のデータファイルが消えた場合はこちらのファイルで復旧できます。\n※このメールは設定ファイルで送信しないよう変更可能です。\n※このファイルを開く場合、メモ帳は厳禁です。必ずUTF-8に対応したエディタで開いて下さい。（TeraPad、DW等）\n※このメールの本文は文字装飾を解除したものになります。\n\n";
	$body.="＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
	$body.= "【タイトル】\n".$title."\n\n";
	$comment = str_replace(array('<br />','<br>'),"\n",$comment);
	$comment = strip_tags($comment);
	$body.= "【本文】\n".$comment."\n\n";
	if(count($img_file_path_array) > 0){
		$req_dir = str_replace('admin.php','',$_SERVER["REQUEST_URI"]);
		foreach($img_file_path_array as $key => $val){
			$key++;
			$body.= "【画像{$key}】\n"."http://" . $_SERVER["HTTP_HOST"] . $req_dir.$val."\n";
		}
	}else{
	$body.= "【画像なし】\n";
	}
	$body.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
	$body.="投稿された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
	$body.="投稿者のIPアドレス：".$_SERVER["REMOTE_ADDR"]."\n";
	$body.="投稿者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
	$body.="投稿ページのURL："."http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]."\n";
	$body .= "--__PHPFACTORY__\r\n";
	
	# 添付ファイルへの処理をします。
	$handle = @fopen($file_path, 'r');
	$attachFile = @fread($handle, filesize($file_path));
	@fclose($handle);
	$attachEncode = base64_encode($attachFile);
	$file_name = 'news.dat';
	$body .= "Content-Type: application/octet-stream; name=\"$file_path\"\r\n";
	$body .= "Content-Transfer-Encoding: base64\r\n";
	$body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
	$body .= "\r\n";
	$body .= chunk_split($attachEncode) . "\r\n";
	$body .= "--__PHPFACTORY__--\r\n";
	
	$header="From: $backup_mail_address\nReply-To: ".$backup_mail_address."\n";
	$header .= "MIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"__PHPFACTORY__\"\r\n";
	
		if (ini_get('safe_mode')) {
		  $result = @mb_send_mail($backup_mail_address,$subject,$body,$header);
		} else {
		  $result = @mb_send_mail($backup_mail_address,$subject,$body,$header,'-f'. $backup_mail_address);
		}
		return $result;
}
//NULLバイト除去//
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//

//日付フォーマットの処理
function ymd2format($str,$encodingType = 'UTF-8'){
	global $up_ymd_japanese,$delimiter_text,$date_detail;
	$ymd_text = array();
	if($date_detail == 0){
		$str = date('Y/n/j',strtotime($str));
	}
    $up_ymd = explode('/',$str);
	
	if($up_ymd_japanese == 1){
		
		$ymd_text_array = array('年','月','日');
		
		if($encodingType != 'UTF-8'){
			foreach($ymd_text_array as $ymdVal){
				$ymd_text[] = mb_convert_encoding($ymdVal,$encodingType,'UTF-8');
			}
			$res = $up_ymd[0].$ymd_text[0].$up_ymd[1].$ymd_text[1].$up_ymd[2].$ymd_text[2];
		}else{
			$res = $up_ymd[0].$ymd_text_array[0].$up_ymd[1].$ymd_text_array[1].$up_ymd[2].$ymd_text_array[2];
		}

	}else{
		$res = $up_ymd[0].$delimiter_text.$up_ymd[1].$delimiter_text.$up_ymd[2];
	}
	return $res;
}
//NEWマーク表示処理
function new_mark_func($str,$str2){
	global $new_mark_days,$new_mark_dsp;
	$now = strtotime(date('Y/m/d'));
	$set_time = strtotime("{$str} +{$new_mark_days} day");
	if($new_mark_dsp == 1 && $now <= $set_time){
		$new_mark = $str2;
		return $new_mark;
	}
}
function copyright_dsp($encodingType,$copyright){
	if($encodingType!='UTF-8') $copyright = mb_convert_encoding($copyright,$encodingType,'UTF-8');
	return $copyright;
}
//----------------------------------------------------------------------
// 　関数定義 (END)
//----------------------------------------------------------------------
require_once(dirname(__FILE__).'/copy.inc');
?>