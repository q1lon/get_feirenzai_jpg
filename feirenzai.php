<?php
$destination_folder = 'd:/feirenzai/';
print "ͼƬ�ļ���" . $destination_folder . "\n";
print "�������������ع��� V1 by zhq1lon \n";
set_time_limit(0);
ob_start();
$pregcode = "/http:\/\/mmbiz(.*)=jpeg/sU";//ͼƬ�ĵ�ַ
$pregurl='/http:\/\/mp(.*)#wechat_redirect/sU';//��վ�ĵ�ַ
$pregnum='/4444446563721px;">(.*)<\/strong>/sU';//��ȡ�ڼ���
$pregtitle='/<title>(.*)<\/title>/sU';//��ȡtitle
$sources=file_get_contents('http://mp.weixin.qq.com/mp/homepage?__biz=MzI3MjAyODk3Ng==&hid=1&sn=70ce505eced93d8875f68a4dfd550726#wechat_redirect');
preg_match_all($pregurl,$sources,$url);

foreach($url[0] as $val){
	$str=str_replace('amp;','',$val);
	$sourcespic=file_get_contents($str);
	preg_match_all($pregnum,$sourcespic,$urlnum);
	$num=iconv("utf-8", "gb2312",$urlnum[1][0]);
	preg_match_all($pregcode,$sourcespic,$urlcode);

	preg_match_all($pregtitle,$sourcespic,$urltitle);
	$title=iconv("utf-8", "gb2312",$urltitle[1][0]);

	foreach ($urlcode[0] as $key => $val) {
		if($key>2) continue;
		$newfname = $destination_folder . $num.'-'.$title.$key . '.jpg';

		$file = fopen($val, "rb");
		if ($file) {
			$newf = fopen($newfname, "wb");
			if ($newf)
				while (!feof($file)) {
					print "���ڱ��棺" . $newfname . '..' ;
					fwrite($newf, fread($file, 1024 * 8), 1024 * 8);

				}
		}
		if ($file) {
			fclose($file);
		}
		if ($newf) {
			fclose($newf);
		}
	}
}

