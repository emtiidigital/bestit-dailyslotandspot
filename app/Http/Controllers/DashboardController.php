<?php

namespace App\Http\Controllers;

use App\Helper\FindSlots;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $findSlots = new FindSlots();
        $coll = $findSlots->getSlotAndSpot();

        return view('dashboard', [
            'coll' => $coll,
            'previousValue' => $coll->first()['position'],
        ]);
    }
}
