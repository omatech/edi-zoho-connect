<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use App\Console\Commands\ContactForms\Interfaces\CampaignsContactFormInterface;
use Psr\Http\Message\ResponseInterface;

abstract class CampaignsZohoFormAbstraction extends ZohoFormAbstraction implements CampaignsContactFormInterface
{
    public function sendToZoho(): ResponseInterface
    {
        $data = $this->contactForm->data;

        return $this->client->request('PUT',
            $this->zohoURL . '/campaigns/Contacts/' . $this->getListId() . '?token=' . $this->zohoToken,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(['emails' => [$data['email']]]),
                'http_errors' => true
            ]
        );
    }
}
