<?php

namespace App\Http\Controllers;

use App\Models\HouseSale;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HouseSalesController extends Controller
{
    public function index()
    {
        $houseSales = HouseSale::orderByDesc('id')->paginate(10);

        return Inertia::render('HouseSales/Index', compact('houseSales'));
    }

    public function edit(string $id)
    {
        $houseSale = HouseSale::find($id);

        return Inertia::render('HouseSales/Edit', compact('houseSale'));
    }
}
