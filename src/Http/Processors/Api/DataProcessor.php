<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Project\Database\Repositories\Setup\MasterDataRepository;

/**
 * Processing All Operation 
 *
 * @package default
 * @author 
 **/
class DataProcessor 
{

	public function __construct(
		MasterDataRepository $masterRepo
	){
		$this->masterRepo = $masterRepo;
	}

	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId)
	{
		$master = $this->masterRepo->initData(collect($request->all()),$request->segment(6));

		return redirect_with_message(
			handles('setup/master/view/'.$corporateId.'/'.$request->segment(5)),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::setup.'.$request->segment(2).'.form')
			]),
            'success'
		);
	}


} // END class MakeProjectProcessor 