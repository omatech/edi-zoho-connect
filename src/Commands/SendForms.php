<?php

namespace Omatech\EdiZohoConnect\Commands;

use App\Console\Commands\ContactForms\BlogContactForm;
use App\Console\Commands\ContactForms\ClientContactForm;
use App\Console\Commands\ContactForms\ContactContactForm;
use App\Console\Commands\ContactForms\ContactLandingContactForm;
use App\Console\Commands\ContactForms\LandingContactForm;
use App\Console\Commands\ContactForms\NewsletterContactForm;

use Omatech\EdiZohoConnect\Models\ZohoForm;
use Illuminate\Console\Command;

class SendForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho-forms:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send info from all eDiversa forms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        if (env('SEND_FORMS') && env('SEND_FORMS') === true) {
            echo("Start send info eDiversa Forms\n");

            $zohoForms = ZohoForm::where('status', 'pending')->get();

            foreach ($zohoForms as $zohoForm) {
                $formsClasses = [
                    'newsletter' => NewsletterContactForm::class,
                    'blog' => BlogContactForm::class,
                    'contact' => ContactContactForm::class,
                    'client' => ClientContactForm::class,
                    'contact_landing' => ContactLandingContactForm::class,
                    'landing' => LandingContactForm::class,
                ];

                (new $formsClasses[$zohoForm['form']]($zohoForm))->sendToZoho();
            }

            echo("\nFinish send info eDiversa Forms\n");
        } else {
            echo("NOT send info eDiversa Forms (config send forms = false)\n");
        }
    }
}


