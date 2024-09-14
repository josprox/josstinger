<?php

use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use GuzzleHttp\Client;

class NuevoPush {
    public $tituloEsp = "";
    public $tituloIng = "";
    public $mensajeEsp = "";
    public $mensajeIng = "";
    public $urlPersonalizado = "";
    public $moodTester = false;

    private $appId;
    private $apiKey;
    private $userKeyToken;

    public function __construct() {
        $this->appId = $_ENV['ONESIGNAL_APP_ID'] ?? '';
        $this->apiKey = $_ENV['ONESIGNAL_API_KEY'] ?? '';
        $this->userKeyToken = $_ENV['USER_KEY_TOKEN'] ?? '';
    }

    public function enviar(): int {
        // Configure Bearer authorization: app_key
        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($this->apiKey)
            ->setUserKeyToken($this->userKeyToken);

        $apiInstance = new DefaultApi(
            new Client(),
            $config
        );

        // Create notification object and set parameters
        $notification = new Notification();
        $notification->setAppId($this->appId);
        $notification->setContents([
            'en' => $this->mensajeIng,
            'es' => $this->mensajeEsp
        ]);
        $notification->setHeadings([
            'en' => $this->tituloIng,
            'es' => $this->tituloEsp
        ]);
        $notification->setUrl($this->urlPersonalizado);

        // Specify notification recipients
        if ($this->moodTester) {
            // Send to all testers (or a specific segment of testers if defined)
            $notification->setIncludedSegments(['Test Users']);
        } else {
            // Send to all users
            $notification->setIncludedSegments(['All']);
        }

        try {
            $result = $apiInstance->createNotification($notification);
            // Check if notification ID is present
            $status = ($result->getId() !== null) ? 200 : 404;
            return $status;
        } catch (Exception $e) {
            // Error handling
            if ($_ENV['DEBUG'] ?? 0) {
                echo 'Exception when calling DefaultApi->createNotification: ', $e->getMessage(), PHP_EOL;
            }
            return 400;
        }
    }

    public function limpiar(): void {
        // Reset class properties
        $this->tituloEsp = "";
        $this->tituloIng = "";
        $this->mensajeEsp = "";
        $this->mensajeIng = "";
        $this->urlPersonalizado = "";
    }

    public function cerrar(): void {
        // Clean up and close class instance
        $this->limpiar();
    }
}
?>
