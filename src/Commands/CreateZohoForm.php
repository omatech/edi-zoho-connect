<?php

namespace Omatech\EdiZohoConnect\Commands;

use App\Console\Commands\ContactForms\BlogContactForm;
use App\Console\Commands\ContactForms\ClientContactForm;
use App\Console\Commands\ContactForms\ContactContactForm;
use App\Console\Commands\ContactForms\ContactLandingContactForm;
use App\Console\Commands\ContactForms\LandingContactForm;
use App\Console\Commands\ContactForms\NewsletterContactForm;
use App\Models\Eloquent\ContactForm;
use Illuminate\Console\Command;

class CreateZohoForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho-forms:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a form class to send to zoho';

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
        $className = $this->ask('Filename?');

        $formType = $this->choice('Choose form type:', array_keys($this->getFormStubs()));

        $this->createFormClass($className, $formType);
    }

    private function getFormStubs(): array
    {
        return [
            'Campaign' => 'ZohoCampaignFormModel',
            'Lead' => 'ZohoLeadFormModel',
        ];
    }

    public function createFormClass($className, $formType)
    {
        $path = app_path() . '/Models/ZohoForms/';
        $replace = [];

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        if (!file_exists($path . $className . '.php')) {
            $stubFiles = $this->getFormStubs();

            $stubFile = $stubFiles[$formType];
            $file = file_get_contents(__DIR__ . "/stubs/$stubFile.stub");

            $replace["DummyNamespace"] = 'App\Models\ZohoForms';
            $replace["DummyClass"] = $className;

            $file = str_replace(array_keys($replace), array_values($replace), $file);

            $file_php = fopen(app_path() . '/Models/ZohoForms/' . $className . '.php', "w");
            fwrite($file_php, $file);
            fclose($file_php);

            echo("Create " . $className . " Form Class \n");

        } else {
            echo "Exists " . $className . " Model \n";
        }
    }
}


