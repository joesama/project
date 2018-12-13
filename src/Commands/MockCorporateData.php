<?php

namespace Joesama\Project\Commands;

use Illuminate\Console\Command;
use Faker\Generator as Faker;

use Joesama\Project\Database\Model\Master\Country;
use Joesama\Project\Database\Model\Master\State;
use Joesama\Project\Database\Model\Master\City;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\CorporateAddress;


class MockCorporateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:mockdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mock Project Data For Development';

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
     *
     * @return mixed
     */
    public function handle()
    {

        $data = collect(json_decode(file_get_contents(base_path('workbench/joesama/project/resources/database/raw/my.json'))));

        $countries = $data->groupBy('country')->keys();

        $countries->each(function($ctry) use($data){

            $country = Country::firstOrNew(['name' => $ctry]);
            $country->save();
            collect($data->where('country',$ctry)->groupBy('admin')->keys())->each(function($state) use($data, $country){
                
                if(strlen($state) > 0):
                $states = State::firstOrNew(['name' => $state, 'country_id' => $country->id]);
                $states->save();
                collect($data->where('admin',$state))->each(function($cities) use($states){
                    $city = City::firstOrNew(
                        ['name' => data_get($cities,'city'), 'state_id' => $states->id],
                        ['lat' => data_get($cities,'lat'), 'long' => data_get($cities,'lng')]
                    );
                    $city->save();

                });
                endif;
            });
            
        });

        factory(Corporate::class, 2)->create()->each(function ($corporate) {

            factory(Corporate::class,4)->create()->each(function ($subs) use($corporate){
                $subs->address()->save(
                    factory(CorporateAddress::class)->make()
                );
                $corporate->subsidiary()->save($subs);
            });

            $corporate->address()->save(factory(CorporateAddress::class)->make());
        });
    }
}
