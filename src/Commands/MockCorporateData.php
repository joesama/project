<?php

namespace Joesama\Project\Commands;

use Faker\Generator as Faker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Joesama\Entree\Database\Model\Role;
use Joesama\Entree\Database\Model\User;
use Joesama\Project\Database\Model\Master\Master;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Corporate;
use Joesama\Project\Database\Model\Organization\CorporateAddress;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Organization\ProfileRole;


class MockCorporateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:masterdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Master Data For Application';

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

        $masterData = collect(config('joesama/project::master'));

        $role = data_get($masterData,'role');

        $this->info('Generating User Role Data');

        foreach(data_get($role,'user') as $id => $userrole){

            $roles = (Role::find($id+2)) ?  Role::find($id+2) : new Role();
            $roles->name = $userrole;
            $roles->save();     
        }

        $this->table(
            [ 'id','role' ],
            Role::where('id','!=',1)->get(['id','name'])->toArray()
        );


        $this->info('Generating Profile Role Data');

        DB::table('profile_role')->truncate();

        foreach(data_get($role,'profile') as $role){
            $profile = ProfileRole::firstOrNew(['role' => $role]);
            $profile->save();
        }

        $this->table(
            [ 'id','profile role' ],
            ProfileRole::all(['id','role'])->toArray()
        );

        $this->info('Generating Corporate Data');

        $corporate = data_get($masterData,'corporate');

        DB::table('corporate')->truncate();

        $inforCorporate = collect([]);

        collect($corporate)->each(function($kubSub , $kubGroup) use($inforCorporate){

            $group = Corporate::firstOrNew(
                    ['name' => ucwords($kubGroup)],
                    ['logo' => 'packagesjoesama/project/img/kub.png']
                );
            $group->save();

            collect($kubSub)->each(function($sub,$subId) use($group,$inforCorporate){
                $subsidiary = Corporate::firstOrNew(
                    ['name' => ucwords($sub)],
                    [
                        'child_to' => $group->id,
                        'logo' => 'packagesjoesama/project/img/'.str_replace('_','.',$subId),
                    ]
                );
                $subsidiary->save();

                $inforCorporate->push([$subsidiary->id,$subsidiary->name,$group->name]);
            });

        });

        $this->table(
            [ 'id','subsidiary','group' ],
            $inforCorporate->toArray()
        );

        $this->info('Generating Master Data');

        $masterData = data_get($masterData,'master');

        DB::table('master')->truncate();
        DB::table('master_data')->truncate();

        $inforMaster = collect([]);

        collect($masterData)->each(function($mdata,$mkey) use($inforMaster){

            $master = Master::firstOrNew(['description' => $mkey]);
            $master->save();

            collect($mdata)->each(function($data) use($master){
                $masterdt = MasterData::firstOrNew(
                    ['description' => ucwords($data)],
                    [
                        'master_id' => $master->id,
                    ]
                );
                $masterdt->save();
            });

            $inforMaster->push([$master->description,MasterData::where('master_id',$master->id)->pluck('description')->implode(',')]);

        });

        $this->table(
            [ 'master','master data' ],
            $inforMaster->toArray()
        );

        if ($this->confirm('Do you wish to create administration user?')) {

        $this->info('Generating Administration User');

        $profileRole =  ProfileRole::all();

        $startId = collect(['id' => 2]);

        Corporate::whereNull('child_to')->get()->each(function($group) use($profileRole,$startId){

            $profileRole->each(function($role) use($startId,$group){

                $id = data_get($startId,'id');

                $user = User::firstOrNew(['id' => $id]);
                $this->info(ucwords($role->role.' '.str_limit($group->name,25,'')));
                $user->username = snake_case(strtolower($role->role).$group->id);
                $user->email = snake_case(strtolower($role->role)).$group->id.'@kub.com';
                $user->password = '123456';
                if($role->id == 1){
                    $user->isAdmin = 1;
                }
                $user->status = 1;
                $user->fullname = ucwords($role->role.' '.str_limit($group->name,25,''));
                $user->save();

                if($role->id == 1){
                    $user->roles()->sync(2);
                }else{
                    $user->roles()->sync(4);
                }

                $abbr = collect(explode(' ', $user->fullname))->map(function($abbr){
                    return $abbr[0];
                })->implode('');

                $profile = Profile::firstOrNew(['id' => $id-1]);
                $profile->name = $user->fullname;
                $profile->user_id = $user->id;
                $profile->corporate_id = $group->id;
                $profile->email = $user->email;
                $profile->abbr = $abbr;
                $profile->save();

                $startId->put('id',data_get($startId,'id')+1);
            });

            Corporate::where('child_to',$group->id)->get()->each(function($subsidiary) use($group,$profileRole,$startId){
                $profileRole->each(function($role) use($startId,$subsidiary){

                    $id = data_get($startId,'id');

                    $user = User::firstOrNew(['id' => $id]);
                    $this->info(ucwords($role->role.' '.str_limit($subsidiary->name,25,'')));
                    $user->username = snake_case(strtolower($role->role).$subsidiary->id);
                    $user->email = snake_case(strtolower($role->role)).$subsidiary->id.'@kub.com';
                    $user->password = '123456';
                    if($role->id == 1){
                        $user->isAdmin = 1;
                    }
                    $user->status = 1;
                    $user->fullname = ucwords($role->role.' '.str_limit($subsidiary->name,25,''));
                    $user->save();

                    $abbr = collect(explode(' ', $user->fullname))->map(function($abbr){
                        return $abbr[0];
                    })->implode('');

                    $profile = Profile::firstOrNew(['id' => $id-1]);
                    $profile->name = $user->fullname;
                    $profile->user_id = $user->id;
                    $profile->email = $user->email;
                    $profile->corporate_id = $subsidiary->id;
                    $profile->abbr = $abbr;
                    $profile->save();

                    if($role->id == 1){
                        $user->roles()->sync(3);
                    }else{
                        $user->roles()->sync(4);
                    }
                    
                    $startId->put('id',data_get($startId,'id')+1);
                });
            });
        });

        $this->table(
            [ 'username','email','fullname' ],
            User::where('id','!=',1)->get(['username','email','fullname'])->toArray()
        );

        $setupFile = storage_path('app/defaultuser.json');

        file_put_contents($setupFile, User::where('id','!=',1)->get(['username','email','fullname'])->toJson());

        }
    }
}
