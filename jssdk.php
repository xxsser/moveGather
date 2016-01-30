<?php
class JSSDK {
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret) {
	$this->appId = $appId;
	$this->appSecret = $appSecret;
  }

  public function getSignPackage() {
	$jsapiTicket = $this->getJsApiTicket();
	$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$timestamp = time();
	$nonceStr = $this->createNonceStr();

	$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

	$signature = sha1($string);

	$signPackage = array(
	  "appId"     => $this->appId,
	  "nonceStr"  => $nonceStr,
	  "timestamp" => $timestamp,
	  "url"       => $url,
	  "signature" => $signature,
	  "rawString" => $string
	);
	return $signPackage;
  }

  private function createNonceStr($length = 16) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$str = "";
	for ($i = 0; $i < $length; $i++) {
	  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
  }

  private function getJsApiTicket() {
	$data = json_decode(file_get_contents("jsapi_ticket.json"));
	if ($data->expire_time < time()) {
	  $accessToken = $this->getAccessToken();
	  $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
	  $res = json_decode(file_get_contents($url));
	  $ticket = $res->ticket;
	  if ($ticket) {
		$data->expire_time = time() + 7000;
		$data->jsapi_ticket = $ticket;
		$fp = fopen("jsapi_ticket.json", "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
	  }
	} else {
	  $ticket = $data->jsapi_ticket;
	}

	return $ticket;
  }

  public function getAccessToken() {
	$data = json_decode(file_get_contents("access_token.json"));
	if ($data->expire_time < time()) {
	  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
	  $res = json_decode(file_get_contents($url));
	  $access_token = $res->access_token;
	  if ($access_token) {
		$data->expire_time = time() + 7000;
		$data->access_token = $access_token;
		$fp = fopen("access_token.json", "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
	  }
	} else {
	  $access_token = $data->access_token;
	}
	return $access_token;
  }

  public function getMyToken($appid,$secret) {
	$data = json_decode(file_get_contents("./access_token.json"));
	if ($data->expire_time < time() || empty($data)) {
	  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
	  $res = json_decode(file_get_contents($url));
	  file_put_contents("b.log", $res, FILE_APPEND);
	  $access_token = $res->access_token;
	  if ($access_token) {
		$data->expire_time = time() + 7000;
		$data->access_token = $access_token;
		$fp = fopen("./access_token.json", "w");
		fwrite($fp, json_encode($data));
		fclose($fp);
	  }else{
	  	 file_put_contents("b.log", '哎呀妈呀傻逼了，服务器网络瘫痪了', FILE_APPEND);
	  }
	} else {
	  $access_token = $data->access_token;
	}
	return $access_token;
  }
}