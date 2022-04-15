<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataGaji extends Model
{
    protected $table = 'data_gaji_karyawan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nik', 'nama', 'gaji', 'tanggal_gaji',
    ];
    public static function rules($id = 0)
    {
        return ['nik'=>'required|unique:App\DataGaji,nik'.(($id)?','.$id.',id':''),'nama'=>'required','gaji'=>'required','tanggal_gaji'=>'required'];
    }
    public static function attributeNames()
    {
        return ['nik'=>'NIK','nama'=>'Nama Karyawan','gaji'=>'Jumlah Gaji','tanggal_gaji'=>'Tanggal Penggajian'];
    }
}
