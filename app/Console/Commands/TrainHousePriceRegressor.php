<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Rubix\ML\CrossValidation\Metrics\SMAPE;
use Rubix\ML\CrossValidation\Reports\ErrorAnalysis;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\PersistentModel;
use Rubix\ML\Persisters\Filesystem;
use Rubix\ML\Regressors\GradientBoost;
use Rubix\ML\Regressors\RegressionTree;

class TrainHousePriceRegressor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'train:house-price-regressor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Train a regressor for housing prices.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        srand(100);

        $this->info('Training regressor for housing prices...');

        $data = DB::table('house_sales')->select(
            'date',
            'bedrooms',
            'bathrooms',
            'sqft_living',
            'sqft_lot',
            'floors',
            'waterfront',
            'view',
            'condition',
            'grade',
            'sqft_above',
            'sqft_basement',
            'yr_built',
            'yr_renovated',
            'zipcode',
            'price'
        )->get();

        $samples = $data->map(function($sample) {
            return [
                'date' => Carbon::parse($sample->date)->timestamp,
                'bedrooms' => (float) $sample->bedrooms,
                'bathrooms' => (float) $sample->bathrooms,
                'sqft_living' => $sample->sqft_living,
                'sqft_lot' => $sample->sqft_lot,
                'floors' => (float) $sample->floors,
                'waterfront' => $sample->waterfront,
                'view' => (string) $sample->view,
                'condition' => $sample->condition,
                'grade' => $sample->grade,
                'sqft_above' => $sample->sqft_above,
                'sqft_basement' => $sample->sqft_basement,
                'yr_built' => (float) $sample->yr_built,
                'yr_renovated' => (float) $sample->yr_renovated,
                'zipcode' => $sample->zipcode,
            ];
        })->toArray();

        $labels = $data->pluck('price')->toArray();

        $dataset = Labeled::build($samples, $labels);
        [$training, $testing] = $dataset->randomize()->split(0.8);

        $model = new GradientBoost(
            new RegressionTree(
                PHP_INT_MAX,
                25,
                1e-5
            ),
            0.1,
            0.8,
            1000,
            1e-4,
            10,
            0.1,
            new SMAPE()
        );

        $estimator = new PersistentModel($model, new Filesystem('house-price-regressor.rbx'));

        $estimator->train($training);

        $estimator->save();

        $predictions = $estimator->predict($testing);

        $report = new ErrorAnalysis();

        $this->info(dump($report->generate($predictions, $testing->labels())));

        $features = collect(array_keys($samples[0]));
        $importances = $features->combine($estimator->featureImportances());

        $this->info(dump($importances));
    }
}
