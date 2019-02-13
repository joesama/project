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
		$mailing = $this->profile()->mails->map(function($mail){

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

		$mailing = new LengthAwarePaginator(
			$mailing,
			$mailing->count(),
			20
		);
		
		return compact('mailing');
	}


	/**
	 * @param  Request $request
	 * @param  int $corporateId
	 * @return mixed
	 */
	public function view(Request $request, int $corporateId)
	{

		$email = $this->profile()->mails->where('id',$request->segment(5))->first();

		NotifyMail::read($email->id);

		$content = collect(json_decode($email->content));

		return compact('email','content');
	}

} // END class ClientProcessor 