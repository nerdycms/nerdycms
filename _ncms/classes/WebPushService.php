<?php

require_once ROOT . '/vendor/minishlink/web-push/src/MessageSentReport.php';
require_once ROOT . '/vendor/web-token/jwt-signature/Signature.php';
require_once ROOT . '/vendor/web-token/jwt-core/Util/ECSignature.php';
require_once ROOT . '/vendor/web-token/jwt-core/Util/JsonConverter.php';
require_once ROOT . '/vendor/web-token/jwt-core/JWT.php';
require_once ROOT . '/vendor/web-token/jwt-core/Util/KeyChecker.php';
require_once ROOT . '/vendor/web-token/jwt-core/Algorithm.php';
require_once ROOT . '/vendor/web-token/jwt-signature/Algorithm/SignatureAlgorithm.php';
require_once ROOT . '/vendor/web-token/jwt-signature/JWS.php';
require_once ROOT . '/vendor/web-token/jwt-signature-algorithm-ecdsa/ECDSA.php';
require_once ROOT . '/vendor/web-token/jwt-signature-algorithm-ecdsa/ES256.php';
require_once ROOT . '/vendor/web-token/jwt-core/Util/JsonConverter.php';
require_once ROOT . '/vendor/web-token/jwt-core/Util/ECKey.php';
require_once ROOT . '/vendor/web-token/jwt-core/JWK.php';
require_once ROOT . '/vendor/web-token/jwt-core/AlgorithmManager.php';
require_once ROOT . '/vendor/web-token/jwt-key-mgmt/JWKFactory.php';
require_once ROOT . '/vendor/web-token/jwt-signature/Serializer/JWSSerializer.php';
require_once ROOT . '/vendor/web-token/jwt-signature/Serializer/Serializer.php';
require_once ROOT . '/vendor/web-token/jwt-signature/JWSBuilder.php';
require_once ROOT . '/vendor/web-token/jwt-signature/Serializer/CompactSerializer.php';
require_once ROOT . '/vendor/spomky-labs/base64url/src/Base64Url.php';
require_once ROOT . '/vendor/minishlink/web-push/src/Utils.php';
require_once ROOT . '/vendor/minishlink/web-push/src/VAPID.php';
require_once ROOT . '/vendor/minishlink/web-push/src/WebPush.php';
require_once ROOT . '/vendor/minishlink/web-push/src/Encryption.php';
require_once ROOT . '/vendor/minishlink/web-push/src/SubscriptionInterface.php';
require_once ROOT . '/vendor/minishlink/web-push/src/Subscription.php';
require_once ROOT . '/vendor/minishlink/web-push/src/Notification.php';

use Minishlink\WebPush\Subscription;

class WebPushService
{
    public static function sendAll($title, $body)
    {
        WebPushKeyManager::init();
        $keys = WebPushKeyManager::getKeysArray();

        $push = new \Minishlink\WebPush\WebPush(["VAPID" => [
            'subject'    => "https://" . $_SERVER['HTTP_HOST'],
            'publicKey'  => $keys['publicKey'],
            'privateKey' => $keys['privateKey'],
        ]]);
        $push->setReuseVAPIDHeaders(true);


        $subscribersFetched = (new pushUsers())->fetch('array');

        foreach ($subscribersFetched as $fetchedSub) {
            $auth = [
                'keys' => [
                    'auth'   => $fetchedSub['authKey'],
                    'p256dh' => $fetchedSub['p256dhKey'],
                    ],
                'endpoint' => $fetchedSub['endpoint'],
            ];

            $subscribe = Subscription::create($auth);

            $push->queueNotification(subscription: $subscribe, payload:  json_encode([
                'title' => $title,
                'body'  => $body,
                'icon'  => "/content/common/favorite_icon.ico",
//                'image' => "/content/common/favorite_icon.ico"
            ]));
        }

        foreach ($push->flush() as $res) {
            $endpoint = $res->getRequest()->getUri()->__toString();
            file_put_contents(
                SYS_CONTENT_DIR."/push-log.txt",
                print_r("$endpoint - " . $res->isSuccess(), true),
                8
            );
        }
    }
}