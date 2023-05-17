<?php

namespace App\Jobs;

use App\Events\HouseSalePriceEstimated;
use App\Models\HouseSale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;

class EstimateHouseSalePrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $id)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $estimator = PersistentModel::load(new Filesystem(base_path('house-price-regressor.rbx')));

        $houseSale = HouseSale::find($this->id);

        $dataset = new Unlabeled([[
            Carbon::parse($houseSale->date)->timestamp,
            (float) $houseSale->bedrooms,
            (float) $houseSale->bathrooms,
            $houseSale->sqft_living,
            $houseSale->sqft_lot,
            (float) $houseSale->floors,
            $houseSale->waterfront,
            (string) $houseSale->view,
            $houseSale->condition,
            $houseSale->grade,
            $houseSale->sqft_above,
            $houseSale->sqft_basement,
            (float) $houseSale->yr_built,
            (float) $houseSale->yr_renovated,
            $houseSale->zipcode,
        ]]);

        $estimation = $estimator->predict($dataset);

        $houseSale->estimated_price = ceil($estimation[0]);
        $houseSale->save();

        HouseSalePriceEstimated::broadcast($this->id, $houseSale->estimated_price);
    }
}
