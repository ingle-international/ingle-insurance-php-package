<?php

namespace Ingle\Insurance\Api;

class PremiumCharge extends Base
{
    private $id = '';
    private $type = '';
    private $paymentProvider = '';
    private $additionalData = [];
    private $amount = 0;
    private $warnings = [];

    /**
     * Create premium charge quote with given data.
     *
     * @param array $quoteData data of premium quote response
     */
    public function __construct(array $quoteData)
    {
        parent::__construct();

        $this->id = $quoteData['id'];
        $this->type = $quoteData['type'];
        $this->amount = abs($quoteData['premium_difference']);
    }

    /**
     * Return ID of premium change quote.
     *
     * @return string id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return whether premium change is a charge or refund.
     *
     * @return string 'charge' or 'refund'
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return magnitude of premium charge.
     *
     * @return int premium change
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Return any warnings that might be given after charge is applied.
     *
     * @return array warnings
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Set payment provider for payment.
     *
     * @param $paymentProvider
     */
    public function setProvider($paymentProvider)
    {
        $this->paymentProvider = $paymentProvider;
    }

    /**
     * Get the data in the additional_data field.
     */
    public function getAdditionalData()
    {
        return !empty($this->additionalData) ? $this->additionalData : [];
    }

    /**
     * Add data to the additional_data field, replacing existing data.
     *
     * @param $additionalData
     */
    public function addAdditionalData($additionalData)
    {
        $this->additionalData = array_replace_recursive($this->additionalData, $additionalData);
    }

    /**
     * Clear all data in the additional_data field.
     */
    public function clearAdditionalData()
    {
        $this->additionalData = [];
    }

    /**
     * Apply premium charge.
     */
    public function applyChange()
    {
        $paymentData = [
            'payment_provider' => $this->paymentProvider,
            'additional_data'  => $this->additionalData,
        ];

        $response = $this->client->post(sprintf('premium/charge/%s/%s', $this->source, $this->getId()),
            $paymentData);

        $this->warnings = $response['warnings'];

        return $response;
    }

    /**
     * Returns string representation of charge data.
     *
     * @return string
     */
    public function __toString()
    {
        return 'ID: '.$this->getId().'
            Type: '.$this->getType().'
            Amount: '.$this->getAmount();
    }
}
