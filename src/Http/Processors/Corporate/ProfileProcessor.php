<?php
namespace Joesama\Project\Http\Processors\Corporate; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Organization\ProfileRole;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Repositories\Organization\OrganizationInfoRepository;
use Joesama\Project\Http\Processors\Corporate\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Make New Organization Record 
 *
 * @package default
 * @author 
 **/
class ProfileProcessor 
{
	use HasAccessAs;
	
	private $listProcessor, $profileObj, $formBuilder, $viewBuilder;

	/**
	 * Constructor Profile Class  Founstie
	 *
	 * 
	 * 
	 * @param ListProcessor $listProcessor list processing
	 */
	public function __construct(
		ListProcessor $listProcessor, 
		Profile $modelObj,
		FormGenerator $formGenerator,
		ViewGenerator $viewGenerator,
		OrganizationInfoRepository $organizationInfo
	)
	{
		$this->listProcessor = $listProcessor;
		$this->profileObj = $modelObj;
		$this->formBuilder = $formGenerator;
		$this->viewBuilder = $viewGenerator;
		$this->organizationInfo = $organizationInfo;
		$this->profile();
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->profileList($request,$corporateId);
		
		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder->newModelForm($this->profileObj)
				->option([
					'position_id' => MasterData::position()->pluck('description','id')
				])
				->required(['*'])
				->notRequired(['is_pm'])
				->mapping([
					'corporate_id' => $corporateId
				])
				->extras([
					'is_pm' => 'checkbox'
				])
				->id($request->segment(5))
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.profile.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function assign(Request $request, int $corporateId)
	{
		$form = $this->formBuilder->newModelForm($this->profileObj)
		->staticForm()
		->extras([
			'project_id' => Project::sameGroup($corporateId)->unassigned($request->segment(5))->pluck('name','id'),
			'role_id' => ProfileRole::pluck('role','id')
		])
		->required(['project_id','role_id'])
		->id($request->segment(5))
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.profile.assign',[$corporateId, $request->segment(5), $request->segment(6)])
		);
		$profile = $this->organizationInfo->getProfile($request->segment(5));

		return compact('form','profile');
	}

	/**
	 * Profile Information Data
	 * 
	 * @param  Request $request     [description]
	 * @param  int     $corporateId [description]
	 * @return [type]               [description]
	 */
	public function view(Request $request, int $corporateId)
	{
		$view = $this->viewBuilder->newView($this->profileObj)
		->relation([
			'user_id' => 'user.id',
			'corporate_id' => 'corporate.name',
		])
		->id($request->segment(5))
		->renderView(
			__('joesama/project::'.$request->segment(1).'.'
				.$request->segment(2).'.'
				.$request->segment(3))
		);

		return compact('view');
	}

} // END class MakeProjectProcessor 