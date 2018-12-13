<?php

namespace Joesama\Project\Commands;

use Illuminate\Console\Command;
use Faker\Generator as Faker;

use Joesama\Project\Http\Processors\{
    Project\MakeProjectProcessor,
    Project\ProjectInfoProcessor,
    Organization\MakeOrganizationProcessor,
    Organization\OrganizationInfoProcessor,
};

class ProjectConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:console';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Console For Project Data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        MakeProjectProcessor $makeProject,
        ProjectInfoProcessor $infoProject,
        MakeOrganizationProcessor $makeOrganization,
        OrganizationInfoProcessor $infoOrganization
    ){
        $this->projectObj = $makeProject;
        $this->projectData = $infoProject;
        $this->organizationObj = $makeOrganization;
        $this->organizationData = $infoOrganization;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $corporateList = $this->organizationData->corporateList()->pluck('name','id');

            if($corporateList->isEmpty() || $this->confirm('New Corporate?')):

            $corporateObj =  $this->organizationObj->makeNewCorporate(collect([
                'name' => $this->ask('Corporate Name')
            ]));

            $corporateId = $corporateObj->id;

        else:

            $corporate = $this->choice('Organization?', $corporateList->toArray());

            $corporateObj = $corporateList->filter(function ($value, $key) use($corporate){
                return strtolower($value) == strtolower($corporate);
            });

            $corporateId = $corporateObj->keys()->first();

        endif;

        $clientList = $this->projectData->clientList($corporateId)->pluck('name','id');

        if($clientList->isEmpty() || $this->confirm('New Client?')):

            $clientObj = $this->projectObj->makeNewClient(collect([
                'corporate_id' => $corporateId,
                'name' => $this->ask('Client Name'),
                'manager' => $this->ask('Client Manager'),
                'phone' => $this->ask('Client Phone'),
                'contact' => $this->ask('Client Contact')
            ]));

            $clientId = $clientObj->id;

        else:

            $client = $this->choice('Client?', $clientList->toArray());

            $clientObj = $clientList->filter(function ($value, $key) use($client){
                return strtolower($value) == strtolower($client);
            });

            $clientId = $clientObj->keys()->first();

        endif;

        $newProject = $this->projectObj->makeNewProject(collect([
            'corporate_id' => $corporateId,
            'client_id' => $clientId,
            'name' => $this->ask('Project Name'),
            'contract' => $this->ask('Contract Amount'),
            'bond' => $this->ask('Bond Amount'),
            'start' => $this->ask('Date Start'),
            'end' => $this->ask('Date End'),
        ]));

        if(!is_null($newProject)):

        collect($newProject->toArray())->each(function($item,$key){
            $this->line( $key.' - '.$item );
        });

        endif;

    }
}
