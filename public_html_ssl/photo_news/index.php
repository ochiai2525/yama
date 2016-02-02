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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>新着情報、お知らせ</title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript">
<!--
function openwin(url) {//PC用ポップアップ。ウインドウの幅、高さなど自由に編集できます
 wn = window.open(url, 'win','width=520,height=500,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no');wn.focus();
}
-->
</script>
</head>
<body id="news_index">
<?php
include_once("config.php");//設定ファイルインクルード
if(!$copyright){echo $warningMesse; exit;}else{?>
<div id="news_wrap">
<dl class="news">

<?php
//ファイルの内容を取得　表示
$lines = newsListSortUser(file($file_path));
foreach($lines as $key => $val){
	if($key >= $news_dsp_count) break;
	$lines_array = explode(",",$val);
	$upymd = ymd2format($lines_array[1]);//日付フォーマットの適用
	$lines_array[3] = rtrim($lines_array[3]);
	$title = title_format($lines_array[3],$lines_array[2],$lines_array[0]);//タイトルのフォーマットの適用
	
		//NEWマーク表示処理　※タグ部変更可。画像でももちOK（さらに下にある「{$new_mark}」を移動すれば表示場所を変えられます）
	if($new_mark = new_mark_func($lines_array[1],'<span style="color:red;font-size:75%;" class="new_mark"> NEW !</span>'));
		
//ブラウザ出力		
echo <<<EOF
<dt>{$upymd} {$new_mark}</dt><dd>{$title}</dd>



EOF;
}	
?>
</dl>
<?php echo $copyright; }//著作権表記削除不可?>
</div>
</body>
</html>