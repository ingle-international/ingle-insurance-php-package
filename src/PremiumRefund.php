<?php

namespace Ingle\Insurance\Api;

class PremiumRefund extends Base
{
    private $pastCharges = [];
    private $chargeRefundAmounts = [];
    private $id = '';
    private $type = '';
    private $paymentProvider = '';
    private $amount = 0;
    private $warnings = [];

    /**
     * Create premium charge quote for given source and optional client.
     *
     * @param array $quoteData data of premium quote response
     */
    public function __construct(array $quoteData)
    {
        parent::__construct();

        $this->id = $quoteData['id'];
        $this->type = $quoteData['type'];
        $this->amount = abs($quoteData['premium_difference']);

        $this->pastCharges = $quoteData['additional_data'];
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
     * Return magnitude of premium refund.
     *
     * @return int premium change
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Return any warnings that might be given after refund is applied.
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
     * Return list of past charges for this application.
     *
     * @return array past charges
     */
    public function getPastCharges()
    {
        return $this->pastCharges;
    }

    /**
     * Add a refund amount for a specified past charge.
     *
     * @param $paymentProvider
     * @param $chargeId
     * @param $amount
     */
    public function addRefundAmount($paymentProvider, $chargeId, $amount)
    {
        $this->chargeRefundAmounts[$paymentProvider][] = ['charge_id' => $chargeId, 'amount' => $amount];
    }

    /**
     * Clears set refund amounts for past charges.
     */
    public function clearRefundAmounts()
    {
        $this->chargeRefundAmounts = [];
    }

    /**
     * Apply premium refund.
     */
    public function applyChange()
    {
        $refundData = [
            'payment_provider' => $this->paymentProvider,
            'additional_data' => $this->chargeRefundAmounts,
        ];

        $response = $this->client->post(sprintf('premium/charge/%s/%s', $this->source, $this->getId()),
            $refundData);

        $this->warnings = $response['warnings'];

        return $response;
    }

    /**
     * Returns string representation of refund data.
     *
     * @return string
     */
    public function __toString()
    {
        return ('ID: '.$this->getId().'
            Type: '.$this->getType().'
            Amount: '.$this->getAmount())."\n".
            json_encode(['Past Charges' => $this->pastCharges, 'Charges to Refund' => $this->chargeRefundAmounts],
            JSON_PRETTY_PRINT);
    }
}
