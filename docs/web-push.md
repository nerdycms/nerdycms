Web-push notification implementation<br>
**Works only with PHP 8.1** <br>
Required packages: <br>
`sudo apt-get install openssl` <br>
`composer require minishlink/web-push` <br>


Keys stored in `content/system/web-push.json`.Format JSON, avaliable keys **publicKey, privateKey**
Main service implementation in 
<br> **themes/public/{themeName}/assets/web-push.js** and **themes/public/{themeName}/assets/web-push.js** 
<br> **handlers/WebPushKeyManager.php** and **handlers/WebPushService.php** <br>

**Important notice !!!**
Web push worker should be placed in ROOT . /themes/public/ to load it via PHP