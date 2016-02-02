<?php
//設定ファイルインクルード
include_once("config.php");
if(!$copyright){echo $warningMesse; exit;}else{
	if(!empty($_GET['id'])){
		$id=$_GET['id'];
	}else{
		exit('パラメータがありません');	
	}
	$lines = newsListSort(file($file_path));
	foreach($lines as $key => $val){
	$lines_array = explode(",",$val);
	  if($lines_array[0] == $id){
		  $end_flag = 1;
		  break;
	  }
	}
	if($end_flag != 1) exit('データ取得エラー');
$lines_array[3] = rtrim($lines_array[3]);
$lines_array[1] = ymd2format($lines_array[1]);//日付フォーマットの適用
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php	echo $lines_array[2];?></title>
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>   
<script type="text/javascript">
 $(document).ready( function () {
 $("#detailWrap a").attr("target","_blank");//本文内のaタグに_blankを付与 ※変更可
})
</script>
</head>
<body id="news_popup">
<?php
//ブラウザ出力（HTML部は編集可）
echo <<<EOF

<h2>{$lines_array[2]}</h2>
<p class="up_ymd">{$lines_array[1]}</p>
<div id="detailWrap">{$lines_array[3]}</div>

EOF;
if(strpos($id,'no_disp')!==false) $id = str_replace('no_disp','',$id);
  for($i=0;$i<$photo_count;$i++){
	foreach($extensionTypeList as $extensionVal){
	  if(file_exists("{$img_updir}/{$id}_{$i}.{$extensionVal}")) {
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<p id="photoNo{$i}" class="detailPhoto" align="center"><img src="{$img_updir}/{$id}_{$i}.{$extensionVal}" /></p>

EOF;
	  }

//------------------------------------------------------------------------------------------
// 旧バージョン互換用処理　(STSRT)
// ※旧バージョンのデータファイル（news.dat）を使用する場合にのみ処理するので最新版を新規で使う場合には削除可能です
// と言うよりも無駄な処理であり、若干ですが負荷もかかるので、できれば削除してください。
// アップ画像が複数になったことによりファイル名の命名規則が変わったためです。
//------------------------------------------------------------------------------------------
elseif(file_exists("{$img_updir}/{$id}.{$extensionVal}")) {
//ブラウザ出力（HTML部は編集可）
echo <<<EOF
<p class="detailPhoto" align="center"><img src="{$img_updir}/{$id}.{$extensionVal}" /></p>
EOF;
break(2);
}
//------------------------------------------------------------------------------------------
// 　旧バージョン互換用処理 (END)
//------------------------------------------------------------------------------------------

	}
  }
?>
<br />
<p class="close_btn"><a href="javascript:window.close();">CLOSE</a></p>
<?php echo $copyright;}//著作権表記無断削除不可?>
</body>
</html>