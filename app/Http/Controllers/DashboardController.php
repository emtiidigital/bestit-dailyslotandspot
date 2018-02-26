<?php

namespace App\Http\Controllers;

use App\Helper\FindSlots;
use App\Worker;

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

        return view('slotAndSpot', [
            'coll' => $coll,
            'previousValue' => $coll->first()['position'],
        ]);
    }

    public function slotAndSpot(){
        $employees = Worker::all(['id', 'name']);

        return view('dashboard', compact('employees'));
    }
}
