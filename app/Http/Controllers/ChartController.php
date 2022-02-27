<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\NetProfit;

class ChartController extends Controller
{
    public function index() {
        $fetch_year = $this->fetch_year();
        return view('charts', compact('fetch_year', $fetch_year));
    }

    public function fetch_year() {
        $data =  NetProfit::select("year")->groupBy('year')->orderBy('year', 'DESC')->get();
        return $data;
    }

    public function fetch_data(Request $request) {
        if($request->input('year'))
        {
         $chart_data = $this->fetch_chart_data($request->input('year'));
         foreach($chart_data->toArray() as $row)
         {
         
          $output[] = array(
           'month'  => $row['month'],
           'profit' => floatval($row['profit'])
          );
         }
         echo json_encode($output);
        }
    }

    function fetch_chart_data($year)
    {
     $data =  NetProfit::select("id", "year", "profit", "month")->orderBy('year', 'ASC')->where('year', $year)->get();
     return $data;
    }
}
