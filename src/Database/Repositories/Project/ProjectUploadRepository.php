<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Joesama\Project\Database\Model\Project\ProjectUpload;
use Joesama\Project\Traits\HasAccessAs;

class ProjectUploadRepository 
{	
	use HasAccessAs;

	/**
	 * Get file data for uploaded file
	 * 
	 * @param  int    $id 
	 * @return object
	 */
	public function getFileUploaded(int $id)
	{
		return ProjectUpload::find($id);
	}

	/**
	 * Register Upload File
	 * 
	 * @param  int    $projectId [description]
	 * @param  string $label     [description]
	 * @param  string $url       [description]
	 * @return [type]            [description]
	 */
	public function registerUploadedFile( int $projectId, string $label, string $url )
	{
		DB::beginTransaction();

		try{

			$upload = new ProjectUpload();

			$upload->label = $label;

			$upload->path = $url;

			$upload->project_id = $projectId;

			$upload->upload_by = \Auth()->id();

			$upload->save();

			DB::commit();

		return $upload;	

		}catch( \Exception $e){

			DB::rollback();

			dd($e->getMessage());
		}
	}

	/**
	 * List of Project Upload
	 * 
	 * @param int $corporateId - id for specific corporate
	 * @param int $projectId
	 **/
	public function listUpload(int $corporateId, $projectId)
	{
		return ProjectUpload::whereHas('project',function($query) use($corporateId, $projectId){
			$query->sameGroup($corporateId);
		})->where('project_id',$projectId)->orderBy('created_at','desc')->paginate();
	}

	/**
	 * Remove uploaded file attached to project
	 * 
	 * @param  ProjectUpload    $uploadObj 	Object of the uploaded file
	 * @return 
	 */
	public function deleteFile(ProjectUpload $uploadObj)
	{

		DB::beginTransaction();

		try{

			$uploadObj->delete();

			DB::commit();

		}catch( \Exception $e){

			DB::rollback();
			dd($e->getMessage());
		}
	}

} // END class ProjectUploadRepository 