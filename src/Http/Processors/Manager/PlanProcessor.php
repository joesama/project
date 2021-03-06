<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Database\Model\Project\Plan;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Project Record 
 *
 * @package default
 * @author 
 **/
class PlanProcessor 
{
	use HasAccessAs;

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Plan $plan
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $plan;
		$this->profile();
	}
        
        /**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
                
		$table = $this->listProcessor->plan($request,$corporateId);
		
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

		$tags = 'main';

		if(is_null($request->segment(5))){
			$form->extras([
				'project_id' => Project::sameGroup($corporateId)->pluck('name','id')
			]);
		}else{
			$form = $form->mapping([
				'project_id' => $request->segment(5),
			]);
		}

		if(!is_null($request->segment(6))){
			$form->extras([
				'task_progress' => 'text'
			]);

			$form->readonly(['end','start']);

			$tagCollection = $this->modelObj->find($request->segment(6))->tags;

			$tags = ($tagCollection->isNotEmpty()) ? $tagCollection->pluck('label')->implode(',') : $tags;
		}

		$project = Project::with('plan')->find($request->segment(5));

		$lastUseDate = ($project->task->isEmpty()) ? $project->start : $project->task->last()->end;

		$newStartDate = Carbon::parse($lastUseDate)->addDays(7);

		$newEndDate = ($newStartDate < $project->end) ? Carbon::parse($newStartDate)->addDays(2) : Carbon::parse($project->end);
                
		$form = $form->option([
					'profile_id' => Profile::sameGroup($corporateId)->pluck('name','id'),
					'status_id' => MasterData::task()->pluck('description','id'),
					'indicator_id' => MasterData::indicator()->pluck('description','id')
				])->default([
					'task_progress' => data_get($this->modelObj->find($request->segment(6)),'progress.progress',0),
					'start' => $newStartDate,
					'end' => $newEndDate,
					'group' => $tags,
					'profile_id' => $this->profile()->id,
				])->extras([
					'description' => 'textarea',
					'duration' => 'range',
                    'days'=>'text'
				])->readonly(['days']);

		if(!is_null($request->segment(6))){
			$form->readonly(['planned_progress','duration']);	
		}

		$form = $form->excludes(['planned_progress','effective_days','actual_progress','start','end'])
				->id($request->segment(6))
				->required(['*'])
                                ->notRequired(['description'])
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.plan.save',[$corporateId, $request->segment(5), $request->segment(6)])
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
			'profile_id' => 'assignee.name', 
			'actual_progress' => 'progress.progress' 
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