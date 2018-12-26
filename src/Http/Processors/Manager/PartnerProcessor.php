<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\Project;
use Joesama\Project\Http\Processors\Manager\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;

/**
 * Risk Record 
 *
 * @package default
 * @author 
 **/
class PartnerProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Project $project
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $project;
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
		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->staticForm()
				->mapping([
						'project_id' => $request->segment(5),
						'corporate_id' => $request->segment(4)
				])
				->extras([
					'partner_id' => Client::pluck('name','id')
				])
				->id($request->segment(5))
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.partner.save',[$corporateId, $request->segment(5), $request->segment(6)])
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