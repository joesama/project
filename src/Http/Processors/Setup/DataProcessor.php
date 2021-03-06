<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Master\Master;
use Joesama\Project\Database\Model\Master\MasterData;
use Joesama\Project\Http\Processors\Setup\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Master Record 
 *
 * @package default
 * @author 
 **/
class DataProcessor 
{
	use HasAccessAs;

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		MasterData $masterData
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $masterData;
		$this->profile();
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->master($request,$corporateId);
		
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
				->option([
					'master_id' => Master::pluck('description','id')
				])->default([
					'master_id' => $request->segment(5),
				])
				->id($request->segment(6))
				->required(['*'])
				->notRequired(['formula'])
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.data.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}

	/**
	 * @param  Request $requestd
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{
		$view = $this->viewBuilder
				->newView($this->modelObj)
				->id($request->segment(6))
				->relation([
					'master_id' => 'master.description',
				])
				->renderView(
					__('joesama/project::'.$request->segment(1).'.'
						.$request->segment(2).'.'
						.$request->segment(3))
				);

		$table = $this->listProcessor->data($request,$corporateId);

		return compact('view','table');
	}

} // END class MakeProjectProcessor 