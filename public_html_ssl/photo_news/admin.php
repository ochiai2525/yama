<?php 
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
##
#######################################################################################

//----------------------------------------------------------------------
//  ログイン処理 (START)
//----------------------------------------------------------------------
session_start();
header("Content-Type: text/html;charset=UTF-8");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

#設定ファイルインクルード
include_once("config.php");
$img_updir = "upimg";//画像の保存先を指定
if(isset($_GET['logout'])){
$_SESSION = array();
# セッションを破棄
session_destroy();
}
$error = '';
# セッション変数を初期化
if (!isset($_SESSION['auth'])) {
  $_SESSION['auth'] = FALSE;
}
if (isset($_POST['userid']) && isset($_POST['password'])){
  foreach ($userid as $key => $value) {
    if ($_POST['userid'] === $userid[$key] &&
        $_POST['password'] === $password[$key]) {
      $oldSid = session_id();
      session_regenerate_id(TRUE);
      if (version_compare(PHP_VERSION, '5.1.0', '<')) {
        $path = session_save_path() != '' ? session_save_path() : '/tmp';
        $oldSessionFile = $path . '/sess_' . $oldSid;
        if (file_exists($oldSessionFile)) {
          unlink($oldSessionFile);
        }
      }
      $_SESSION['auth'] = TRUE;
      break;
    }
  }
  if ($_SESSION['auth'] === FALSE) {
    $error = '<center><font color="red">ユーザーIDかパスワードに誤りがあります。</font></center>';
  }
}
if ($_SESSION['auth'] !== TRUE) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新着情報、お知らせ管理画面</title>
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body id="auth">
<?php echo $error;?>
 <div id="login_form">

 <p class="taC">管理画面に入場するにはログインする必要があります。<br />管理者以外の入場は固くお断りします。</p>
<form action="admin.php" method="post">
<label for="userid">ユーザーID</label>
<input class="input" type="text" name="userid" id="userid" value="" style="ime-mode:disabled" />
<label for="password">パスワード</label>      
<input class="input" type="password" name="password" id="password" value="" size="30" />
<p class="taC">
<input class="button-primary" type="submit" name="login_submit" value="　ログイン　" />
</p>
</form>
</div>
</body>
</html>
<?php
exit();
}

//----------------------------------------------------------------------
//  ログイン処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  データ保存用ファイルのパーミッションチェック (START)
//----------------------------------------------------------------------

if (!is_writable($file_path)){
	$messe = $perm_check01;
}elseif(!@is_writable($img_updir)){
	$messe = $perm_check02;
}elseif(@$_GET['check']=='permission'){
	$messe = $perm_check03;
}

//----------------------------------------------------------------------
//  データ保存用ファイルのパーミッションチェック (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  書き込み・編集処理 (START)
//----------------------------------------------------------------------
if ((isset($_POST['submit']) || isset($_POST['edit_submit'])) && !isset($_POST['del'])){
  if(empty($_POST['title'])){
		$messe= "タイトルが空です";
  }else{
  $up_ymd=mb_convert_kana($_POST['year'], 'n',"UTF-8").'/'.mb_convert_kana($_POST['month'], 'n',"UTF-8").'/'.mb_convert_kana($_POST['day'], 'n',"UTF-8");
  $up_ymd = date('Y/m/d',strtotime($up_ymd));//登録日付フォーマットを統一
  if(isset($_POST['comment'])){
	$comment = str_replace(array("\n","\r",","),"",$_POST['comment']);
	$comment = str_replace("'","’","$comment");
	$comment = str_replace("&nbsp;"," ","$comment");
	if (get_magic_quotes_gpc()) $comment = stripslashes($comment); 
	}
  $title=str_replace(",","、",htmlspecialchars($_POST['title'],ENT_QUOTES,'utf-8'));
  $lines = file($file_path);
  
  //各記事にユニークなIDを付与　uniqid（PHP3以下）が無ければ年月日時分秒
  if(isset($_POST['edit_submit'])){ 
		$id = $_POST['id'];
  }elseif(function_exists('uniqid') && function_exists('mt_rand')){//PHP4以上
		$id = uniqid(mt_rand(10000,99999));//マイクロタイムにランダム接頭辞を追加（重複防止）
  }else{
		$id = @date("YmdHis");
  }
  
  $fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
  $news_data = $id  . "," .$up_ymd. "," .$title  ."," .$comment  . "\n";
    // 俳他的ロック
    if (flock($fp, LOCK_EX)) {
		ftruncate($fp,0);
		rewind($fp);
        // 書き込み
        if (isset($_POST['submit'])){
		fwrite($fp, $news_data);
		$messe= "【".$title."】を登録しました。";
		if ($max_line!='') $max_line --;
		}
        if ($max_line!='' and count($lines) > $max_line) {
            $max_i = $max_line;
        } else {
            $max_i = count($lines);
        }
        for ($i = 0; $i < $max_i; $i++) {
        if (isset($_POST['edit_submit'])){
			$lines_array[$i] = explode(",",$lines[$i]);
			if($lines_array[$i][0] != $id){
				 fwrite($fp, $lines[$i]);
			}else{
				fwrite($fp, $news_data);
				$messe= "編集処理完了しました！ ";
			}
		}else{			
            fwrite($fp, $lines[$i]);
		}
    }
  }@fclose($fp);
  
	//画像削除
	if(strpos($id,'no_disp')!==false) $tempid = str_replace('no_disp','',$id); else $tempid =$id;
	for($i=0;$i<$photo_count;$i++){
		if(isset($_POST['img_del'][$i]) && $_POST['img_del'][$i] == "true") {
		  foreach($extensionTypeList as $extensionVal){
		    if(file_exists("{$img_updir}/{$tempid}_{$i}.{$extensionVal}")) if(!unlink("{$img_updir}/{$tempid}_{$i}.{$extensionVal}")) $messe .= '画像削除失敗です。手動で削除ください。';
		  }
			$messe .= "画像を削除しました！";
		}
	}
	  
	//画像縮小保存処理 GD必須
	$count_upload = count($_FILES["upfile"]["tmp_name"]);
	for($i=0;$i < $count_upload;$i++){
		$photoNumber=$i+1;
		if (is_uploaded_file($_FILES["upfile"]["tmp_name"][$i])) {
		  if ($_FILES["upfile"]["size"][$i] < $maxImgSize) {
			  
			$extension_error = '';
			$imgType = $_FILES['upfile']['type'][$i];
			$extension = '';
			if ($imgType == 'image/gif') {
			  $extension = 'gif';
			  $image = ImageCreateFromGIF($_FILES['upfile']['tmp_name'][$i]); //GIFファイルを読み込む
			} else if ($imgType == 'image/png' || $imgType == 'image/x-png') {
			  $extension = 'png';
			  $image = ImageCreateFromPNG($_FILES['upfile']['tmp_name'][$i]); //PNGファイルを読み込む
			} else if ($imgType == 'image/jpeg' || $imgType == 'image/pjpeg') {
			  $extension = 'jpg';
			  $image = ImageCreateFromJPEG($_FILES['upfile']['tmp_name'][$i]); //JPEGファイルを読み込む
			} else if ($extension == '') {
			  $extension_error = '許可されていない拡張子です<br />';
			}
			if($extension_error == ''){
			  if(strpos($id,'no_disp')!==false) $tempid = str_replace('no_disp','',$id); else $tempid =$id;
			  $filename = $tempid."_".$i.".".$extension;//ファイル名を指定
			  $img_file_path = $img_updir.'/'.$filename;//ファイルパスを指定
			  //読み込んだ画像のサイズ
			  $width = ImageSX($image); //横幅（ピクセル）
			  $height = ImageSY($image); //縦幅（ピクセル）
			  if($width>$imgWidthHeight or $height>$imgWidthHeight){//画像の縦または横が$imgWidthHeightより大きい場合は縮小して保存
				  if ($height < $width){//横写真の場合の処理
				  $new_width = $imgWidthHeight; //幅指定px
				  $rate = $new_width / $width; //縦横比を算出
				  $new_height = $rate * $height;
				  }else{//縦写真の場合の処理
				  $new_height = $imgWidthHeight; //高さ指定px
				  $rate = $new_height / $height; //縦横比を算出
				  $new_width = $rate * $width;
				  }
				  $new_image = ImageCreateTrueColor($new_width, $new_height);
				  ImageCopyResampled($new_image,$image,0,0,0,0,$new_width,$new_height,$width,$height);
				  if($imgType == 'image/jpeg' || $imgType == 'image/pjpeg'){
					if(!@is_int($img_quality)) $img_quality = 80;
				  ImageJPEG($new_image, $img_file_path, $img_quality); //3つ目の引数はクオリティー（0～100）
				  }
				  if ($imgType == 'image/gif') {
				  ImageGIF($new_image, $img_file_path);//環境によっては使えない
				  }
				  if ($imgType == 'image/png' || $imgType == 'image/x-png') {
				  ImagePNG($new_image, $img_file_path);
				  }
				  //メモリを解放
				  imagedestroy($image); //サムネイル用イメージIDの破棄
				  imagedestroy($new_image); //サムネイル元イメージIDの破棄
			  
			  }else{//画像が$imgWidthHeightより小さい場合はそのまま保存
				  move_uploaded_file($_FILES['upfile']['tmp_name'][$i],$img_file_path);
			  }
			  @chmod($img_file_path, 0666);
			  $messe .= "<br>【写真{$photoNumber}を登録しました】";
			  $img_file_path_array[] = $img_file_path;
			}
		  }else{
				$maxImgSize = number_format($maxImgSize);
				$messe .= "<br>【写真{$photoNumber}がファイルサイズオーバーです{$maxImgSize}バイト以下にして下さい】";
		  }
		}
	}
	
	
	//バックアップ作成と削除
	if($backup_copy=='1' && !isset($_POST['edit_submit'])){
		$messe .= backup_gen($file_path);//バックアップ作成
		$backup_del_res = backup_del($file_path);//指定月以前のバックアップファイルの削除
	}
	//バックアップファイルをメールで添付送信する
	if($backup_mail == 1 && !empty($backup_mail_address) && !isset($_POST['edit_submit'])){
		if(!backup_mail($file_path,$title,$comment,$img_file_path_array)) $messe .= '【メール送信失敗】'; 
	}
  }
}
//----------------------------------------------------------------------
//  書き込み・編集処理 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  データ削除処理 (START)
//----------------------------------------------------------------------
	if(isset($_POST['del'])){
	$id=$_POST['id'];
	$lines = file($file_path);
	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
	  if (flock($fp, LOCK_EX)) {
		  ftruncate($fp,0);
		  rewind($fp);
		  if ($max_line!='' and count($lines) > $max_line) {
			  $max_i = $max_line;
		  } else {
			  $max_i = count($lines);
		  }
		  for ($i = 0; $i < $max_i; $i++) {
			  $lines_array[$i] = explode(",",$lines[$i]);
			  if($lines_array[$i][0] != $id){
				   fwrite($fp, $lines[$i]);
			  }else{
				  $lines[$i] = '';
				  fwrite($fp, $lines[$i]);
			  }
		  }
	  }
	@fclose($fp);
		//アップ画像も削除
		$messe = "";
		  if(strpos($id,'no_disp')!==false) $tempid = str_replace('no_disp','',$id); else $tempid =$id;
		  for($i=0;$i<$photo_count;$i++){
			foreach($extensionTypeList as $extensionVal){
				if(file_exists("{$img_updir}/{$tempid}_{$i}.{$extensionVal}")) if(!unlink("{$img_updir}/{$tempid}_{$i}.{$extensionVal}")) $messe = '画像削除失敗です。手動で削除ください。';
			}
		  }
	$messe .= "指定行削除完了しました！ ";
	}
//----------------------------------------------------------------------
//  データ削除処理 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  再表示処理 非表示処理 (START)
//----------------------------------------------------------------------
    $mode=htmlspecialchars(@$_GET['mode'],ENT_QUOTES,'utf-8');
	if($mode=='disp' or $mode=='no_disp'){
	$id=$_GET['id'];
	$lines = file($file_path);
	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
    if (flock($fp, LOCK_EX)) {
		ftruncate($fp,0);
		rewind($fp);
      if ($max_line!='' and count($lines) > $max_line) {
          $max_i = $max_line;
      } else {
          $max_i = count($lines);
      }
	  for ($i = 0; $i < $max_i; $i++) {
		$lines_array[$i] = explode(",",$lines[$i]);
		if($lines_array[$i][0]!= $id){
			 fwrite($fp, $lines[$i]);
		}else{
			if($mode=='disp'){//表示処理
			$lines[$i] = str_replace("no_disp","","$lines[$i]");
			$messe= "表示処理完了しました！ ";
			}else if($mode=='no_disp'){//非表示処理
			$messe= "非表示処理完了しました！ ";
			$lines[$i] ="no_disp".$lines[$i];
			}
		   fwrite($fp, $lines[$i]);
		}
	  }
    }
  @fclose($fp);
}
//----------------------------------------------------------------------
//  再表示処理 非表示処理 (END)
//----------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
<title>新着情報 管理画面</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Expires" content="Thu, 01 Dec 1994 16:00:00 GMT">
<link rel="stylesheet" type="text/css" href="editor/cleditor.css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="editor/cleditor.js"></script>
<script type="text/javascript">
$(function() {
      $("#comment").cleditor({
        width:        820, // width not including margins, borders or padding
        height:       250, // height not including margins, borders or padding
        controls:     // controls to add to the toolbar
                    "bold italic underline strikethrough | size " +
                    "color removeformat | bullets numbering | " +
                    "alignleft center alignright | undo redo | " +
                    "rule link unlink | source",
        colors:       // colors in the color popup
          "FFF FCC FC9 FF9 FFC 9F9 9FF CFF CCF FCF " +
          "CCC F66 F96 FF6 FF3 6F9 3FF 6FF 99F F9F " +
          "BBB F00 F90 FC6 FF0 3F3 6CC 3CF 66C C6C " +
          "999 C00 F60 FC3 FC0 3C0 0CC 36F 63F C3C " +
          "666 900 C60 C93 990 090 399 33F 60C 939 " +
          "333 600 930 963 660 060 366 009 339 636 " +
          "000 300 630 633 330 030 033 006 309 303",
        fonts:        // font names in the font popup
          "",
        sizes:        // sizes in the font size popup
          "1,2,3,4,5,6,7",
        styles:       // styles in the style popup
          [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
            ["Header 3", "<h3>"],  ["Header 4","<h4>"],  ["Header 5","<h5>"],
            ["Header 6","<h6>"]],
        useCSS:       false, // use CSS to style HTML when possible (not supported in ie)
        docType:      // Document type contained within the editor
          '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
        docCSSFile:   // CSS file used to style the document contained within the editor
          "",
        bodyStyle:    // style to assign to document body contained within the editor
          "margin:4px; font-size:10pt; cursor:text;background:<?php echo $editorBackColor;?>;color:<?php echo $editorFontColor;?>;"
      });
    });    

$(function(){
    $("#acrbtn").click(function () {
      $("#commentDescription").toggle("normal");
	  
    });
  });
</script>
<script type="text/javascript">
function check(){
	if(document.news_form.title.value == ""){
		window.alert('タイトルを入力してください');
		return false;
	}else{
		return true;
	}
}
//ポップアップ用JS
function openwin(url) {
 wn = window.open(url, 'win','width=520,height=500,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no,left=50,top=50');wn.focus();
}
</script>
</head>
<body id="news_admin">
<div id="wrapper">
<?php if(!$copyright){echo $warningMesse; exit;}else{?>
<?php if($extension_error !='') echo "<p class=\"fc_red message_com\">{$extension_error}</p>"; ?>
  <?php if(!empty($messe) && $messe_manage == '1') echo "<p class=\"fc_red message_com\">{$messe}　<a href=\"admin.php\">メッセージを非表示</a></p>"; ?>
  <div class="logout_btn"><a href="?logout=true">ログアウト</a></div>
  <h1>新着情報・お知らせ 管理画面</h1>
  <p>※並び順は日付順です。日付が同じ場合、新しいものが上になります。<br />
※投稿から<?php echo $new_mark_days;?>日間は「NEW!」マークが付きます。</p>
<?php 
$lines = newsListSort(file($file_path));
$max_i = count($lines);
echo <<<EOF
<p id="countTotal">[ 登録数：{$max_i} ]</p>
EOF;
?>
<h2 class="m0">投稿一覧</h2>
<div id="news_wrap">
<ul id="news_list">
<?php
//----------------------------------------------------------------------
//  リスト表示処理 (START)
//----------------------------------------------------------------------

	 for ($i = 0; $i < $max_i; $i++){
	 $lines_array[$i] = explode(",",$lines[$i]);
	 $id=$lines_array[$i][0];
	 $ymd_format_before = $lines_array[$i][1];
	 $lines_array[$i][3] = rtrim($lines_array[$i][3]);
	 $lines_array[$i][1] = ymd2format($lines_array[$i][1]);//日付フォーマットの適用
		if(empty($lines_array[$i][3])){
			$title=	$lines_array[$i][2];
		//詳細にURLだけを記述した場合はそのURLに直接リンクする
		}else if ($page_link == 1 && @preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $lines_array[$i][3]) ) {
			$title=	"<a href=\"{$lines_array[$i][3]}\" target=\"_parent\">".$lines_array[$i][2]."</a>";
		}else{
			$title="<a class=\"iframe\" href=\"javascript:openwin('popup.php?id={$id}')\">".$lines_array[$i][2]."</a>";
		}
		//NEWマーク表示処理　※タグ部変更可。画像でももちOK（さらに下にある「{$new_mark}」を移動すれば表示場所を変えられます）
		if($new_mark = new_mark_func($ymd_format_before,'<span style="color:red" class="new_mark"> NEW !</span>'));
		
	if(strpos($lines[$i], 'no_disp')!==false){
//「非表示」の場合の表示
echo <<<EOF
<li class="fc_bbb"><span class="list_title"><span style="color:red;">非表示中</span> {$lines_array[$i][1]} {$title}{$new_mark}</span> ｜<a href="?mode=disp&id={$id}" class="button">表示</a> <a href="?mode=edit&id={$id}" class="button">編集・削除</a></li>
EOF;
	
	 }else{
//「表示」の場合の表示
echo <<<EOF
<li><span class="list_title">{$lines_array[$i][1]}  {$title}{$new_mark}</span>｜<a href="?mode=no_disp&id={$id}" class="button">非表示</a> <a href="?mode=edit&id={$id}" class="button">編集・削除</a></li>

EOF;
	 }
} 
//----------------------------------------------------------------------
//  リスト表示処理 (END)
//----------------------------------------------------------------------
?>
</ul>
</div>
<br />
  <h2>記事登録・編集フォーム</h2>

<form method="post" action="admin.php" enctype="multipart/form-data" name="news_form" onsubmit="return check()">
<?php 
//----------------------------------------------------------------------
// 　編集フォーム表示処理 (START)
//----------------------------------------------------------------------

if(isset($_GET['mode'])){
   $mode=htmlspecialchars($_GET['mode'],ENT_QUOTES,'utf-8');
}
if($mode=='edit'){
	$id=$_GET['id'];
    $lines = file($file_path);
    $max_i = count($lines);
 for ($i = 0; $i < $max_i; $i++){
	 $lines_array[$i] = explode(",",$lines[$i]);
	 if($lines_array[$i][0] == $id){
		$lines_array[$i][3] = rtrim($lines_array[$i][3]);
echo <<<EOM
<input type="hidden" name="id" value="{$id}" />

<p style="color:red;font-size:16px;">下記内容を編集後「変更」ボタンを押してください。<a href="admin.php">編集をキャンセル⇒</a></p>
<p>タイトル
<input type="text" size="50" name="title" value="{$lines_array[$i][2]}" style="width:370px" />
EOM;
	
	if($date_detail == 0) $lines_array[$i][1] = date('Y/n/j',strtotime($lines_array[$i][1]));//日付フォーマットを設定に合わせる
	$up_ymd_array[$i] = explode("/",$lines_array[$i][1]);
	 
echo <<<EOM
　日付 <input type="text" name="year" size="5" maxlength="4" value="{$up_ymd_array[$i][0]}" /> 年 <input type="text" name="month" size="2" maxlength="2" value="{$up_ymd_array[$i][1]}" /> 月 <input type="text" name="day" size="2" maxlength="2" value="{$up_ymd_array[$i][2]}" /> 日　※並び順にも使用します</p>

{$detailText}
<textarea name="comment" id="comment">{$lines_array[$i][3]}</textarea></p>
<p>削除チェック　<input type="checkbox" name="del" value="true" /> <span style="font-size:13px;color:#666">※削除する場合はこちらにチェックを入れて「変更」ボタンを押してください。データ（画像データ含む）は完全に削除されます。</p>
<table width="100%"><tr><td style="font-size:12px;padding:5px;" valign="top">
画像アップロード（jpg、gif、pngのみ　MAX5MB）<br />※横、縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red">{$imgWidthHeight}</span>px<br />
※画像を変更したのに変わっていない場合はブラウザのキャッシュが原因です。F5で更新してみてください。<br />
EOM;
for($upfile_i=1;$upfile_i<=$photo_count;$upfile_i++){
echo <<<EOM
写真{$upfile_i}：<input type="file" name="upfile[]" size="50" /><br />
EOM;
}
echo <<<EOM
</td>
<td>
<table width="100%">
EOM;
 	if(strpos($id,'no_disp')==0) $tempid = str_replace('no_disp','',$id);else $tempid=$id;
		for($photo_i=0;$photo_i<$photo_count;$photo_i++){$photo_no = $photo_i+1;
		$nonePhotoFlag = '';
		if($photo_no == 1 || $photo_no%3==1){
		echo "<tr>\n";
		}
		echo "<td valign=\"top\" style=\"font-size:11px;text-align:center;border:1px dotted #ccc;padding:5px;\" nowrap=\"nowrap\">現在の写真{$photo_no}<br />\n";
		  foreach($extensionTypeList as $extensionVal){
			if(file_exists("{$img_updir}/{$tempid}_{$photo_i}.{$extensionVal}")) {
				echo "<img src=\"{$img_updir}/{$tempid}_{$photo_i}.{$extensionVal}\" height=\"50\" vspace=2 /><br /><input type=\"checkbox\" name=\"img_del[$photo_i]\" value=\"true\" /> 削除する";
				$nonePhotoFlag = 1;
			}
		  }
		  if($nonePhotoFlag == '') echo '<br /><br />無し';
		  echo "</td>\n";
		  
		if($photo_no%3==0){
		  echo "</tr>\n";
		}
		}
echo <<<EOM
</table>
</td>
</tr></table></p>

<p align="center"><input type="submit" class="submit_btn" name="edit_submit" value="　変更、または削除実行　" style="margin-bottom:10px;" /><br />画像の容量が大きい場合、アップロードに時間がかかることがありますが、そのままでお待ちください。</p>
EOM;
break;	 }
	}
	
//----------------------------------------------------------------------
// 　編集フォーム表示処理 (END)
//----------------------------------------------------------------------
	
}else{
//----------------------------------------------------------------------
// 　新規登録フォーム表示処理 (START)
//----------------------------------------------------------------------
?>
<p>タイトル <input type="text" size="50" name="title" style="width:370px" />
　日付 <input type="text" name="year" size="5" maxlength="4" value="<?php echo @date("Y",time());?>" /> 年 <input type="text" name="month" size="2" maxlength="2" value="<?php if($date_detail == 1) echo @date("m",time()); else echo @date("n",time());?>" /> 月 <input type="text" name="day" size="2" maxlength="2" value="<?php if($date_detail == 1) echo @date("d",time()); else echo @date("j",time());?>" /> 日　※並び順にも使用します</p>
<?php echo $detailText;?>
<textarea name="comment" id="comment"></textarea></p>
<p>画像アップロード（jpg、gif、pngのみ　MAX 5MB）<br />
※横、縦写真とも設定ファイル（config.php）で設定した幅、または高さに自動縮小されます。現在は<span style="color:red"><?php echo $imgWidthHeight;?></span>px<br />

<?php
for($upfile_i=1;$upfile_i<=$photo_count;$upfile_i++){
echo <<<EOM
{$upfile_i}.<input type="file" name="upfile[]" size="50" /><br />
EOM;
}
?>
<p align="center"><input type="submit" class="submit_btn" name="submit" value="　新規登録　" style="margin-bottom:10px;" /><br />画像の容量が大きい場合、アップロードに時間がかかることがありますが、そのままでお待ちください。</p>
<?php
}
//----------------------------------------------------------------------
// 　新規登録フォーム表示処理 (END)
//----------------------------------------------------------------------

?>
</form>
<br />
<br />
<!-- 以下更新履歴は必要なければ削除可能です-->
<h2 style="font-size:14px;">更新履歴（不具合情報やバージョンアップ情報などがあればこちらに表示されます）</h2>
<iframe src="http://www.kens-web.com/php/photo_news/" width="98%" height="60" title="news" frameborder="0" scrolling="auto"></iframe>
<?php echo $copyright; }//著作権表記削除不可?>
</div>
</body>
</html>