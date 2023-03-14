<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use Omatech\EdiZohoConnect\Contracts\LeadZohoFormInterface;
use Psr\Http\Message\ResponseInterface;

abstract class LeadZohoFormAbstraction extends ZohoFormAbstraction implements LeadZohoFormInterface
{
    public function sendToZoho(): ResponseInterface
    {
        $urlClientLeads = $this->zohoURL . '/crm/Leads?token=' . $this->zohoToken;

        $response = $this->client->request(
            'POST',
            $urlClientLeads,
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode(array_filter($this->getFormData()))
            ]);

        if (!in_array($response->getStatusCode(), [200, 202])) {
            throw new \Exception($response);
        }

        return $this->sendLeadNotesToZoho($response);
    }

    private function sendLeadNotesToZoho($leadsResponse): ResponseInterface
    {
        $clientId = json_decode($leadsResponse->getBody()->getContents())->data[0]->id;
        $url = $this->zohoURL . '/crm/Leads/' . $clientId . '/notes?token=' . $this->zohoToken;

        $response = $this->client->request(
            'POST',
            $url,
            ['headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($this->getNotes())
            ]
        );

        if (!in_array($response->getStatusCode(), [200, 202])) {
            throw new \Exception($response);
        }

        return $response;
    }

    public function getZohoData(): array
    {
        return array_merge(array_filter($this->getFormData()), $this->getNotes());
    }

    public function getFormData(): array
    {
        $dataContact = $this->data;
        $formOrigin = $this->getFuenteDeFormulario();

        return array_merge([
            'Date' => $this->created_at->timestamp * 1000,
            'Idioma' => $dataContact['language'] ?? null,
            'Owner' => $this->zohoOwner,
            'Cargo' => $dataContact['position'] ?? '-',
            'First_Name' => $dataContact['name'] ?? '-',
            'Last_Name' => $dataContact['surname'] ?? '-',
            'Full_Name' => ($dataContact['name'] ?? "-") . " " . ($dataContact['surname'] ?? ""),
            'Company' => $dataContact['company'] ?? null,
            'Description' => $data['inquiry'] ?? "**Contacto creado o actualizado desde $formOrigin**",
            'Email' => $dataContact['email'] ?? null,
            'Phone' => $dataContact['phone'] ?? null,
            'Fuente_de_formulario' => $formOrigin,
            'RGPD' => ($dataContact['checkbox_notifications'] ?? null) == 'on' ? $this->getRgpdValues() : null,
            'Lead_Status' => 'Sin contactar',
            'Ads_Campaign' => "---",
            'Ads_URL' => $this['url'] ?? null,
        ], $this->addExtraFormData($dataContact));
    }

    protected function addExtraFormData(array $dataContact): array
    {
        return [];
    }

    public function getNotes(): array
    {
        $dataContact = $this->data;

        return [
            'Title' => "Comentarios del cliente (web)",
            'Content' => $dataContact['message'] ?? $dataContact['comments'] ?? null
        ];
    }

    private function getRgpdValues(): array
    {
        return [
            'Email' => true,
            'Phone' => true,
            'Survey' => false,
            'Consent' => "Correo electrónico",
            'Status' => "Consentimiento - Obtenido",
            'Date' => $this['created_at']->timestamp * 1000,
        ];
    }
}
