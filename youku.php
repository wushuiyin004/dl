<?php
	$id = $_GET['id'];
	$bstrURL = 'https://acs.youku.com/h5/mtop.youku.live.com.livefullinfo/1.0/?appKey=24679788';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $bstrURL);	
	curl_setopt($ch, CURLOPT_HEADER, true); 	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0" );
	$data = curl_exec($ch);
	$headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($data, 0, $headerSize);
	curl_close($ch);
	
	preg_match_all('/_m_h5_tk=(.*?)_/',$header,$result);
	$h5_token = ($result[1][0]);
	
	preg_match('/_m_h5_tk=.*?;/',$header,$tk1);
	preg_match('/_m_h5_tk_enc=.*?;/',$header,$tk2);
	
	$cookies = $tk1[0].$tk2[0];
	
	$data = array("liveId"=>intval($id),"app"=>"Pc");
	$data = json_encode($data);

	$tt = time() ;
	$sign =md5( $h5_token.'&'.$tt.'&24679788&'.$data);
	$bstrURL = $bstrURL.'&t='.$tt.'&sign='.$sign.'&data='.urlencode($data);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $bstrURL);	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Cookie:'.$cookies));
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0" );
	$data = curl_exec($ch);
	curl_close($ch);
	$obj = json_decode($data);
	
	$sStreamName = $obj->data->data->stream[0]->streamName;
	$bstrURL = 'http://lvo-live.youku.com/vod2live/'.$sStreamName.'_mp4hd2v3.m3u8?&expire=21600&psid=1&ups_ts='.time().'&vkey=';
	header('location:'.$bstrURL);

?>