<?php

namespace Ingle\Insurance\Api;

use Ingle\Insurance\Api\Exception\DataException;

class Application extends Base
{
    protected $data = ['additional_data' => []];

    /**
     * Get status of current application.
     *
     * @return string current status
     */
    public function getStatus()
    {
        return !empty($this->data['status']) ? $this->data['status'] : null;
    }

    /**
     * Get active status of current application.
     *
     * @return string current status
     */
    public function getActive()
    {
        return !empty($this->data['active']) ? $this->data['active'] : false;
    }

    /**
     * Get ID of current application.
     *
     * @return string application id
     */
    public function getId()
    {
        return !empty($this->data['id']) ? $this->data['id'] : null;
    }

    /**
     * Set ID of current application.
     *
     * @param $id
     *
     * @return string application id
     */
    public function setId($id)
    {
        $this->data['id'] = $id;
    }

    /**
     * Get date from which application is effective.
     *
     * @return string date
     */
    public function getEffectiveDate()
    {
        return !empty($this->data['effective_date']) ? $this->data['effective_date'] : null;
    }

    /**
     * Set date from which application is effective.
     *
     * @param $date
     */
    public function setEffectiveDate($date)
    {
        $this->data['effective_date'] = $date;
    }

    /**
     * Get date after which application is expired.
     *
     * @return string date
     */
    public function getExpiryDate()
    {
        return !empty($this->data['expiry_date']) ? $this->data['expiry_date'] : null;
    }

    /**
     * Set date after which application is expired.
     *
     * @param $date
     */
    public function setExpiryDate($date)
    {
        $this->data['expiry_date'] = $date;
    }

    /**
     * Get locale of application.
     *
     * @return string locale
     */
    public function getLocale()
    {
        return !empty($this->data['locale']) ? $this->data['locale'] : null;
    }

    /**
     * Set locale of application.
     *
     * @param $locale
     */
    public function setLocale($locale)
    {
        $this->data['locale'] = $locale;
    }

    /**
     * Get premium of application.
     *
     * @param bool $dollarFormat
     *
     * @return string premium
     */
    public function getPremium($dollarFormat = true)
    {
        if (empty($this->data['premium'])) {
            return;
        }

        return $dollarFormat ? sprintf('$%s', number_format($this->data['premium'], 2)) : $this->data['premium'];
    }

    /**
     * Get the data in the additional_data field.
     *
     * @return array
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
        $this->data['additional_data'] = array_replace_recursive($this->data['additional_data'], $additionalData);
    }

    /**
     * Clear all data in the additional_data field.
     */
    public function clearAdditionalData()
    {
        $this->data['additional_data'] = [];
    }

    /**
     * Load data from quote of current application.
     *
     * @throws DataException
     *
     * @return array quote
     */
    public function getQuote()
    {
        return new Quote($this->getId());
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
     * Save application information, creating new one if id is not specified.
     *
     * @return int application id
     */
    public function save()
    {
        if (!empty($this->getId())) {
            $method = 'put';
            $url = sprintf('application/%s/%s/', $this->source, $this->getId());
        } else {
            $method = 'post';
            $url = sprintf('application/%s/', $this->source);
        }

        $responseData = $this->client->$method($url, $this->data);

        $this->data = $responseData;

        return $responseData['id'];
    }

    /**
     * Makes payment for current application.
     *
     * @param $paymentProvider
     * @param array $additionalData
     *
     * @return Confirmation payment confirmation
     *
     * @throws DataException
     */
    public function pay($paymentProvider, $additionalData = [])
    {
        if (empty($this->getId())) {
            throw new DataException('Tried to pay with no application ID set.');
        }

        $payment = [
            'payment_provider' => $paymentProvider,
            'additional_data' => $additionalData,
        ];

        $this->client->post(sprintf('payment/%s/%s', $this->source, $this->getId()), $payment);

        $this->updateData();

        return new Confirmation($this->getId());
    }

    /**
     * Cancel policy for current application.
     *
     * @return float refund amount
     *
     * @throws DataException
     */
    public function cancel()
    {
        if (empty($this->getId())) {
            throw new DataException('Tried to cancel with no application ID set.');
        }

        $responseData = $this->client->delete(sprintf('policy/%s/%s', $this->source, $this->getId()));

        $this->updateData();

        return $responseData;
    }

    /**
     * Updates data stored in current application object.
     */
    public function updateData()
    {
        $this->data = IngleInsurance::getClient()->get(
            sprintf('application/%s/%s',
                IngleInsurance::getSource(),
                $this->getId())
        );
    }

    /**
     * Load information from specified application.
     *
     * @param $id
     *
     * @return Application the loaded application
     */
    public static function load($id)
    {
        $responseData = IngleInsurance::getClient()->get(
            sprintf('application/%s/%s',
                IngleInsurance::getSource(),
                $id)
        );

        $application = new self();
        $application->setData($responseData);

        return $application;
    }

    /**
     * Get list of applicants for specified application.
     *
     * @param $id
     *
     * @return Applicant[] list of applicants
     */
    public static function getApplicants($id)
    {
        $applicants = [];

        $responseData = IngleInsurance::getClient()->get(
            sprintf('applicant/%s/%s',
                IngleInsurance::getSource(),
                $id)
        );

        foreach ($responseData['applicants'] as $data) {
            $app = new Applicant();
            $app->setData($data);
            $applicants[] = $app;
        }

        return $applicants;
    }

    /**
     * Gets list of applications for source specified in IngleInsurance.
     *
     * @param array $options
     *
     * @return Application[] applications
     */
    public static function getApplications($options = ['page' => 1, 'limit' => 10])
    {
        $default = ['page' => '1', 'limit' => 10];
        $options = array_merge($default, $options);

        $appData = IngleInsurance::getClient()->get(
            sprintf('application/%s/?page=%s&limit=%s',
                IngleInsurance::getSource(),
                $options['page'],
                $options['limit'])
        );

        $applications = [];

        foreach ($appData['applications'] as $currentAppData) {
            $currentApp = new self(IngleInsurance::getSource(), $options);
            $currentApp->setData($currentAppData);

            $applications[] = $currentApp;
        }

        return $applications;
    }
}
