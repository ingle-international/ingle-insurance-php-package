<?php

namespace Ingle\Insurance\Api;

use Ingle\Insurance\Api\Exception\DataException;

class BulkPolicyUpload extends Base
{
    /**
     * @var array
     */
    private $applications = [];

    /**
     * Add an application to the bulk upload.
     *
     * @param Application $application
     * @param array       $applicants
     * @param array       $payment
     *
     * @throws DataException
     *
     * @return mixed
     */
    public function addApplication(Application $application, array $applicants, array $payment)
    {
        if (empty($applicants)) {
            throw new DataException('No applicants supplied.');
        }

        if (empty($payment)) {
            throw new DataException('No payment supplied.');
        }

        $data = [
           'id'          => bin2hex(random_bytes(32)),
           'application' => $application->getData(),
           'applicants'  => [],
        ];

        foreach ($applicants as $applicant) {
            if (!($applicant instanceof Applicant)) {
                throw new DataException('Invalid applicant data');
            }

            $data['applicants'][] = $applicant->getData();
        }

        if (empty($payment[0])) {
            throw new DataException('No payment type supplied.');
        }

        $data['payment'] = [
           'payment_provider' => $payment[0],
           'additional_data'  => !empty($payment[1]) ? $payment[1] : [],
        ];

        $this->applications[] = $data;

        return $data['id'];
    }

    /**
     * Submit the bulk upload request.
     *
     * @return array
     */
    public function submit()
    {
        return $this->client->post(sprintf('bulkupload/%s/', $this->source), ['data' => $this->applications]);
    }

    /**
     * Get the status of a current bulk upload.
     *
     * @return array
     */
    public function getStatus($statusKey)
    {
        return $this->client->get(sprintf('bulkupload/%s/%s/', $this->source, $statusKey));
    }
}
