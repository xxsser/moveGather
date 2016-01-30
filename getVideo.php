<?php
class cswanda_crack{
    protected $useIP;

    public function __construct()
    {
        $this->useIP = $this->generateIP();
    }

    public function getApiUrl($fuckurl){
        $header = array(
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B176 MicroMessenger/6.2.6',
            'Referer: http://cswanda.com/weixin/game1/',
            'X-Forwarded-For: '.$this->useIP,
        );
        $data = $this->getSource($fuckurl,$header);
        if($data){
            preg_match('/"http:\/\/api.+"/Ui',$data,$apiurl);
        }
        return trim($apiurl[0],'""');
    }

    public function getVideo($api_url,$referer){
        $header = array(
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B176 MicroMessenger/6.2.6',
            'Referer: '.$referer,
            'X-Forwarded-For: '.$this->useIP,
        );
        $response_header = $this->getSource($api_url,$header,true);
        preg_match('/http.*/',$response_header,$matches);
        return $matches[0];
    }

    protected static function generateIP(){
        $ip = '';
        for($i=0; $i<4; $i++) {
            $ip .= mt_rand(1,254).'.';
        }
        return trim($ip,'.');
    }

    protected function getSource($url,$header,$reHeader=false){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT,5);
        if($reHeader===true){
            curl_setopt($curl, CURLOPT_VERBOSE, 1);
            curl_setopt($curl, CURLOPT_HEADER, 1);
        }
        $data = curl_exec($curl);
        if($data){
            if($reHeader===true){
                $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
                $response_header = substr($data, 0, $header_size);
                $res =  $response_header;
            }else{
                $res = $data;
            }
        }
        curl_close($curl);
        if($res){
            return $res;
        }
        return false;
    }
}