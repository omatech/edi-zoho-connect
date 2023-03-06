<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use Omatech\EdiZohoConnect\Contracts\LeadZohoFormInterface;
use Psr\Http\Message\ResponseInterface;

abstract class LeadZohoFormAbstraction extends ZohoFormAbstraction implements LeadZohoFormInterface
{
    public function sendToZoho(): ResponseInterface
    {
        $data = array_filter($this->getFormData());

        $urlClientLeads = $this->zohoURL . '/crm/Leads?token=' . $this->zohoToken;
        $response = $this->client->request('POST', $urlClientLeads, ['headers' => ['Content-Type' => 'application/json'], 'body' => json_encode($data)]);

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

    public function getFormData(): array
    {
        $dataContact = $this->data;

        return [
            'Owner' => $this->zohoOwner,
            'Company' => $dataContact['company'] ?? null,
            'Description' => '**Contacto creado o actualizado desde eDiversa**',
            'Cargo' => $dataContact['position'] ?? null,
            'First_Name' => $dataContact['name'] ?? '-',
            'Last_Name' => $dataContact['surname'] ?? '-',
            'Full_Name' => ($dataContact['name'] ?? "-") . " " . ($dataContact['surname'] ?? ""),
            'Email' => $dataContact['email'] ?? null,
            'Phone' => $dataContact['phone'] ?? null,
            'Fuente_de_formulario' => $this->getFuenteDeFormulario(),
            'Interesado_en' => $dataContact['solution'] ? [
                'edi' => "EDI",
                'factura_aapp' => "Factura AAPP",
                'factura_part' => "Factura particulares",
                'sii' => "SII",
                'portal_construc' => "Portal construcción",
                'silicie' => "SILICIE",
                'custom_devel' => "Desarrollos a Medida",
            ][$dataContact['solution']]: null,
            'RGPD' => ($data['checkbox_notifications'] ?? null) == 'on' ? $this->getRgpdValues() : null,
            'Lead_Status' => 'Sin contactar',
            'Ads_Campaign' => "---",
            'Ads_URL' => $this['url'],
        ];
    }

    public function getNotes(): array
    {
        $dataContact = $this->data;

        return [
            'Title' => "Comentarios del cliente (web)",
//            'Content' => $this->data['message'] ?? null,
            'Content' => implode("", [
                $dataContact['comments'] ?? null,
                "\n ¿trabajas con EDI? " . (($dataContact['edi'] ?? null) == 1 ? 'SI' : 'NO') . ". \n",
                " Punto operacional (GLN): " . $dataContact['gln'] . "\n",
                " Red: " . $dataContact['red_edi'] . "\n",
                " Interlocutor: " . $dataContact['interlocutor'] . "\n",
            ])
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
