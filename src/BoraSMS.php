<?php
/**
 * BoraSMS
 * Author: Dominic Karau (api.boracore.co.ke)
 * Description: Package for sending SMS via BoraSMS API.
 * License: MIT
 */
namespace ILEBORA;

use ILEBORA\Services\BoraService;

class BoraSMS extends BoraService
{

    private $phone;
    private $message;

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }

    public function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    // Send SMS method
    public function sendSMS()
    {
        $url = $this->apiUrl . '/' . $this->apiVersion . '/sms/send';

        $payload = [
            'displayName' => $this->displayName,
            'userID'      => $this->userID,
            'apiKey'      => $this->apiKey,
            'phone'       => $this->phone,
            'message'     => $this->message,
            'backLink'    => $this->backLink,
            'onSuccess'   => $this->onSuccess,
            'onFailure'   => $this->onFailure,
            'shortCode'   => 'B',
        ];

        $response = $this->makeRequest($url, $payload);

        return json_encode($response); 
    }

}