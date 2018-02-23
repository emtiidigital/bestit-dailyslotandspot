<?php

namespace App\Http\Controllers;

use App\Helper\FindSlots;

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

    public function slotAndSpot(){
        $workers = \App\Worker::all(['id', 'name']);
        return view('welcome', [
            'workers' => $workers
        ]);
    }
}
