<?php

namespace Omatech\EdiZohoConnect\Commands;

use Illuminate\Console\Command;
use Omatech\EdiZohoConnect\Models\ZohoForm;

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
     * Execute the console command.
     */
    public function handle(): void
    {
        if (env('ZOHO_SEND_FORMS') && env('ZOHO_SEND_FORMS') === true) {
            echo("Start send info eDiversa Forms\n");

            ZohoForm::where('status', 'pending')->each(function (ZohoForm $zohoForm) {
                (new $zohoForm['form'])
                    ->setZohoForm($zohoForm)
                    ->setRawAttributes($zohoForm->getAttributes(), true)
                    ->send();
            });

            echo("\nFinish send info eDiversa Forms\n");
        } else {
            echo("NOT send info eDiversa Forms (config send forms = false)\n");
        }
    }
}


