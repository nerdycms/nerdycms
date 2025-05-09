<?php

// Author: Simon Newton

require_once ROOT . '/vendor/hybridauth/src/autoload.php';
require_once ROOT . '/vendor/hybridauth/src/Hybridauth.php';

use Hybridauth\Hybridauth;
use Hybridauth\Storage\Session;
use Hybridauth\HttpClient;

class socialauth extends handler {
    static $hooks = ["social-auth"]; 
    
    function try($hook) {            
        $sett = (new option("optLGOOG", "social-login"))->fetch("vals");
        $sett2 = (new option("optLTWIT", "social-login"))->fetch("vals");
        $config = [ "callback"=>DOM.VDIR."social-auth",
                    'providers'=>[
                        'Google'=> [
                            'enabled'=>true,
                            'keys'=> [
                                "key"=>$sett['client_id'],
                                "secret"=>$sett['client_secret'] 
                            ]
                        ],
                        'Twitter'=> [
                            'enabled'=>true,
                            'keys'=> [
                                "key"=>$sett2['consumer_key'],
                                "secret"=>$sett2['consumer_secret'] 
                            ]
                        ]
                    ] 
                ];

         $hybridauth = new Hybridauth($config);

        /**
         * Initialize session storage.
         */
        $storage = new Session();

        /**
         * Hold information about provider when user clicks on Sign In.
         */
        $_GET['provider'] = isset($_GET['scope'])?"Google":"Twitter";

        if (isset($_GET['provider'])) {
            $storage->set('provider', $_GET['provider']);
        }

        /**
         * When provider exists in the storage, try to authenticate user and clear storage.
         *
         * When invoked, `authenticate()` will redirect users to provider login page where they
         * will be asked to grant access to your application. If they do, provider will redirect
         * the users back to Authorization callback URL (i.e., this script).
         */
        if ($provider = $storage->get('provider')) {
            $hybridauth->authenticate($provider);
            $storage->set('provider', null);               
            $adapter = $hybridauth->getAdapter($provider);

        }

        /**
         * This will erase the current user authentication data from session, and any further
         * attempt to communicate with provider.
         */
        if (isset($_GET['logout'])) {
            $adapter = $hybridauth->getAdapter($_GET['logout']);
            $adapter->disconnect();
        }

        /**
         * Redirects user to home page (i.e., index.php in our case)
         */
        //$adapter = $hybridauth->getAdapter("Google");

        $pro = $adapter->getUserProfile();

        $ment = new member;
        if(!($m = $ment->fetch("by","password",$pro->identifier))) {
           app::memberLogin($ment->action("assert",[    "created_date"=>date('Y-m-d H:i:s'),
                                                        "profile_img"=>$pro->photoURL,
                                                        "username"=>$pro->displayName,
                                                        "first_name"=>$pro->firstName,
                                                        "last_name"=>$pro->lastName,
                                                        "urole"=>"Free","active"=>"Yes",
                                                        "email"=>$pro->email,
                                                        "password"=>$pro->identifier]),"Free");
        } else {
            app::memberLogin($m['id'],"Free");
        }

        HttpClient\Util::redirect(DOM); 
    
        return "complete";
    }
}