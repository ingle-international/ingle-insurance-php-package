<?php

use Ingle\Insurance\Api\Applicant;
use Ingle\Insurance\Api\Application;
use Ingle\Insurance\Api\Exception\AuthenticationException;
use Ingle\Insurance\Api\Exception\ResponseException;
use Ingle\Insurance\Api\Exception\ServerException;
use Ingle\Insurance\Api\IngleInsurance;

require '../vendor/autoload.php';
require 'config.php';

// ------------------ INITIALIZE SERVER DATA --------------------

IngleInsurance::setSource($settings['source']);
IngleInsurance::setUrl($settings['url']);
IngleInsurance::setApiKey($settings['api_key']);

// ------------------ GET APPLICATION LIST ----------------------

try {
    $applicationsList = Application::getApplications(); // Load all applications for specified source.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to get the applications (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

if (!isset($applicationsList[0])) {
    die;
}              // If application doesn't have an applicant, end the script.

$firstApplication = $applicationsList[0];           // Get the first application in the list.
$firstApplicationId = $firstApplication->getId();        // Get the ID of the first application

echo 'First application is '.$firstApplicationId.".\n";

// ------------------ LOAD APPLICATION ------------------------

$secondApplication = null;
$secondApplicationId = $applicationsList[1]->getId();   // Get the ID of the second application

try {
    $secondApplication = Application::load($secondApplicationId); // You can load an application if you just know the ID
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to get the applications (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo 'Second application (loaded) is '.$secondApplication->getId().".\n\n";

// ------------------ GET APPLICANTS LIST --------------------------

$applicantsList = [];

try {
    $applicantsList = Application::getApplicants($firstApplicationId);  // Load all the applicants for the first application.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to get the applications (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

if (!isset($applicantsList[0])) {
    die;                                            // If application doesn't have an applicant, end the script.
}

$firstApplicant = $applicantsList[0];               // Get the first applicant in the list.

echo sprintf("First applicant of first application is %s: %s %s.\n",
    $firstApplicant->getId(),                       // Print first applicant's ID.
    $firstApplicant->getFirstName(),                // Print first applicant's first name.
    $firstApplicant->getLastName());                // Print first applicant's last name.

// ------------------ LOAD APPLICANT ------------------------

$firstApplicantId = $firstApplicant->getId();       // Get the ID of the first applicant

try {
    $firstApplicant = Applicant::load(              // You can load an applicant if you know:
        $firstApplicationId,                        // the application id and
        $firstApplicantId);                         // the applicant id.
                                                    // -----
} catch (AuthenticationException $e) {              // Client didn't have authentication to get the applications (error 401),
    echo $e->getMessage()."\n";                     // API key might not be set like in the INITIALIZE SERVER DATA section above.
                                                    // -----
} catch (ResponseException $e) {                    // Response returned HTTP error other than 400 or 401.
    echo $e->getMessage()."\n";                     // e.g. 404 Not Found, 500 Internal Server Error
                                                    // -----
} catch (ServerException $e) {                      // Server did not respond in the set waiting time.
    echo $e->getMessage()."\n";                     // URL might be incorrect or server might be having issues, try increasing timeout.
}

echo sprintf("First applicant (loaded) is %s: %s %s.\n",
    $firstApplicant->getId(),
    $firstApplicant->getFirstName(),
    $firstApplicant->getLastName());
