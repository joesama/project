<?php
namespace Joesama\Project\Http\Processors\Api; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Joesama\Entree\Services\Upload\FileUploader;
use Joesama\Project\Database\Repositories\Project\ProjectUploadRepository;

/**
 * Processing All List 
 *
 * @package default
 * @author 
 **/
class UploadProcessor 
{
	private $uploadRepository;

	public function __construct(
		ProjectUploadRepository $projectUpload
	){
		$this->uploadRepository = $projectUpload;
	}

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

					$upload = $this->uploadRepository->registerUploadedFile(
						$projectId,
						$file->getClientOriginalName(),
						$uploader->destination()
					);

					$fileList->push($upload);
				}
			}
		}

		return response()->json($fileList);
	}

	/**
	 * Remove file uploaded data from project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function delete(Request $request,int $corporateId, int $projectId)
	{
		$file = $this->uploadRepository->getFileUploaded($request->segment(6));

		Storage::delete($file->path);

		return $this->uploadRepository->deleteFile($file);
	}

	/**
	 * download file uploaded data to project
	 * 
	 * @param  Request $request
	 * @param  int $corporateId
	 * @param  int $projectId
	 * @return [type]
	 */
	public function download(Request $request,int $corporateId, int $projectId)
	{
		$file = $this->uploadRepository->getFileUploaded($request->segment(6));

		$path = str_replace('storage','public',$file->path);

		return Storage::download($path);
	}

} // END class MakeProjectProcessor 