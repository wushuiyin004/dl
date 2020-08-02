<?php

	$id = $_GET['id'];
	$bstrURL = 'http://live.video.iqiyi.com';
	$ts = time().'000';
	
	$param = '/live?lp='.$id.'&lc=380719022&src=03020031010000000000&prioVers=1&rateVers=PUMA_2&k_ft1=4195328&k_ft2=0&k_ft4=262144&t='.$ts.'&k_uid=ad7vf4bcq5zjlq7ismb5qan25ldho75m&v=0&ut=0&k_ver=7.7.116.2047&ve=5f7d3885d02649bb30ae840e3690b166&k_err_retries=0&qd_v=1';
	$sign = md5($param.'h2l6suw16pbtikmotf0j79cej4n8uw13');
	$bstrURL = $bstrURL.$param.'&vf='.$sign;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $bstrURL);	 	 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	$data = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($data);
	foreach ($json->data->streams as $sline)
	{
		if($sline->streamFormat == 'TS' && $sline->steamType == 'RESOLUTION_1080P') 
		{
			$url = $sline->url;
			break;
		}
	}
	header ('location:'.$url);

?>