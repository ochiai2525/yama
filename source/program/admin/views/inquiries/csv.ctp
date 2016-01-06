<?php
	// 表示項目名
	$out_line = array();
	foreach ($column_list as $id => $name) {
		$out_line[] = $name;
	}
	$csv->addRow($out_line);

	foreach ($data as $line) {
		$out_line = array();
		foreach (array_values($field_list) as $key) {
			switch ($key) {
			case 'inquiry_type':
				$line['Inquiry'][$key] = $inquiry_type_list[$line['Inquiry'][$key]];
				break;
			case 'answer_status':
				if (isset($inquiry_answer_status_list[$line['Inquiry'][$key]])) {
					$line['Inquiry'][$key] = $inquiry_answer_status_list[$line['Inquiry'][$key]];
				} else {
					$line['Inquiry'][$key] = '';
				}
				break;
			case 'rank':
				if (isset($inquiry_rank_list[$line['Inquiry'][$key]])) {
					$line['Inquiry'][$key] = $inquiry_rank_list[$line['Inquiry'][$key]];
				} else {
					$line['Inquiry'][$key] = '';
				}
				break;
			case 'body':
				// コメントの改行等削除
				$line['Inquiry'][$key] = preg_replace('/[\n\r\t]+/', '', $line['Inquiry'][$key]);
				break;
			}
			$out_line[] = $line['Inquiry'][$key];
		}
		$csv->addRow($out_line);
	}

	echo $csv->render($csv_file, 'SJIS-win', 'UTF-8');
?>
