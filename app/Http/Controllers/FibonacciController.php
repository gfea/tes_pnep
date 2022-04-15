<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class FibonacciController extends Controller
{
    public function index()
    {
        return view('fibonacci');
    }
    public function send(Request $request)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'bilangan' => 'required|numeric|integer',
            ]);
            if ($validator->passes()) {
                $bilangan=$request->bilangan;
                $start=0;
                $end_bil=1;
                $hasil="$start $end_bil";
                for ($i=0; $i < $bilangan-2; $i++) {
                    $out=$end_bil+$start;
                    $hasil=$hasil.' '.$out;
                    $start=$end_bil;
                    $end_bil=$out;
                }
                if ($bilangan == 0){
                    $hasil=0;
                }
                $message= ['message'=>$hasil];
            }else{
                $message=['validate'=>$validator->errors()];
            }
            return response()->json($message, 200);
        }

    }
}
