# Ingle Insurance PHP API

## Usage

### Setup

1. Run `composer install` 

### Initialization (required)
Set Base URL to be used:
```php
IngleInsurance::setUrl($baseUrl);
```

Set source to be used:
```php
IngleInsurance::setSource('ingle');
```

Authenticate client with API key:
```php
IngleInsurance::setApiKey('...');
```


### Application
```php
$application = new Application();
```

Set application fields:
```php
$application->setEffectiveDate('yyyy-mm-dd');
$application->setExpiryDate('yyyy-mm-dd');
$application->setLocale('en');
```

Set additional data fields:
```php
$application->addAdditionalData(['eligibility' => true]);
$application->addAdditionalData(['additional_applicants_number' => 1])
$application->addAdditionalData([
    'dates_of_births' => [
        [
            'yyyy-mm-dd',
            'primary'
        ],
        [
            'yyyy-mm-dd',
            'dependent'
        ]
    ]
]);

// ----- or -------

$application->addAdditionalData([
    'eligibility' => true,
    'additional_applicants_number' => 1,
    'dates_of_births' => [
        [
            'yyyy-mm-dd',
            'primary'
        ],
        [
            'yyyy-mm-dd',
            'dependent'
        ]
    ]
]);
```

Save application as new:
```php
// Don't set Application ID

$applicationId = $application->save();
```

Update an existing application:
```php
// Set Applicant ID first

$application->setId($id);
$application->save();
```

Get application premium:
```php
// Make sure applicants are created first.

$quote = $application->getQuote();
```

Get quote for an application:
```php
$quote = $application->getQuote();
```

Pay for an application (returns a Confirmation, see below):
```php
// Make sure application and applicants have been created and saved first

$confirmation = $application->pay('stripe', ['token' => 'XXXXX']);
```

Cancel a policy:
```php
$application->setId('02b22412-7818-48e1-a460-080bbeebcca3');
$refundAmount = $application->cancel();
```

Load applicants from an application:
```php
$applicantList = $application->getApplicants();
```

Load an existing application:
```php
$application = Application::load($id);
```

Get a list of applications for a specified source:
```php
$applications = Application::getApplications('ingle');

// or

$applications = Application::getApplications(
    'ingle',
    $options = [
        'page' = 1,
        'limit' = 10
]);
```

### Applicant
```php
$applicant = new Applicant();
```

Set applicant fields:
```php
$applicant->setPrimary(true);
$applicant->setFirstName('Joe');
$applicant->setLastName('Smith');
$applicant->setSex('male');
$applicant->setDateOfBirth('1980-01-01');
$applicant->setAddressLine1('123 Fake St');
$applicant->setCity('Toronto');
$applicant->setState('ON');
$applicant->setCountry('CA');
$applicant->setPostalCode('A1A A1A');
$applicant->setPhoneNumber('(416) 123 4567');
$applicant->setEmail('joe@smith.com');
```

Set additional data fields:
```php
$applicant->addAdditionalData([
    'school_name' => 'University of Waterloo',
    'eligibility' => true,
    'country_of_origin' => 'US',
    'beneficiary' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'address' => '100 Bay',
        'country_code' => 'CA',
        'city' => 'Toronto',
        'relationship_to_insured' => 'stranger'
    ]
]);

// ----- or -------

$applicant->addAdditionalData([
    'school_name' => 'University of Waterloo',
    'eligibility' => true,
    'country_of_origin' => 'US',
    'beneficiary' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'address' => '100 Bay',
        'country_code' => 'CA',
        'city' => 'Toronto',
        'relationship_to_insured' => 'stranger'
    ]
]);
```

Save applicant as new:
```php
// Set Application ID first

$applicant->setApplication($applicationId);
$applicant->save();
```

Update an existing applicant:
```php
// Set Applicant ID and Application ID first

$applicant->setApplication($applicationId);
$applicant->setId($applicantId);
$applicant->save();
```

Load an existing applicant:
```php
$applicant = Applicant::load($applicantId);
```

### Payment Confirmation

Access confirmation details:
```php
$confirmation = $application->pay(...);

$title = $confirmation->getTitle();
$header = $confirmation->getHeader();
$body = $confirmation->getBody();
$legalText = $confirmation->getBody()
```

Access confirmation body sections:
```php
$firstSection = $body[0];

$firstSectionHeader = $firstSection['header'];

$firstItem = firstSection['items'][0];
$itemText = $firstItem['text'];
$itemValue= $firstItem['value'];
```

### Quote

Get quote for an application:
```php
$quote = new Quote($applicationId);

// ----- or -------

$quote = $application->getQuote();
```

Get quote price:
```php
$price = $quote->getPrice();
```

Get quote information:
```php
$price = $quote->getInformation();
```

Get list of quote content items:
```php
$price = $quote->getContent();
```

Get list of quote links:
```php
$price = $quote->getLinks();
```


### Premium Update
Make an application with the changes:
```php
$applicationChanges = new Application();
$applicationChanges->setId($id);   // id of application to change
$applicationChanges->setExpiryDate($newDate);
```

Make applicants with changes (optional):
```php
$applicant1Changes = new Application();
$applicant1Changes->setId($id);     // id of applicant to change
$applicant1Changes->setDateOfBirth($newDate);

$applicant2Changes = new Application();
$applicant2Changes->setId($id);     // id of applicant to change
$applicant2Changes->addAdditionalData($newData);
```

Form premium update:
```php
$update = new PremiumUpdate();

$update->setApplication($applicationChanges);
$update->addApplicant($applicant1Changes);
$update->addApplicant($applicant2Changes);
```

Submit changes:
```php
$costChange = $premium->requestUpdate();
```

#### Charge
```php
if ($costChange->getType() == 'charge')
```

Get charge amount:
```php
$amount = $costChange->getAmount();
```

Set payment provider:
```php
$costChange->setProvider('stripe');
```

Add additional data (e.g. payment token):
```php
$costChange->addAdditionalData(['token' => 'XXXXX']);
```

Make payment:
```
$costChange->applyChange();
```

#### Refund
```php
if ($costChange->getType() == 'refund')
```

Get refund amount:
```php
$amount = $costChange->getAmount();
```

Get list of past charges:
```php
$charges = $costChange->getPastCharges();
```

Set payment provider:
```php
$costChange->setProvider('stripe');
```

Set refund amounts for individual past charges:
```php
$costChange->addRefundAmount($paymentProvider, $charge1Id, $amountToRefund);
$costChange->addRefundAmount($paymentProvider, $charge2Id, $amountToRefund);
```

Apply Refund:
```php
$costChange->applyChange();
```
