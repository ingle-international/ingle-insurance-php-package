<?php

use Ingle\Insurance\Api\Applicant;
use Ingle\Insurance\Api\Application;
use Ingle\Insurance\Api\Exception\AuthenticationException;
use Ingle\Insurance\Api\Exception\BadRequestException;
use Ingle\Insurance\Api\Exception\ResponseException;
use Ingle\Insurance\Api\Exception\ServerException;
use Ingle\Insurance\Api\IngleInsurance;

require '../vendor/autoload.php';
require 'config.php';

// ------------------ INITIALIZE SERVER DATA --------------------

IngleInsurance::setSource($settings['source']);
IngleInsurance::setUrl($settings['url']);
IngleInsurance::setApiKey($settings['api_key']);

// ------------------ CREATE APPLICATION ------------------------

$application = new Application();                   // Initialize an Application object.

$application->setEffectiveDate('2020-05-30');       // Set the effective date.
$application->setExpiryDate('2020-07-21');          // Set the expiry date.

$application->addAdditionalData([                   // Set the additional data
    'extra_data1' => 'data1',
    'extra_data2' => 'data1',
]);

try {                                               // Creating the application might throw an exception.
                                                    // Exception can be thrown whenever a server request is made
                                                    // e.g. save(), load(), getApplications(), pay(), etc.
                                                    // -----
    $applicationId = $application->save();          // Create the application on the server, returns the application ID.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to create the application (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (BadRequestException $e) {                  // An invalid request was made (error 400).
    echo "Bad data:\n\n";                           // The data in the application must be invalid (e.g. missing expiry date).
                                                    //
    foreach ($e->getErrorMessages() as $message) {  // You can get a list of the error messages for your request.
        echo $message['message'];                   // Print the error message.
        echo ' ('.$message['key'].')';              // Print data field causing error.
    };                                              //
                                                    //
    echo "\n";                                      //
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

$applicationId = $application->getId();             // You can also get the application ID using getId() if you have already saved it.

echo 'Application '.$applicationId." created.\n\n";

// ------------------ CREATE APPLICANT 1 ------------------------

$applicant1 = new Applicant();                      // Initialize an Applicant object.

$applicant1->setApplicationId($applicationId);      // Set the ID of the application for this applicant.

$applicant1->setPrimary(true);                      // Set primary applicant's data.
$applicant1->setFirstName('Joe');
$applicant1->setLastName('Smith');
$applicant1->setSex('male');
$applicant1->setDateOfBirth('1980-01-01');
$applicant1->setAddressLine1('123 Fake St');
$applicant1->setCity('Toronto');
$applicant1->setState('ON');
$applicant1->setCountry('CA');
$applicant1->setPostalCode('A1A A1A');
$applicant1->setPhoneNumber('(416) 123 4567');
$applicant1->setEmail('joe@smith.com');

$applicant1->addAdditionalData([
    'extra_data1' => 'data1',
    'extra_data2' => 'data1',
]);

$applicant1Id = '';

try {
    $applicant1Id = $applicant1->save();            // Create applicant 1 on the server, returns the applicant ID.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to create the applicant (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (BadRequestException $e) {                  // An invalid request was made (error 400).
    echo "Bad data:\n\n";                           // The data in the applicant must be invalid.
                                                    //
    foreach ($e->getErrorMessages() as $message) {  // You can get a list of the error messages for your request.
        echo $message['message'];                   // Print the error message.
        echo ' ('.$message['key'].')';              // Print data field causing error.
    };                                              //
                                                    //
    echo "\n";                                      //
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo sprintf("Applicant %s created: %s %s.\n",
    $applicant1Id,                                  // Print first applicant's ID
    $applicant1->getFirstName(),                    // Print first applicant's first name
    $applicant1->getLastName());                    // Print first applicant's last name

// ------------------ CREATE APPLICANT 2 ------------------------

$applicant2 = new Applicant();                      // Initialize an Applicant object.
$applicant2->setApplicationId($applicationId);      // Set the ID of the application for this applicant.

$applicant2->setPrimary(false);                     // Set other applicant's data.
$applicant2->setFirstName('James');
$applicant2->setLastName('Smith');
$applicant2->setSex('male');
$applicant2->setDateOfBirth('1980-01-01');
$applicant2->setAddressLine1('123 Fake St');
$applicant2->setCity('Toronto');
$applicant2->setState('ON');
$applicant2->setCountry('CA');
$applicant2->setPostalCode('A1A A1A');
$applicant2->setPhoneNumber('(416) 123 4567');
$applicant2->setEmail('james@smith.com');

$applicant2->addAdditionalData([                    // Set additional data
    'extra_data1' => 'data1',
    'extra_data2' => 'data1',
]);

$applicant2Id = '';

try {
    $applicant2Id = $applicant2->save();            // Create applicant 2 on the server, returns the applicant ID.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to create the application (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (BadRequestException $e) {                  // An invalid request was made (error 400).
    echo "Bad data:\n\n";                           // The data in the application must be invalid (e.g. missing first name).
                                                    //
    foreach ($e->getErrorMessages() as $message) {  // You can get a list of the error messages for your request.
        echo $message['message'];                   // Print the error message.
        echo ' ('.$message['key'].')';              // Print data field causing error.
    };                                              //
                                                    //
    echo "\n";                                      //
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo sprintf("Applicant %s created: %s %s.\n\n",
    $applicant2Id,                                  // Print second applicant's ID
    $applicant2->getFirstName(),                    // Print second applicant's first name
    $applicant2->getLastName());                    // Print second applicant's last name

// ------------------ GET APPLICATION PREMIUM -------------------

try {
    $application->updateData();                     // Update the application first to get the new data
    echo 'Price: '.$application->getPremium()."\n"; // Print the premium
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to get data (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

// ------------------ PAY FOR APPLICATION -----------------------

$confirmation = null;

$paymentProvider = 'payment_provider';
$paymentData = ['data' => '...'];

try {
    $confirmation = $application->pay($paymentProvider, $paymentData);   // This issues the policy and returns a confirmation object.
                                                    //
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to make the payment (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (BadRequestException $e) {                  // An invalid request was made (error 400).
    echo "Bad data:\n\n";                           // The data in the application must be invalid (e.g. invalid payment provider).
                                                    //
    foreach ($e->getErrorMessages() as $message) {  // You can get a list of the error messages for your request.
        echo $message['message'];                   // Print the error message.
        echo ' ('.$message['key'].')';              // Print data field causing error.
    };                                              //
                                                    //
    echo "\n";                                      //
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo "Payment Completed.\n\n\n";

// ------------------ PAYMENT CONFIRMATION ----------------------

echo '---------- '.$confirmation->getTitle()." ----------\n\n";     // Print the title of the confirmation
echo $confirmation->getHeader()."\n\n\n";                   // Print the main header of the confirmation

$sections = $confirmation->getBody();                       // Get the confirmation's body sections

foreach ($sections as $currentSection) {                    // For each section:
    echo $currentSection['header'].":\n\n";                      // Print section header

    foreach ($currentSection['items'] as $currentItem) {        // For each item in current section:
        echo $currentItem['text'].': '.$currentItem['value'];        // Print item text and value
        echo "\n";
    }
    echo "\n";
}

echo $confirmation->getLegalText();
echo "\n\n";

// ------------------ UPDATE APPLICANT --------------------------

$applicant2->setFirstName('John');                  // Change data.

try {
    $applicant2->save();                            // Save applicant.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to make the payment (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (BadRequestException $e) {                  // An invalid request was made (error 400).
    echo "Bad data:\n\n";                           // The data in the application must be invalid (e.g. invalid payment provider).
                                                    //
    foreach ($e->getErrorMessages() as $message) {  // You can get a list of the error messages for your request.
        echo $message['message'];                   // Print the error message.
        echo ' ('.$message['key'].')';              // Print data field causing error.
    };                                              //
                                                    //
    echo "\n";                                      //
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo sprintf("Applicant %s updated: %s %s.\n",
    $applicant2Id,
    $applicant2->getFirstName(),
    $applicant2->getLastName());
