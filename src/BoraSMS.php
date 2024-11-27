<?php

namespace ILEBORA;

use Dotenv\Dotenv;

class BoraSMS
{
    private $smsApi = 'https://api.boracore.co.ke/send';
    private $phone;
    private $message;
    private $onSuccess;
    private $onFailure;
    private $backLink;
    
    private $apiKey;
    private $userID;
    private $displayName;
    

    // Constructor to optionally load credentials from the environment or user-provided values
    public function __construct()
    {
        // Load environment variables from .env if available
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..'); // Assuming .env is at the root level
        $dotenv->load();

        // Get API credentials from environment variables or the constructor (if provided)
        $this->apiKey = getenv('BORA_SMS_API_KEY');
        $this->userID = getenv('BORA_SMS_USER_ID');
        $this->displayName = getenv('BORA_SMS_DISPLAY_NAME');

        if (empty($this->apiKey) || empty($this->userID) || empty($this->displayName)) {
            throw new \Exception('API key, User ID, and Display Name are required.');
        }

        return $this;
    }

    // Setter methods to allow users to override the values
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    public function setUserID($userID)
    {
        $this->userID = $userID;
        return $this;
    }

    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

    // Send SMS method
    public function sendSMS()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->smsApi); // Replace with actual API endpoint

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . base64_encode($this->userID . ":" . $this->apiKey)
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $curl_post_data = [
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

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);
        return $curl_response;
    }

}