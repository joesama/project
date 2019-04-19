<?php
namespace Joesama\Project\Database\Repositories\Project;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Joesama\Project\Database\Model\Project\FinanceMilestone;
use Joesama\Project\Traits\ProjectCalculator;

class FinancialRepository
{
    use ProjectCalculator;

    /**
     * Get Claim Transaction for past 24 month
     *
     * @param  string     $start  [description]
     * @param  string     $end    [description]
     * @param  Collection $claims [description]
     * @return Illuminate\Support\Collection
     */
    public function projectClaimTransaction(string $start, string $end, Collection $claims)
    {
        $transCollection = $this->getProjectTrasactionRow($start, $end);

        $claims->sortByDesc(function ($product, $key) {
            return $product['claim_date'];
        })->mapToGroups(function ($item, $key) {
            return [
                Carbon::parse($item['claim_date'])->format('Y') => $item
            ];
        })->each(function ($item, $year) use ($transCollection) {
            $item->mapToGroups(function ($item, $key) {
                return [
                    Carbon::parse($item['claim_date'])->format('m') => $item
                ];
            })->each(function ($trans, $id) use ($transCollection, $year) {
                $transCollection->get($year)->put(intval($id), $trans);
            });
        });

        return $transCollection;
    }

    /**
     * Get Payment Transaction for past 24 month
     *
     * @param  string     $start  [description]
     * @param  string     $end    [description]
     * @param  Collection $claims [description]
     * @return Illuminate\Support\Collection
     */
    public function projectPaymentTransaction(string $start, string $end, Collection $claims)
    {
        $transCollection = $this->getProjectTrasactionRow($start, $end);

        $claims->sortByDesc(function ($product, $key) {
            return $product['payment_date'];
        })->mapToGroups(function ($item, $key) {
            return [
                Carbon::parse($item['payment_date'])->format('Y') => $item
            ];
        })->each(function ($item, $year) use ($transCollection) {
            $item->mapToGroups(function ($item, $key) {
                return [
                    Carbon::parse($item['payment_date'])->format('m') => $item
                ];
            })->each(function ($trans, $id) use ($transCollection, $year) {
                $transCollection->get($year)->put(intval($id), $trans);
            });
        });

        return $transCollection;
    }


    /**
     * Get VO transaction
     *
     * @param  string     $start project start date
     * @param  string     $end   project start date
     * @param  Collection $vo    collection of vo
     * @return array
     */
    public function projectVoTransaction(string $start, string $end, Collection $voo)
    {
        $transCollection = $this->getProjectTrasactionRow($start, $end);

        $voo->sortByDesc(function ($product, $key) {
            return $product['date'];
        })->mapToGroups(function ($item, $key) {
            return [
                Carbon::parse($item['date'])->format('Y') => $item
            ];
        })->each(function ($item, $year) use ($transCollection) {
            $item->mapToGroups(function ($item, $key) {
                return [
                    Carbon::parse($item['date'])->format('m') => $item
                ];
            })->each(function ($trans, $id) use ($transCollection, $year) {
                $transCollection->get($year)->put(intval($id), $trans);
            });
        });
        return $transCollection;
    }

    /**
     * Get Retention transaction
     *
     * @param  string     $start        project start date
     * @param  string     $end          project start date
     * @param  Collection $retention    collection of retention
     * @return array
     */
    public function projectRetentionTransaction(string $start, string $end, Collection $retention)
    {
        $transCollection = $this->getProjectTrasactionRow($start, $end);

        $retention->sortByDesc(function ($product, $key) {
            return $product['date'];
        })->mapToGroups(function ($item, $key) {
            return [
                Carbon::parse($item['date'])->format('Y') => $item
            ];
        })->each(function ($item, $year) use ($transCollection) {
            $item->mapToGroups(function ($item, $key) {
                return [
                    Carbon::parse($item['date'])->format('m') => $item
                ];
            })->each(function ($trans, $id) use ($transCollection, $year) {
                $transCollection->get($year)->put(intval($id), $trans);
            });
        });

        return $transCollection;
    }

    /**
     * Get component transaction data
     *
     * @param  string     $start        project start date
     * @param  string     $end          project start date
     * @param  Collection $component    collection of retention
     * @param  string     $date         date specific to component
     * @param  string     $amount       amount specific to component
     * @return array
     */
    public function projectComponentTransaction(
        string $start,
        string $end,
        Collection $component,
        string $date = 'date'
    ) {
        $transCollection = $this->getProjectTrasactionRow($start, $end);

        $component->sortByDesc(function ($product, $key) use ($date) {
            return $product[$date];
        })->mapToGroups(function ($item, $key) use ($date) {
            return [
                Carbon::parse($item[$date])->format('Y') => $item
            ];
        })->each(function ($item, $year) use ($transCollection, $date) {
            $item->mapToGroups(function ($item, $key) use ($date) {
                return [
                    Carbon::parse($item[$date])->format('m') => $item
                ];
            })->each(function ($trans, $id) use ($transCollection, $year) {
                $paymentByclient = $trans->mapToGroups(function ($payment, $key){
                    return [
                        data_get($payment,'recipient.name') => $payment
                    ];
                });

                $transCollection->get($year)->put(intval($id), $paymentByclient);
            });
        });

        return $transCollection;
    }


    /**
     * Get Data For Sparkline
     * @param  Collection $transData    Process data
     * @return Collection
     */
    public function getSparklineData(Collection $transData, string $amount = 'amount')
    {
        $currentYear = Carbon::now()->format('Y');

        $currentMonth = Carbon::now()->format('m');

        $transDataCurYear = collect($transData->get($currentYear));

        $transDataCurMonth = collect($transDataCurYear->get((int)$currentMonth));

        $clientMontDets = $transDataCurMonth->filter(function($item){
            return $item instanceof Collection;
        })->flatMap(function($payment, $client) use($amount){
            return [ $client => collect([ 
                'detail' => $payment,
                'amount' => $payment->sum($amount)
                ])
            ];
        });
        
        $clientYearDets = collect([]);

        $transDataCurYear->filter(function($item){
            return $item instanceof Collection;
        })->each(function($yearPay, $monthOf) use($clientYearDets) {
            $yearPay->each(function($yearLy, $client) use($clientYearDets) {
                $clientYearDets->put($client, $yearLy->merge(collect($clientYearDets->get($client))));
            });
        });

        $clientYearDets = $clientYearDets->flatMap(function($payment, $client) use($amount){
            return [ $client => collect([ 
                'detail' => $payment,
                'amount' => $payment->sum($amount)
                ])
            ];
        });

        $tillDate = collect([]);

        $transData->flatten(1)->filter(function($item){
            return $item instanceof Collection;
        })->each(function($yearPay, $monthOf) use($tillDate) {
            $yearPay->each(function($yearLy, $client) use($tillDate) {
                $tillDate->put($client, $yearLy->merge(collect($tillDate->get($client))));
            });
        });

        $tillDate = $tillDate->flatMap(function($payment, $client) use($amount){
            return [ $client => collect([ 
                'detail' => $payment,
                'amount' => $payment->sum($amount)
                ])
            ];
        });

        return collect([
            'field' => $amount,
            'monthTrans' => $transDataCurMonth->flatten(1)->sum($amount),
            'monthTransDets' => $clientMontDets,
            'ytd' => $transDataCurYear->flatten(2)->sum($amount),
            'yearDetails' => $clientYearDets,
            'ttd' => collect($transData->flatten(3))->sum($amount),
            'tillDate' => $tillDate,
            'sparlineData' => $transData->flatten(3)->pluck($amount)->map(function ($item) {
                return is_null($item) ? 0 : (float)$item;
            })->toArray()
        ]);
    }


    /**
     * Get Remaining Financial calculation
     *
     * @return Illuminate\Support\Collection
     **/
    public function balanceSheet($project): Collection
    {
        $clientId = data_get($project, 'client_id');

        $contract = data_get($project, 'value');

        $paymentIn = data_get($project, 'payment')->where('client_id',$clientId)->sum('paid_amount');

        $paymentOut = data_get($project, 'payment')->whereNotIn('client_id',[$clientId])->sum('paid_amount');

        $voo = data_get($project, 'vo')->sum('amount');

        $rententionTo = data_get($project, 'retention')->where('client_id',$clientId)->sum('amount');

        $rententionBy = data_get($project, 'retention')->whereNotIn('client_id',[$clientId])->sum('amount');

        $ladBy = data_get($project, 'lad')->where('client_id',$clientId)->sum('amount');

        $ladTo = data_get($project, 'lad')->whereNotIn('client_id',[$clientId])->sum('amount');

        $balanceContract = (float)(($contract + $voo + $rententionTo) - $paymentIn - $ladBy);

        $financialend = (float)(($balanceContract - $paymentOut - $rententionBy) + $ladTo);

        return collect([
            'balanceContract' => $balanceContract,
            'financialend' => $financialend,
            'paymentIn' => $paymentIn,
            'paymentOut' => $paymentOut,
            'rententionTo' => $rententionTo,
            'rententionBy' => $rententionBy,
            'ladBy' => $ladBy,
            'ladTo' => $ladTo,
        ]);
    }


    /**
     * Build all trasaction Row
     *
     * @param  string $start
     * @param  string $end
     * @return Illuminate\Support\Collection
     */
    protected function getProjectTrasactionRow(string $start, string $end)
    {
        $transaction = collect([]);

        if (strtotime($start) !== false && strtotime($end) !== false) {
            $end = (Carbon::parse($end)->month == Carbon::parse($start)->month) ? Carbon::parse()->addMonth()->format('Y-m-d') : $end;

            $yearDiff = Carbon::parse($start)->diffInMonths(Carbon::parse($end));

            $period = CarbonPeriod::since($start)
                      ->until($end)
                      ->months($yearDiff)
                      ->month();

            $groupByYear = collect($period->toArray())->groupBy(function ($date, $key) {
                return Carbon::parse($date)->year;
            });

            $groupByYear->each(function ($item, $key) use ($transaction) {
                $monthTrans = collect([]);
                $item->each(function ($subitem) use ($monthTrans) {
                    $monthTrans->put(intval($subitem->format('m')), 0);
                });

                $transaction->put($key, $monthTrans);
            });
        }

        return $transaction;
    }

    /**
     * Schedule Payment
     *
     * @param  Collection $payment  All Payment Schedule For Project
     * @return Collection
     */
    public function schedulePayment(int $projectId)
    {
        $milestone = FinanceMilestone::where('project_id', $projectId)->get();
        
        $latest = $milestone->filter(function ($miles) {
            return Carbon::parse($miles->progress_date)->endOfMonth()->equalTo(Carbon::now()->endOfMonth());
        })->first();

        return collect([
                'planned' => $milestone->pluck('planned')->prepend('Planned'),
                'actual' => $milestone->pluck('actual')->prepend('Actual'),
                'categories' => $milestone->pluck('label'),
                'variance' => $this->shortHandFormat(floatval(data_get($latest, 'actual')) - floatval(data_get($latest, 'planned'))),
                'latest' => $latest,
            ]);
    }
} // END class FinancialRepository
