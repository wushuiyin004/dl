<?php
	$rid = $_GET['id'];
	$bstrURL = 'http://interface.yy.com/hls/new/get/'.$rid.'/'.$rid.'/1200?source=wapyy&callback=jsonp3';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $bstrURL);	 	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0" );
	curl_setopt($ch,CURLOPT_REFERER,'http://wap.yy.com/mobileweb/'.$rid);
	$data = curl_exec($ch);
	curl_close($ch);
	$n = preg_match('/hls":"(.*?)"/',$data,$result);
		
	header('location:'.$result[1]);
	
?>