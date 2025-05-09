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

use Minishlink\WebPush\VAPID;

app::check();

class WebPushKeyManager
{
    public static function init(): void
    {
        $keys = self::getKeysArray();
        file_put_contents('kk.txt', print_r($keys, true), 8);
        if (empty($keys['publicKey']) || empty($keys['privateKey'])) {
            self::createAndWriteKeys();
        }
    }

    public static function getKeysArray(): array
    {
        $keysFileName = ROOT . '/content/system/web-push.json';

        return json_decode(file_get_contents($keysFileName), true);
    }

    public static function createAndWriteKeys(): void
    {
        $keysFileName = ROOT . '/content/system/web-push.json';

        $vapid = new VAPID();
        $keys = $vapid::createVapidKeys();

        file_put_contents($keysFileName, json_encode($keys));
    }
}