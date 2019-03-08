<?php
namespace Joesama\Project\Http\Processors\Setup; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Model\Process\Step;
use Joesama\Project\Http\Processors\Setup\ListProcessor;
use Joesama\Project\Http\Services\FormGenerator;
use Joesama\Project\Http\Services\ViewGenerator;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Process Manager Record 
 *
 * @package default
 * @author 
 **/
class StepProcessor 
{
	use HasAccessAs;

	/**
	 * Processing all listing
	 * 
	 * @var Joesama\Project\Http\Services\DataGridGenerator
	 */
	private $listProcessor;

	/**
	 * Form Builder Object
	 * 
	 * @var Joesama\Project\Http\Services\FormGenerator
	 */
	private $formBuilder;

	/**
	 * View Builder Object
	 * 
	 * @var Joesama\Project\Http\Services\ViewGenerator
	 */
	private $viewBuilder;

	/**
	 * Current Model Object 
	 * @var Illuminate\Database\Eloquent\Model
	 */
	private $modelObj;

	/**
	 * Define all default dependency
	 * 
	 * @param ListProcessor $listProcessor Listing Processor
	 * @param FormGenerator $formBuilder   Form Generator
	 * @param ViewGenerator $viewBuilder   View Generator
	 * @param Flow          $flowModel     Flow Model
	 */
	public function __construct(
		ListProcessor $listProcessor,
		FormGenerator $formBuilder,
		ViewGenerator $viewBuilder,
		Step $stepModel
	){
		$this->listProcessor = $listProcessor;

		$this->formBuilder = $formBuilder;

		$this->viewBuilder = $viewBuilder;

		$this->modelObj = $stepModel;

		$this->profile();
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$table = $this->listProcessor->step($request,$corporateId, $request->segment(5));
		
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
				->id($request->segment(6))
				->required(['*'])
				->extras([
					'description' => 'textarea'
				])
				->notRequired(['description'])
				->renderForm(
					__('joesama/project::'.$request->segment(1).'.'.$request->segment(2).'.'.$request->segment(3)),
					route('api.step.save',[$corporateId, $request->segment(5), $request->segment(6)])
				);

		return compact('form');
	}

} // END class MakeProjectProcessor 