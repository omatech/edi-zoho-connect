<?php

namespace Omatech\EdiZohoConnect\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Omatech\EdiZohoConnect\Models\ZohoForm;

class ZohoErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    private $zohoForm;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        ZohoForm $zohoForm
    )
    {
        $this->zohoForm = $zohoForm;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to(env('ZOHO_ERROR_MAIL_TO'))->view('edi-zoho-connect::zoho-error-mail', ['zohoForm' => $this->zohoForm]);
    }
}
