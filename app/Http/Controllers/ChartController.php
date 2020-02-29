<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ChartController extends Controller
{
    public function index() {
        $data['year_list'] = $this->fetch_year();
        return view('charts')->with($data);
    }

    public function fetch_year() {
        $data = DB::table('chart_data')->select(DB::raw('year'))->groupBy('year')->orderBy('year', 'DESC')->get();
        return $data;
    }

    public function fetch_data(Request $request) {
        if($request->input('year'))
        {

         $chart_data = $this->fetch_chart_data($request->input('year'));
   
         foreach($chart_data->toArray() as $row)
         {
       
          $output[] = array(
           'month'  => $row->month,
           'profit' => floatval($row->profit)
          );
         }
     
         echo json_encode($output);
        }
    }

    function fetch_chart_data($year)
    {
     $data =  DB::table('chart_data')->orderBy('year', 'ASC')->where('year', $year)->get();
     return $data;
    }
}
