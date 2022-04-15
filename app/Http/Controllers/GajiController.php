<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataGaji;
use Validator;

class GajiController extends Controller
{
    public function index()
    {
        return view('gaji');
    }
    public function show_add()
    {
        return view('add_gaji');
    }
    public function show_edit()
    {
        return view('edit_gaji');
    }
    public function show_gaji(Request $request,DataGaji $data_gaji)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $data_gaji=$data_gaji->get();
            $ada=false;
            if ($data_gaji) {
                $ret='<tr>';
                $no=1;
                foreach ($data_gaji as $d) {
                    $aksi='<a href="gaji/show_edit/'.$d->id.'" class="btn btn-info">Edit</a> <button onclick="delete_modal('.$d->id.')" class="btn btn-danger">Delete</button>';
                    $ret.='<td>'.$no.'.</td>';
                    $ret.='<td>'.$d->nik.'</td>';
                    $ret.='<td>'.$d->nama.'</td>';
                    $ret.='<td>'.date('d/m/Y',strtotime($d->tanggal_gaji)).'</td>';
                    $ret.='<td>'.number_format($d->gaji,2).'</td>';
                    $ret.='<td><label class="label label-info" title="Tanggal Dibuat">'.date('d/m/Y',strtotime($d->created_at)).'</label><br><label class="label label-info" title="Tanggal Diedit">'.date('d/m/Y',strtotime($d->updated_at)).'</label></td>';
                    $ret.='<td>'.$aksi.'</td>';
                    $no++;
                $ada=true;
                }
                $ret.='</tr>';

            }
            if ($ada){
                $message= ['message'=>$ret];
            }else{
                $ret='<tr><td class="text-center" colspan="7">Data Kosong</td></tr>';
                $message= ['message'=>$ret];
            }
            return response()->json($message, 200);
        }

    }
    public function add(Request $request, DataGaji $data_gaji)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $id=$request->id;
            $validator = Validator::make($request->all(), DataGaji::rules($id));
            $validator->setAttributeNames(DataGaji::attributeNames());
            if ($validator->passes()) {
                $data=[
                    'nik'=>$request->nik,
                    'nama'=>$request->nama,
                    'gaji'=>$request->gaji,
                    'tanggal_gaji'=>$request->tanggal_gaji,
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
                $message= ($data_gaji->insert($data)) ? 'Data Berhasil Diinput' : 'Data Gagal Diinput';
                $message=['message'=>$message];
            }else{
                $message=['validate'=>$validator->errors(),'msg'=>__('messages.check_input')];
            }
            return response()->json($message, 200);
        }
    }
    public function delete(Request $request, DataGaji $data_gaji)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $id=$request->id;
            if ($id) {
                $message= ($data_gaji->destroy($id)) ? 'Data Berhasil Dihapus' : 'Data Gagal Dihapus';
                $message=['message'=>$message];
            }else{
                $message=['validate'=>$validator->errors(),'msg'=>__('messages.check_input')];
            }
            return response()->json($message, 200);
        }
    }
    public function view(Request $request, DataGaji $data_gaji)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $ret=[];
            $data=$data_gaji->find($request->id);
            if ($data) {
                $ret=[
                    'id'=>$data->id,
                    'nik'=>$data->nik,
                    'nama'=>$data->nama,
                    'gaji'=>$data->gaji,
                    'tanggal_gaji'=>$data->tanggal_gaji,
                    'created_at'=>date('d/m/Y',strtotime($data->created_at)),
                    'updated_at'=>date('d/m/Y',strtotime($data->updated_at)),
                ];
            }
            return $ret;
        }
    }
    public function edit(Request $request, DataGaji $data_gaji)
    {
        if ($request->ajax() || $request->isMethod('post')) {
            $id=$request->id;
            $validator = Validator::make($request->all(), DataGaji::rules($id));
            $validator->setAttributeNames(DataGaji::attributeNames());
            if ($validator->passes()) {
                $data=[
                    'nik'=>$request->nik,
                    'nama'=>$request->nama,
                    'gaji'=>$request->gaji,
                    'tanggal_gaji'=>$request->tanggal_gaji,
                    'updated_at'=>date('Y-m-d H:i:s'),
                ];
                $message= ($data_gaji->where('id',$id)->update($data)) ? 'Data Berhasil Diedit' : 'Data Gagal Diedit';
                $message=['message'=>$message];
            }else{
                $message=['validate'=>$validator->errors()];
            }
            return response()->json($message, 200);
        }
    }
}
