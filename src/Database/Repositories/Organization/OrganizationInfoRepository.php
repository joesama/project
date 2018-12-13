<?php
namespace Joesama\Project\Database\Repositories\Organization; 

use Joesama\Project\Database\Model\Organization\Corporate;
use DB;

/**
 * Data Handling For Organization Record
 *
 * @package default
 * @author 
 **/
class OrganizationInfoRepository 
{

	public function __construct(Corporate $model)
	{
		$this->corporatetModel = $model;
	}

	/**
	 * Corporate Record By Id
	 *
	 * @param int $corporateId
	 **/
	public function getCorporate(int $corporateId)
	{
		return $this->corporatetModel->find($corporateId);
	}

	/**
	 * List of Corporate
	 **/
	public function listCorporate()
	{
		return $this->corporatetModel->whereNull('child_to')->get();
	}


} // END class MakeProjectRepository 