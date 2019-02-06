<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Database\Model\Project\Incident;
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
class HseProcessor 
{
	use HasAccessAs;

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Incident $incidentCard
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $incidentCard;
		$this->profile();
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->incident($request,$corporateId);

		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->mapping([
					'project_id' => $request->segment(5),
					'report_by' => auth()->id()
				])->option([
					'incident_id' => MasterData::incident()->pluck('description','id')
				])
				->id($request->segment(5))
				->required(['*'])
				->renderForm(
					__('joesama/project::'
						.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3)
					),
					route('api.incident.save',[
						$corporateId, 
						$request->segment(5), 
						$request->segment(6)]
					)
				);

		return compact('form');

	}

	/**
	 * [view description]
	 * @param  Request  $request     
	 * @param  int      $corporateId corporate  id
	 * @param  int|null $projectId   project id
	 * @param  int|null $hseId       score card id
	 * @return view               
	 */
	public function view(Request $request, int $corporateId, int $projectId = null, int $hseId = null)
	{
		$view = $this->viewBuilder->newView($this->modelObj)
		->relation([
			// 'project_id' => 'project.name',
			// 'severity_id' => 'severity.description',
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