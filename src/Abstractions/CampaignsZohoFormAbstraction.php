<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use Omatech\EdiZohoConnect\Contracts\CampaignsZohoFormInterface;
use Psr\Http\Message\ResponseInterface;

abstract class CampaignsZohoFormAbstraction extends ZohoFormAbstraction implements CampaignsZohoFormInterface
{
    public function sendToZoho(): ResponseInterface
    {
        $response = $this->client->request('PUT',
            $this->zohoURL . '/campaigns/Contacts/' . $this->getListId() . '?token=' . $this->zohoToken,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($this->getZohoData()),
                'http_errors' => true
            ]
        );

        if (!in_array($response->getStatusCode(), [200, 202])) {
            throw new \Exception($response);
        }

        return $response;
    }

    public function getZohoData(): array
    {
        return ['emails' => [$this->data['email']]];
    }
}
