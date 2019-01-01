<?php
namespace Joesama\Project\Database\Repositories\Project; 

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class FinancialRepository 
{

	/**
	 * Get Claim Transaction for past 24 month
	 * @param  string     $start  [description]
	 * @param  string     $end    [description]
	 * @param  Collection $claims [description]
	 * @return [type]             [description]
	 */
	public function projectClaimTransaction(string $start, string $end, Collection $claims)
	{
		$transactionCollection = $this->getProjectTrasactionRow($start,$end);

		$claims->sortByDesc(function ($product, $key) {
		    return $product['claim_date'];
		})->mapToGroups(function ($item, $key) {
		    return [
		    	Carbon::parse($item['claim_date'])->format('Y') => $item
		    ];
		})->each(function($item, $year) use($transactionCollection){
			
			$item->mapToGroups(function ($item, $key) {
			    return [
			    	Carbon::parse($item['claim_date'])->format('m') => $item
			    ];
			})->each(function($trans, $id) use ($transactionCollection,$year){
				$transactionCollection->get($year)->put(intval($id),$trans);
			});

		});

		return $transactionCollection;
	}

	/**
	 * Get Payment Transaction for past 24 month
	 * @param  string     $start  [description]
	 * @param  string     $end    [description]
	 * @param  Collection $claims [description]
	 * @return [type]             [description]
	 */
	public function projectPaymentTransaction(string $start, string $end, Collection $claims)
	{
		$transactionCollection = $this->getProjectTrasactionRow($start,$end);

		$claims->sortByDesc(function ($product, $key) {
		    return $product['payment_date'];
		})->mapToGroups(function ($item, $key) {
		    return [
		    	Carbon::parse($item['payment_date'])->format('Y') => $item
		    ];
		})->each(function($item, $year) use($transactionCollection){
			
			$item->mapToGroups(function ($item, $key) {
			    return [
			    	Carbon::parse($item['payment_date'])->format('m') => $item
			    ];
			})->each(function($trans, $id) use ($transactionCollection,$year){
				$transactionCollection->get($year)->put(intval($id),$trans);
			});

		});

		return $transactionCollection;
	}


	/**
	 * undocumented function
	 *
	 * @return void
	 * @author 
	 **/
	public function balanceSheet($project)
	{
		$contract = data_get($project,'value');
		$payment = data_get($project,'payment')->sum('paid_amount');

		return number_format($contract - $payment,2);
	}


	/**
	 * Build all trasaction Row
	 * @param  string $start
	 * @param  string $end
	 * @return Illuminate\Support\Collection
	 */
	protected function getProjectTrasactionRow(string $start, string $end)
	{	

		$transaction = collect([]);

		if (strtotime($start) !== false && strtotime($end) !== false) {

			$period = CarbonPeriod::start(Carbon::parse($start)->format('Y-m-d'))
			          ->end(Carbon::parse($end)->format('Y-m-d'))
			          ->setRecurrences(3)
			          ->years();

			foreach ($period as $key => $date) {

			    if($key != 0){

			    	$months = CarbonPeriod::start($date->startOfYear());

			    }else{
			    	$months = CarbonPeriod::start($date);
			    }

			   	$endMonth = $date->endOfYear();

		        $months->end($endMonth)
		          ->setRecurrences(12)
		          ->month();

				$monthTrans = collect([]);

				foreach ($months as $key => $dates) {

					$monthTrans->put(intval($dates->format('m')),0);
				}

				$transaction->put($date->format('Y'),$monthTrans);

			}
		}

		return $transaction;

	}


} // END class FinancialRepository 