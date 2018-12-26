<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Project\Client;
use Joesama\Project\Http\Processors\Setup\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class ClientProcessor 
{

	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Client $client
	){
		$this->listProcessor = $listProcessor;
		$this->formBuilder = $formBuilder;
		$this->viewBuilder = $viewBuilder;
		$this->modelObj = $client;
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->client($request,$corporateId);
		
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

		$form = $form->id($request->segment(5))
		->renderForm(
			__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
			route('api.client.save',[$corporateId, $request->segment(5)])
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
		->id($request->segment(5))
		->renderView(
			__('joesama/project::'.$request->segment(1).'.'
				.$request->segment(2).'.'
				.$request->segment(3))
		);

		return compact('view');
	}

} // END class ClientProcessor 