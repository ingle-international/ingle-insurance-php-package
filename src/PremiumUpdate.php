<?php

namespace Ingle\Insurance\Api;

class PremiumUpdate extends Base
{
    protected $data = ['application' => [], 'applicants' => []];
    private $id = '';
    private $type = '';
    private $amount = 0;

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
     * Return magnitude of premium change.
     *
     * @return int premium change
     */
    public function getDiffAmount()
    {
        return $this->amount;
    }

    /**
     * Give application containing changes.
     *
     * @param Application $application
     */
    public function setApplication(Application $application)
    {
        $this->data['application'] = json_decode($application, true);
    }

    /**
     * Add applicant containing changes.
     *
     * @param Applicant $applicant
     */
    public function addApplicant(Applicant $applicant)
    {
        $this->data['applicants'][] = json_decode($applicant, true);
    }

    /**
     * Clear all applicant changes.
     */
    public function clearApplicants()
    {
        $this->data['applicants'] = [];
    }

    /**
     * Submit updated data to request premium change.
     *
     * @return PremiumCharge|PremiumRefund
     */
    public function requestUpdate()
    {
        $responseData = $this->client->post(sprintf('premium/quote/%s/%s', $this->source,
            $this->data['application']['id']), $this->data);

        if ($responseData['type'] == 'charge') {
            return new PremiumCharge($responseData, $this->source, ['client' => $this->client]);
        } else {
            return new PremiumRefund($responseData, $this->source, ['client' => $this->client]);
        }
    }
}
