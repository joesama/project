<?php
namespace Joesama\Project\Http\Services;

use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Organization\Profile;
use Joesama\Project\Database\Model\Process\Flow;

class ProcessFlowManager
{
	/**
	 * Process Flow Model
	 * 
	 * @var collection
	 */
	private $flowProcess;

	/**
	 * Coporate Id
	 * @var int
	 */
	private $corporateId;

	/**
	 * Collection of profile in same corporation
	 * @var Illuminate\Support\Collection
	 */
	private $profileInGroup;

	/**
	 * Collection of profile from cross corporation
	 * @var Illuminate\Support\Collection
	 */
	private $profileCrossOrganization;

	/**
	 * Collection of profile from parent corporation
	 * @var Illuminate\Support\Collection
	 */
	private $profileInParentGroup;

	/**
	 * Collection mapped flow & steps
	 * @var Illuminate\Support\Collection
	 */
	private $mappedFlowProcess;

	/**
	 * Define Process Flow & Profile For Respective Corporation
	 * 
	 * @param int $corporateId Corporation Id
	 */
	public function __construct(int $corporateId)
	{
		$this->corporateId = $corporateId;

		$this->flowProcess = $this->getAllAvailableProcess();

		$this->profileInGroup = $this->sameGroupProfile();

		$this->profileInParentGroup = $this->parentGroupProfile();

		$this->profileCrossOrganization = $this->crossOrgProfile();

		$this->mappedFlowProcess = $this->mappingStepWithProfile();

	}

	/**
	 * Mapping ALl Flow & Step Roles To Respective Profile List 
	 * 
	 * @return Illuminate\Support\Collection
	 */
	private function mappingStepWithProfile()
	{
		return $this->flowProcess->map(function($flow) {

			$steps = data_get($flow,'steps')->map(function($step)
			{
				$profile = ($step->cross_organisation == 1) ? $this->profileCrossOrganization : $this->profileInGroup;

				return collect([
					'cross' => $step->cross_organisation,
					'id' => $step->id,
					'label' => $step->label,
					'role' => data_get($step,'role.role'),
					'role_id' => data_get($step,'role.id'),
					'status' => data_get($step,'status.description'),
					'status_id' => data_get($step,'status.id'),
					'profile_list' => $profile,
					'profile_assign' => null
				]);
			});

			return collect([
				'id' => data_get($flow,'id'),
				'flow' => ucwords(data_get($flow,'label')),
				'steps' => $steps
			]);

		});	
	}

	/**
	 * List all role involve in the process then mapped to cross & role
	 * 
	 * @return Illuminate\Support\Collection
	 */
	public function formRoleListing()
	{
		return $this->mappedFlowProcess->pluck('steps')->flatten(1)
				->groupBy(['cross','role_id','status_id'])->map(function( $crossItem, $cross )
				{
					return $crossItem->map(function($roleItem , $roleId) use ( $cross ) 
					{
						return $roleItem->map(function($statusItem , $statusId) use ( $cross, $roleId )
						{
							$sub = $statusItem->first();

							return collect([
								'identifier' => $cross .'_'. $roleId  .'_'. $statusId,
								'cross' => $cross,
								'role_id' => $sub->get('role_id'),
								'role' => $sub->get('role'),
								'status' => $sub->get('status'),
								'status_id' => $sub->get('status_id'),
								'label' => ucwords($statusItem->pluck('label')->implode(', ')),
								'profile' => $sub->get('profile_list')
							]);
						});
					});
				})->flatten(2);

	}

	/**
	 * Generate entity for form generator
	 * 
	 * @return array
	 */
	public function getFormGeneratorEntity()
	{
		return $this->formRoleListing()->mapWithKeys(function($item){
					return [ $item->get('identifier') => $item->get('profile') ];
				});
	}

	/**
	 * Retrieve All Process Flow For Corporation
	 * 
	 * @return Illuminate\Eloquent\Collection
	 */
	private function getAllAvailableProcess()
	{
		if ( !$this->flowProcess ){
			return Flow::sameGroup($this->corporateId)->with([ 'steps' => function($query){
				$query->with(['status','role']);
			} ])->get();
		}

		return $this->flowProcess;
	}

	/**
	 * Get All Profile In Same Corporation
	 *
	 * @return Illuminate\Eloquent\Collection
	 */
	private function sameGroupProfile()
	{
		if ( !$this->profileInGroup ){
			return Profile::sameGroup($this->corporateId)->pluck('name','id');
		}

		return $this->profileInGroup;
	}

	/**
	 * Get All Profile From Cross Corporation
	 * 
	 * @return Illuminate\Eloquent\Collection
	 */
	private function crossOrgProfile()
	{
		if ( !$this->profileCrossOrganization ){
			return Profile::crossOrganization()->pluck('name','id');
		}

		return $this->profileCrossOrganization;
	}

	/**
	 * Get All Profile From Parent Corporation
	 * 
	 * @return Illuminate\Eloquent\Collection
	 */
	private function parentGroupProfile()
	{
		if ( !$this->profileInParentGroup ){
			return Profile::fromParent()->pluck('name','id');
		}

		return $this->profileInParentGroup;
	}

}