<?php
namespace Joesama\Project\Http\Processors\Manager; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Database\Model\Project\Project;
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
class PartnerProcessor 
{
	use HasAccessAs;

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
		$this->profile();
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->partner($request,$corporateId);

		return compact('table');
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function form(Request $request, int $corporateId)
	{
		$partner = Client::whereNotIn(
			'id',
			$this->modelObj->where('id',$request->segment(5))->pluck('client_id')
		)->mapWithKeys(function($client) {
		    return [ $client->id =>   ucwords($client->name) . ' | ' . ucwords($client->manager) ];
		});


		$form = $this->formBuilder
				->newModelForm($this->modelObj)
				->staticForm()
				->mapping([
						'project_id' => $request->segment(5),
						'corporate_id' => $request->segment(4)
				])
				->extras([
					'partner_id' => $partner
				])
				->id($request->segment(5))
				->required(['*'])
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