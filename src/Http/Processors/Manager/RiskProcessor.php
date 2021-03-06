<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Risk;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Risk Record 
 *
 * @package default
 * @author 
 **/
class RiskProcessor 
{
	use HasAccessAs;
	
	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Risk $risk
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $risk;
		$this->profile();
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->risk($request,$corporateId);

		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder->newModelForm($this->modelObj);

		if(is_null($request->segment(5))){
			$form->extras([
				'project_id' => Project::sameGroup($corporateId)->pluck('name','id')
			]);
		}else{
			$form = $form->mapping([
				'project_id' => $request->segment(5)
			]);
		}

		$form = $form->option([
					'severity_id' => MasterData::severity()->pluck('description','id')
				])->extras([
					'status_id' => MasterData::active()->pluck('description','id')
				])
				->id($request->segment(6))
				->required(['*'])
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.risk.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);
 
		return compact('form');

	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$view = $this->viewBuilder->newView($this->modelObj)
		->relation([
			'project_id' => 'project.name',
			'severity_id' => 'severity.description',
			'status_id' => 'status.description',
		])
		->id($request->segment(6))
		->renderView(
			__('joesama/project::'.$request->segment(1).'.'
				.$request->segment(2).'.'
				.$request->segment(3))
		);

		return compact('view');
	}

} // END class MakeProjectProcessor 