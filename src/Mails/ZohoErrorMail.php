<?php

namespace Omatech\EdiZohoConnect\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZohoErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    private $error;
    private $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        array  $data,
        string $error
    )
    {
        $this->data = $data;
        $this->error = $error;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ZohoErrorMail
    {
        $recipients = explode(';', env('ZOHO_ERROR_MAIL_TO'));

        return $this
            ->to($recipients)
            ->view('edi-zoho-connect::zoho-error-mail', [
                'data' => $this->data,
                'error' => $this->error,
            ]);
    }
}
