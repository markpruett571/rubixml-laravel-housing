<?php

namespace App\Imports;

use App\Models\HouseSale;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HouseSalesImport implements ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HouseSale([
            'id' => Str::ulid(),
            'house_id' => $row['id'],
            'date' => Carbon::parse($row['date']),
            'price' => $row['price'],
            'bedrooms' => $row['bedrooms'],
            'bathrooms' => $row['bathrooms'],
            'sqft_living' => $row['sqft_living'],
            'sqft_lot' => $row['sqft_lot'],
            'floors' => $row['floors'],
            'waterfront' => $row['waterfront'],
            'view' => $row['view'],
            'condition' => $row['condition'],
            'grade' => $row['grade'],
            'sqft_above' => $row['sqft_above'],
            'sqft_basement' => $row['sqft_basement'],
            'yr_built' => $row['yr_built'],
            'yr_renovated' => $row['yr_renovated'],
            'zipcode' => $row['zipcode'],
            'lat' => $row['lat'],
            'long' => $row['long'],
            'sqft_living15' => $row['sqft_living15'],
            'sqft_lot15' => $row['sqft_lot15'],
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
