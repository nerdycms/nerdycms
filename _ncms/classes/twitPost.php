<?php
require_once ROOT."/vendor/twitter-api-v2-php/vendor/autoload.php"; 

use Noweh\TwitterApi\Client;
use GuzzleHttp\Client as GClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;


/**
 * Description of twitPost
 *
 * @author S.Newton
 */
class twitPost {
    var $client,$oauth,$gclient;
    
    public function __construct($settings) {        
        $this->client = new Client($settings);                       
        $stack = HandlerStack::create();
        $oAuth1 = new Oauth1([
            'consumer_key' => $settings['consumer_key'],
            'consumer_secret' => $settings['consumer_secret'],
            'token' => $settings['access_token'],
            'token_secret' => $settings['access_token_secret'],
        ]);
        $stack->push($oAuth1);
        $this->gclient = new GClient([
            'base_uri' => "https://upload.twitter.com/1.1/",
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }
    
    function postVideo($file,$text) {                
        $ok = false;
        if($mid = $this->upload_init($file)) {
            if($this->upload_append($file,$mid)) $ok = $this->upload_finalise($mid);
        }
        
        if($ok) {        
            try {            
                $resp = $this->client->tweet()->create()
                    ->performRequest([
                        'text' => $text, 
                        "media" => [
                            "media_ids" => [
                                "$mid"
                            ]
                        ]
                    ]);          
                $ok = true;
            } catch (Exception $e) {                
                $ok = false;
            }
        } 
        return $ok;
    }
    
    function media($data,$chunk=null,$method="POST") {        
        $params['headers'] = ['Accept' => 'application/json'];
        
        if(sizeof($data)>0) {
            $params['query'] = [];
            foreach($data as $k=>$v) {                 
                $params['query'][$k]=$v;
            }
        }
                    
        if($chunk) $params['multipart'] []= ["name"=>"media_data","contents"=> base64_encode($chunk)];        
        
        try {            
            $response = $this->gclient->request($method, "media/upload.json", $params);            
            $sc = $response->getStatusCode(); 
            if ($sc >= 200 && $sc<300) {
                $cnt = $response->getBody()->getContents();
                $json = @json_decode($cnt, true);                
                if(!$json) $json['raw_cnt']=$cnt;
                $json['status_code'] = $sc;
                return $json;
            }
        } catch (Exception $e) {
            var_dump($e);                        
        }
    }
    
    function upload_init($file) {        
        return @$this->media(['command'=>'INIT','media_type'=>'video/mp4','total_bytes'=>filesize($file),'media_category'=>'tweet_video'])['media_id'];              
    }

    function upload_append($file,$mid) {
        $segment_id = 0;
        $bytes_sent = 0;
        $fh = fopen($file, 'rb');
        $sz = filesize($file);
        while ($bytes_sent < $sz) {
            $chunk = fread($fh,1*1024*1024);
            $resp = $this->media(['command'=>'APPEND','media_id'=>$mid,'segment_index'=>$segment_id],$chunk);              
            if ($resp['status_code'] < 200 || $resp['status_code'] > 299) break;        
            $segment_id++;
            $bytes_sent = ftell($fh);    
        }
        return true;
    }
    
    function upload_finalise($mid) {
        $info = $this->media(['command'=>'FINALIZE','media_id'=>$mid]);
        if(!$info) return false;
            
        return $this->check_status($info['processing_info'],$mid);
    }
    
    function check_status($info,$mid) {        
        if(!$info) return false;

        $state = $info['state'];
        if($state == 'succeeded') return true;
        if($state == 'failed') return false;

        $check_after_secs = $info['check_after_secs'];        
        sleep($check_after_secs);            
        $req = $this->media(['command'=>'STATUS','media_id'=>$mid],null,"GET");            
        return $this->check_status(@$req['processing_info'],$mid);
    }
}
