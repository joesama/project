<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Entree\Services\Upload\FileUploader;
use Joesama\Project\Database\Model\Project\ProjectUpload;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class UploadProcessor 
{
	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function save(Request $request,int $corporateId)
	{
		$projectId = $request->segment(5);

		$files = $request->file('upload');

		$absolutePath = storage_path($request->file('client').'/'.$corporateId.'/'.$projectId.'/upload/');

		$fileList = collect([]);

		if($request->hasFile('upload')){
			if(!is_array($files)){
				$files = [$files ];
			}

			foreach($files as $file){
				if($file->isValid()){
					$uploader = new FileUploader($file,$this);

					$upload = new ProjectUpload();
					$upload->label = $file->getClientOriginalName();
					$upload->path = $uploader->destination();
					$upload->project_id = $projectId;
					$upload->upload_by = \Auth()->id();
					$upload->save();

					$fileList->push($upload);
				}
			}
		}


		return response()->json($fileList);
	}


} // END class MakeProjectProcessor 