<?php

namespace Omatech\EdiZohoConnect\Abstractions;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Mail;
use Omatech\EdiZohoConnect\Contracts\ZohoFormInterface;
use Omatech\EdiZohoConnect\Mails\ZohoErrorMail;
use Omatech\EdiZohoConnect\Models\ZohoForm;
use function env;

abstract class ZohoFormAbstraction extends ZohoForm implements ZohoFormInterface
{
    protected $zohoOwner;
    protected $zohoURL;
    protected $zohoToken;
    protected $zohoForm;
    protected $client;

    public function __construct($zohoFormData = [])
    {
        $this->zohoOwner = env('ZOHO_OWNER');
        $this->zohoURL = env('ZOHO_URL');
        $this->zohoToken = env('ZOHO_TOKEN');
        $this->client = new Client();
        $this->attributes['form'] = get_class($this);
        parent::__construct($zohoFormData);
    }

    public function setZohoForm($zohoForm): ZohoFormAbstraction
    {
        $this->zohoForm = $zohoForm;
        return $this;
    }

    public function send(): void
    {
        try {
            $response = $this->sendToZoho();
            $this->zohoForm->update([
                'status' => 'send',
                'data_api' => $this->getZohoData(),
            ]);

            echo "\nSend zoho form OK: " . $this['id'] . " status: " . $response->getStatusCode();

        } catch (ClientException|RequestException|Exception $e) {
            $this->zohoForm->update([
                'status' => 'error',
                'data_api' => $e->getMessage()
            ]);

            Mail::send(new ZohoErrorMail($this->getZohoData(), $e->getMessage()));
            echo "\nSend zoho form Error: " . $this['id'] . " " . $e->getMessage();
        }
    }
}
