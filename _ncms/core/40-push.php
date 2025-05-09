<?php

// Author: Simon Newton



class push extends handler {
    static $hooks = ["web-push","pushWorker/handle"];   
    
    function try($hook) {
        switch($hook) {
            case "web-push":
                //    new model(["where"=>"gender='Female'"]);
                if (isset($_POST['sub'])) {
                    $encodedForm = json_decode($_POST['sub'], true);
                    $subscriber = (new pushUsers(['where' => "endpoint='{$encodedForm['endpoint']}'"]))->fetch("array");

                    if (count($subscriber) === 0) {
                        $ent = new pushUsers();
                        $payload = [
                            'endpoint'       => $encodedForm['endpoint'],
                            'p256dhKey'      => $encodedForm['keys']['p256dh'],
                            'authKey'        => $encodedForm['keys']['auth'],
                        ];

                        $ent->action('assert', $payload);
                    }
                }
                break;
            default:
                header("Service-Worker-Allowed: /");
                header("Content-Type: application/javascript");
                echo file_get_contents(ROOT . "/themes/public/pushWorker.js");
                break;
        }
                
        return "complete";
    }
}