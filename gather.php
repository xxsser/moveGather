<?php

class gather
{
    const INDEX_URL = 'http://www.cswanda.com/weixin/game1/move.html';
    public function getIndexList(){
        $header = array(
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B176 MicroMessenger/6.2.6',
            'X-Forwarded-For: '.$this->generateIP(),
        );
        $data = $this->getSource(self::INDEX_URL,$header);
        preg_match_all('/<li>.*?<\/li>/is',$data,$matches);
        return $matches[0];
    }

    public function getFuckUrl($pageurl){
        $header = array(
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 5_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Mobile/9B176 MicroMessenger/4.3.2',
            'X-Forwarded-For: '.$this->generateIP(),
        );
        $data = $this->getSource($pageurl,$header);
        if($data){
            preg_match_all('/(http:\/\/fuck[^"|\']+)/is',$data,$matches);
            $rearr['fuckurl'] = $matches;
            if(strpos($data,'dramaNumList')){
                $data = iconv('GBK','UTF-8',$data);
                preg_match_all('/<li>.+href="([^"|\']+)".+>([^<].+)<\/a><\/li>/Ui',$data,$part);
                $rearr['part']=$part;
            }
        }

        return $rearr;
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


