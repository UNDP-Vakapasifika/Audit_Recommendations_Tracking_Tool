<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetricsController extends Controller
{
    public function index()
    {
        $descriptions = [
            [
                'column_title' => 'Metric 1',
                'description' => 'Description for Metric 1',
            ],
            [
                'column_title' => 'Metric 2',
                'description' => 'Description for Metric 2',
            ],
        ];

        return view('metrics', compact('descriptions'));
    }
}
