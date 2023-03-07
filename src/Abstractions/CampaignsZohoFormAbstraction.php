<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use Omatech\EdiZohoConnect\Contracts\CampaignsZohoFormInterface;
use Psr\Http\Message\ResponseInterface;

abstract class CampaignsZohoFormAbstraction extends ZohoFormAbstraction implements CampaignsZohoFormInterface
{
    public function sendToZoho(): ResponseInterface
    {
        return $this->client->request('PUT',
            $this->zohoURL . '/campaigns/Contacts/' . $this->getListId() . '?token=' . $this->zohoToken,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($this->getZohoData()),
                'http_errors' => true
            ]
        );
    }

    public function getZohoData(): array
    {
        return ['emails' => [$this->data['email']]];
    }
}
