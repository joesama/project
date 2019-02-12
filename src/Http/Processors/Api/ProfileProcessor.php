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

		return redirect_with_message(
			handles('joesama/project::corporate/profile/list/'.$corporateId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::corporate.profile.form')
			]),
            'success'
		);
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

		return redirect_with_message(
			handles('joesama/project::corporate/profile/assign/'.$corporateId.'/'.$profile->id),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::corporate.profile.assign')
			]),
            'success'
		);
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

		return redirect_with_message(
			handles('joesama/project::corporate/profile/assign/'.$profile->corporate_id.'/'.$profileId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::corporate.profile.assign')
			]),
            'success'
		);
	}


} // END class MakeProjectProcessor 