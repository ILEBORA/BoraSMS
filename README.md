# BoraSMS

`BoraSMS` is a PHP library for sending SMS messages using a custom API. This library allows you to easily send SMS messages, configure success and failure handlers, and customize your API credentials.

## Installation

To install the package, you can use Composer:

```bash
composer require ilebora/borasms
```

## Configuration

Before using `BoraSMS`, you'll need to provide your API credentials (API key, user ID, and display name). There are two ways to do this:

1. **Using Environment Variables (`.env` file)**  
   The package can automatically read the API credentials from your `.env` file using [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv).

2. **Using Getter and Setter Methods**  
   Alternatively, you can set the credentials directly via getter and setter methods.

### Example `.env` file

Create a `.env` file in the root of your project with the following contents:

```plaintext
BORA_SMS_API_KEY=your_api_key
BORA_SMS_USER_ID=your_user_id
BORA_SMS_DISPLAY_NAME=your_display_name
```

### Example Usage

Below is an example of how to use the `BoraSMS` class.

```php
<?php
require 'vendor/autoload.php';

use ILEBORA\BoraSMS;

try {
    // Option 1: Using the constructor to load from environment variables
    $sms = new BoraSMS();

    // Option 2: Alternatively, set credentials using setters
    // $sms = (new BoraSMS())
    //     ->setApiKey('your_api_key')
    //     ->setUserID('your_user_id')
    //     ->setDisplayName('your_display_name');

    // Set other SMS properties
    $sms->setPhone('1234567890')
        ->setMessage('Hello, this is a test message!')
        ->setOnSuccess('success_callback_url')
        ->setOnFailure('failure_callback_url');

    // Send the SMS
    $response = $sms->sendSMS();

    // Handle the response
    echo "SMS Sent! Response: " . $response;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
```

### Methods Overview

- **`__construct()`**  
  Optionally loads credentials from environment variables. Throws an exception if required credentials are missing.

- **`setApiKey($apiKey)`**  
  Sets the API key used for authentication.

- **`setUserID($userID)`**  
  Sets the user ID used for authentication.

- **`setDisplayName($displayName)`**  
  Sets the display name used for sending SMS.

- **`setPhone($phone)`**  
  Sets the recipient phone number.

- **`setMessage($message)`**  
  Sets the message to be sent.

- **`setOnSuccess($onSuccess)`**  
  Sets the URL to be called on success.

- **`setOnFailure($onFailure)`**  
  Sets the URL to be called on failure.

- **`sendSMS()`**  
  Sends the SMS and returns the response from the API.

### Handling Responses

The `sendSMS()` method returns the raw API response. You can use this response to check the status of the SMS request or handle it accordingly (e.g., display a success message or log an error).

### Example Callback Response

The response returned by the API might look like this:

```json
{
  "status": "success",
  "messageId": "abc123",
  "message": "Message sent successfully"
}
```

You can process this response as needed to update your application's UI or log the result.

---

## License

This package is open-source and licensed under the MIT License. Feel free to modify and contribute to the project.

---

### Notes:

1. **Error Handling**:  
   If the required credentials are missing, the constructor will throw an exception. It's important to handle this gracefully in your application.

2. **Security Considerations**:  
   It's recommended to store sensitive information like the API key and user ID in environment variables (via `.env` file) instead of hardcoding them into your source code.
