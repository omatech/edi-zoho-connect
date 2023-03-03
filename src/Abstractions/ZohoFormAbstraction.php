<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Omatech\EdiZohoConnect\Contracts\ZohoFormInterface;
use Omatech\EdiZohoConnect\Models\ZohoForm;
use function env;

abstract class ZohoFormAbstraction extends ZohoForm implements ZohoFormInterface
{
    protected $zohoOwner;
    protected $zohoURL;
    protected $zohoToken;
    protected $client;
    protected $contactForm;

    public function __construct($contactFormData)
    {
        $this->zohoOwner = env('ENDPOINT_OWNER');
        $this->zohoURL = env('ENDPOINT_URL');
        $this->zohoToken = env('ENDPOINT_TOKEN');
        $this->client = new Client();

        parent::__construct(array_merge([
            'status' => 'pending',
            'form' => $this->getFormType(),
        ], $contactFormData));
    }

    public function send(): void
    {
        $contactForm = $this->contactForm;

        try {
            $response = $this->sendToZoho();
            $contactForm['status'] = 'send';
            $contactForm['data_api'] = addslashes(json_encode($contactForm['data']));
            echo "\nSend contact form OK: " . $contactForm['id'] . " status: " . $response->getStatusCode();
            $contactForm->save();

        } catch (GuzzleException|\Exception $e) {
            $contactForm['status'] = 'error';
            $contactForm['data_api'] = addslashes(json_encode($e->getMessage()));
            $this->notifyError($e);
            echo "\nSendNewsletter Error: " . $contactForm['id'] . " " . $e->getMessage();
        }
    }

    private function notifyError($e)
    {
        //todo si hi ha error enviar email (agafar email del .env) amb les dades del formulari i l'error
    }
}
