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
class MasterProcessor 
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
		$master = $this->masterRepo->initMaster(collect($request->all()),$request->segment(5));

		return redirect_with_message(
			handles('setup/'.$request->segment(2).'/list/'.$corporateId),
			trans('joesama/entree::respond.data.success', [
				'form' => trans('joesama/project::setup.'.$request->segment(2).'.form')
			]),
            'success'
		);
	}


} // END class MakeProjectProcessor 