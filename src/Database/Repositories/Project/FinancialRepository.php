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
                $transCollection->get($year)->put(intval($id), $trans);
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
        return collect([
            'monthTrans' => collect($transData->get(Carbon::now()->format('Y'))
                        ->get(intval(Carbon::now()->format('m'))))
                        ->sum($amount),
            'ytd' => collect($transData->get(Carbon::now()->format('Y'))->flatten(1))->sum($amount),
            'ttd' => collect($transData->flatten(2))->sum($amount),
            'sparlineData' => $transData->flatten(2)->pluck($amount)->map(function ($item) {
                return is_null($item) ? 0 :$item;
            })->toArray()
        ]);
    }


    /**
     * Get Remaining Financial calculation
     *
     * @return Illuminate\Support\Collection
     **/
    public function balanceSheet($project)
    {
        $contract = data_get($project, 'value');
        $payment = data_get($project, 'payment')->sum('paid_amount');
        $voo = data_get($project, 'vo')->sum('amount');
        $rentention = data_get($project, 'retention')->sum('amount');
        $lad = data_get($project, 'lad')->sum('amount');

        return number_format($contract + $voo + $rentention - $lad - $payment, 2);
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
