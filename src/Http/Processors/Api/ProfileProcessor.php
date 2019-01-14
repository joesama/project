<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Joesama\Project\Database\Repositories\Organization\MakeOrganizationRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class ProfileProcessor 
{

	public function __construct(
		MakeOrganizationRepository $makeOrganization
	){
		$this->makeorganization = $makeOrganization;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId, ?int $profileId)
	{
		if(is_null($profileId)){
			$request->validate([
	        	'email' => ['required',Rule::unique('users')],
	    	]);
		}

	    $validate = $request->validate([
	        'email' => ['required',Rule::unique('profile')->ignore($profileId)],
	    ]);

		$profile = $this->makeorganization->initProfile(collect($request->all()),$profileId);

		return redirect(handles('joesama/project::corporate/profile/list/'.$corporateId));
	}

	/**
	 * Assign Profile To Project
	 * 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $profileId   [description]
	 * @return [type]               [description]
	 */
	public function assign(Request $request,int $corporateId, int $profileId)
	{
		$profile = $this->makeorganization->assignProfile(collect($request->all()),$profileId);

		return redirect(handles('joesama/project::corporate/profile/assign/'.$corporateId.'/'.$profile->id));
	}

	/**
	 * Assign Profile To Project
	 * 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @param  int     $profileId   [description]
	 * @return [type]               [description]
	 */
	public function reassign(Request $request,int $profileId, int $projectId)
	{
		$profile = $this->makeorganization->reassignProfile($profileId,$projectId);

		return redirect(handles('joesama/project::corporate/profile/assign/'.$profile->corporate_id.'/'.$profileId));
	}


} // END class MakeProjectProcessor 