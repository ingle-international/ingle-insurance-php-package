<?php

namespace Ingle\Insurance\Api;

class Applicant extends Base
{
    protected $data = ['additional_data' => []];
    private $applicationId = '';

    /**
     * Get policy number of current applicant.
     *
     * @return string policy number
     */
    public function getPolicyNumber()
    {
        return !empty($this->data['policy_number']) ? $this->data['policy_number'] : null;
    }

    /**
     * Get ID of current applicant.
     *
     * @return string applicant id
     */
    public function getId()
    {
        return !empty($this->data['id']) ? $this->data['id'] : null;
    }

    /**
     * Set ID of current applicant.
     *
     * @param $id
     *
     * @return string applicant id
     */
    public function setId($id)
    {
        $this->data['id'] = $id;
    }

    /**
     * Get application ID of applicant.
     *
     * @return string application id
     */
    public function getApplicationId()
    {
        return $this->applicationId;
    }

    /**
     * Set application ID of applicant.
     *
     * @param $id
     */
    public function setApplicationId($id)
    {
        $this->applicationId = $id;
    }

    /**
     * Get whether or not applicant is primary applicant of application.
     *
     * @return string is primary
     */
    public function getPrimary()
    {
        return !empty($this->data['primary_applicant']) ? $this->data['primary_applicant'] : null;
    }

    /**
     * Set whether or not applicant is primary applicant of application.
     *
     * @param $isPrimary
     */
    public function setPrimary($isPrimary)
    {
        $this->data['primary_applicant'] = $isPrimary;
    }

    /**
     * Get first name of applicant.
     *
     * @return string name
     */
    public function getFirstName()
    {
        return !empty($this->data['first_name']) ? $this->data['first_name'] : null;
    }

    /**
     * Set first name of applicant.
     *
     * @param $name
     */
    public function setFirstName($name)
    {
        $this->data['first_name'] = $name;
    }

    /**
     * Get last name of applicant.
     *
     * @return string name
     */
    public function getLastName()
    {
        return !empty($this->data['last_name']) ? $this->data['last_name'] : null;
    }

    /**
     * Set last name of applicant.
     *
     * @param $name
     */
    public function setLastName($name)
    {
        $this->data['last_name'] = $name;
    }

    /**
     * Get sex of applicant.
     *
     * @return string sex
     */
    public function getSex()
    {
        return !empty($this->data['sex']) ? $this->data['sex'] : null;
    }

    /**
     * Set sex of applicant.
     *
     * @param $sex
     */
    public function setSex($sex)
    {
        $this->data['sex'] = $sex;
    }

    /**
     * Get date of birth of applicant.
     *
     * @return string date of birth
     */
    public function getDateOfBirth()
    {
        return !empty($this->data['dob']) ? $this->data['dob'] : null;
    }

    /**
     * Set date of birth of applicant.
     *
     * @param $date
     */
    public function setDateOfBirth($date)
    {
        $this->data['dob'] = $date;
    }

    /**
     * Get first address line of applicant.
     *
     * @return string address line 1
     */
    public function getAddressLine1()
    {
        return !empty($this->data['address_line_1']) ? $this->data['address_line_1'] : null;
    }

    /**
     * Set first address line of applicant.
     *
     * @param $address
     */
    public function setAddressLine1($address)
    {
        $this->data['address_line_1'] = $address;
    }

    /**
     * Get second address line of applicant.
     *
     * @return string address line 2
     */
    public function getAddressLine2()
    {
        return !empty($this->data['address_line_2']) ? $this->data['address_line_2'] : null;
    }

    /**
     * Set second address line of applicant.
     *
     * @param $address
     */
    public function setAddressLine2($address)
    {
        $this->data['address_line_2'] = $address;
    }

    /**
     * Get applicant's city of residence.
     *
     * @return string city
     */
    public function getCity()
    {
        return !empty($this->data['city']) ? $this->data['city'] : null;
    }

    /**
     * Set applicant's city of residence.
     *
     * @param $city
     */
    public function setCity($city)
    {
        $this->data['city'] = $city;
    }

    /**
     * Get applicant's state of residence.
     *
     * @return string state
     */
    public function getState()
    {
        return !empty($this->data['state']) ? $this->data['state'] : null;
    }

    /**
     * Set applicant's state of residence.
     *
     * @param $state
     */
    public function setState($state)
    {
        $this->data['state'] = $state;
    }

    /**
     * Get applicant's country of residence.
     *
     * @return string country code
     */
    public function getCountry()
    {
        return !empty($this->data['country_code']) ? $this->data['country_code'] : null;
    }

    /**
     * Set applicant's country of residence.
     *
     * @param $countryCode
     */
    public function setCountry($countryCode)
    {
        $this->data['country_code'] = $countryCode;
    }

    /**
     * Get postal code of applicant.
     *
     * @return string code
     */
    public function getPostalCode()
    {
        return !empty($this->data['postal_code']) ? $this->data['postal_code'] : null;
    }

    /**
     * Set postal code of applicant.
     *
     * @param $code
     */
    public function setPostalCode($code)
    {
        $this->data['postal_code'] = $code;
    }

    /**
     * Get phone number of applicant.
     *
     * @return string phone number
     */
    public function getPhoneNumber()
    {
        return !empty($this->data['phone']) ? $this->data['phone'] : null;
    }

    /**
     * Set phone number of applicant.
     *
     * @param $number
     */
    public function setPhoneNumber($number)
    {
        $this->data['phone'] = $number;
    }

    /**
     * Get email address of applicant.
     *
     * @return string email address
     */
    public function getEmail()
    {
        return !empty($this->data['email']) ? $this->data['email'] : null;
    }

    /**
     * Set email address of applicant.
     *
     * @param $email
     */
    public function setEmail($email)
    {
        $this->data['email'] = $email;
    }

    /**
     * Get the data in the additional_data field.
     *
     * @return array additional data
     */
    public function getAdditionalData()
    {
        return !empty($this->data['additional_data']) ? $this->data['additional_data'] : [];
    }

    /**
     * Add data to the additional_data field, replacing existing data.
     *
     * @param $additionalData
     */
    public function addAdditionalData($additionalData)
    {
        $this->data['additional_data'] = array_replace_recursive($this->getAdditionalData(), $additionalData);
    }

    /**
     * Clear all data in the additional_data field.
     */
    public function clearAdditionalData()
    {
        $this->data['additional_data'] = [];
    }

    /**
     * Set the data array to given data.
     *
     * @param $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Save applicant information, creating new applicant if doesn't exist.
     *
     * @return int applicant id
     */
    public function save()
    {
        $applicationData = $this->client->get(sprintf('application/%s/%s', $this->source, $this->applicationId));
        $active = !empty($applicationData['active']) ? $applicationData['active'] : false;

        if (!empty($this->getId())) {
            $method = $active === true ? 'patch' : 'put';
            $url = sprintf('applicant/%s/%s/%s', $this->source, $this->applicationId, $this->getId());
        } else {
            $method = 'post';
            $url = sprintf('applicant/%s/%s', $this->source, $this->applicationId);
        }

        $responseData = $this->client->$method($url, $this->data);
        $this->data = $responseData;

        return $responseData['id'];
    }

    /**
     * Load information from specified applicant.
     *
     * @param $applicationId
     * @param $applicantId
     *
     * @return Applicant the loaded applicant
     */
    public static function load($applicationId, $applicantId)
    {
        $responseData = IngleInsurance::getClient()->get(
            sprintf('applicant/%s/%s/%s',
                IngleInsurance::getSource(),
                $applicationId,
                $applicantId)
        );

        $applicant = new self();
        $applicant->setData($responseData);

        return $applicant;
    }
}
