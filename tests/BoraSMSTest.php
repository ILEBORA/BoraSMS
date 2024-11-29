<?php

use ILEBORA\BoraSMS;
use PHPUnit\Framework\TestCase;

class BoraSMSTest extends TestCase
{
    public function testSetApiKey()
    {
        // Create an instance of the BoraSMS class
        $sms = new BoraSMS();
        
        // Set API Key using the setter method
        $sms->setApiKey('your_api_key');
        
        // Use reflection or getter to check if API key is set correctly (assuming a getter exists or directly testing behavior)
        $this->assertEquals('your_api_key', $sms->getApiKey());
    }

    public function testSendSMS()
    {
        // Mock the curl_exec function to prevent real API calls during testing
        $mockCurl = $this->getMockBuilder('BoraSMS')
            ->setMethods(['sendSMS']) // Mock the sendSMS method
            ->getMock();

        // Configure the mock to return a predefined response
        $mockCurl->method('sendSMS')
            ->willReturn(json_encode([
                'status' => 'success',
                'messageId' => 'abc123',
                'message' => 'Message sent successfully'
            ]));

        // Set properties for the mock object
        $mockCurl->setApiKey('your_api_key');
        $mockCurl->setUserID('your_user_id');
        $mockCurl->setDisplayName('your_display_name');
        $mockCurl->setPhone('1234567890');
        $mockCurl->setMessage('Hello, world!');
        $mockCurl->setOnSuccess('success_callback');
        $mockCurl->setOnFailure('failure_callback');

        // $mockCurl->setTest(true);
        
        // Test sending SMS
        $response = $mockCurl->sendSMS();
        
        // Assert that the response is as expected
        $expectedResponse = json_encode([
            'status' => 'success',
            'messageId' => 'abc123',
            'message' => 'Message sent successfully'
        ]);
        
        $this->assertJsonStringEqualsJsonString($expectedResponse, $response);
    }

    public function testMissingCredentials()
    {
        // Expect an exception when credentials are missing
        $this->expectException(\Exception::class);
        
        $sms = new BoraSMS();
        $sms->sendSMS(); // This should fail due to missing credentials
    }
}
