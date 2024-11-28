<?php

namespace ILEBORA;

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
    public function __construct() {
        // Load environment variables directly in the constructor
        $this->apiKey = $_ENV['BORA_SMS_APIKEY'];
        $this->userId = $_ENV['BORA_SMS_USERID'];
        $this->displayName = $_ENV['BORA_SMS_DISPLAYNAME'];
        $this->successUrl = $_ENV['BORA_SMS_SUCCESS_URL'];
        $this->failureUrl = $_ENV['BORA_SMS_FAILURE_URL'];

        if (empty($this->apiKey) || empty($this->userId) || empty($this->displayName)) {
            throw new \Exception('API key, User ID, and Display Name are required.');
        }
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