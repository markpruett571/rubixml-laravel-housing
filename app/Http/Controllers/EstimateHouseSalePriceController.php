<?php

namespace App\Http\Controllers;

use App\Jobs\EstimateHouseSalePrice;

class EstimateHouseSalePriceController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id)
    {
        EstimateHouseSalePrice::dispatch($id);
    }
}
