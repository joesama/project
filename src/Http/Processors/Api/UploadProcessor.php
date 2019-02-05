<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Joesama\Entree\Services\Upload\FileUploader;

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
		if ($request->hasFile('upload') && $request->file('upload')->isValid()) {

			$absolutePath = storage_path($request->file('client').'/'.$corporateId.'/upload/');

			$uploader = new FileUploader($request->file('upload'),$this);

		    return url($uploader->destination());
		}
	}


} // END class MakeProjectProcessor 