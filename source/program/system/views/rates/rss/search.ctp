<?php
$this->set('channel', array (
	'title'       => '相場情報 | 株式会社　山田為商店',
	'link'        => 'http://www.yamatame.com/',
	'description' => '山田為商店は電線、絶縁材料、加工品をトータルにご提供します。',
	'language'    => 'UTF-8',
));

echo $rss->items($data, 'transformRSS');

function transformRSS($data) {
	return array(
		'title'       => $data['Rates']['comment'],
		'pubDate'     => $data['Rates']['open_start_date'],
		//'title'       => '相場情報',
		//'description' => $data['Rates']['comment'],
		//'guid' => array('url' => $data['Rates']['id'], 'isPermaLink' => 'false'),
		//'guid'        => $data['Rates']['id'],
	);
}

?>