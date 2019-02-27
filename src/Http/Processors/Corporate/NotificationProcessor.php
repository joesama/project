<?php
namespace Joesama\Project\Http\Processors\Corporate; 

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Joesama\Entree\Facades\NotifyMail;
use Joesama\Project\Traits\HasAccessAs;

/**
 * Client Record 
 *
 * @package default
 * @author 
 **/
class NotificationProcessor 
{
	use HasAccessAs;

	public function __construct(){
		$this->profileRefresh();
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function list(Request $request, int $corporateId)
	{
		$mailing = $this->profileRefresh()->mails->sortByDesc('created_at')->map(function($mail){

			return collect([
				'id' => $mail->id,
				'title' => $mail->title,
				'sender' => app($mail->notifiable_type)->find($mail->notifiable_id),
				'content' => collect(json_decode($mail->content)),
				"read" => $mail->read,
				"aging" => Carbon::parse($mail->created_at)->diffForHumans(),
				"date" => $mail->created_at
			]);
		});

		$perPage = 25;

		$mailing = new LengthAwarePaginator(
			$mailing->forPage($request->get('page'),$perPage),
			$mailing->count(),
			$perPage
		);
		
		$mailing = $mailing->setPath(url()->current());

		return compact('mailing');
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{

		$email = $this->profileRefresh()->mails->where('id',$request->segment(5))->first();

		NotifyMail::read($email->id);

		$content = collect(json_decode($email->content));
		$action = collect(json_decode($email->action));

		return compact('email','content','action');
	}

} // END class ClientProcessor 