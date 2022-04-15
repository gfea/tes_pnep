@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Data Gaji</div>

                    <div class="card-body">
                        <a href="{{ URL::to('pages/gaji') }}" class="btn btn-info">Data Gaji</a>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="show_data"></div>
                                <form id="form_send">
                                    @csrf
                                    <input type="hidden" name="id" id="id"/>
                                    <label>Masukkan NIK</label>
                                    <input class="form-control" name ="nik" id="nik" type="text" placeholder="Masukkan Nama"/>
                                    <br>
                                    <label>Masukkan Nama</label>
                                    <input class="form-control" name ="nama" id="nama" type="text" placeholder="Masukkan Nama"/>
                                    <br>
                                    <label>Masukkan Gaji</label>
                                    <input class="form-control" name ="gaji" id="gaji" type="number" placeholder="Masukkan Angka" step="0.01" min="0"/>
                                    <br>
                                    <label>Masukkan Tanggal Gaji</label>
                                    <input class="form-control" name ="tanggal_gaji" id="tanggal" type="date" placeholder="Masukkan Tanggal Gaji"/>
                                    <br>
                                    <button onclick="do_send()" type="button" class="btn btn-success">Simpan</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function () {
            getAjaxData("{{ URL::to('pages/gaji/view') }}");
        })
        function getAjaxData(urlx) {
            $.ajax({
                url: urlx,
                method: "POST",
                data: {"_token": "{{ csrf_token() }}",id:"{{ request()->segment(4) }}"},
                async: false,
                dataType: 'json',
                success: function (data) {
                    $('#id').val(data.id);
                    $('#nik').val(data.nik);
                    $('#nama').val(data.nama);
                    $('#gaji').val(data.gaji);
                    $('#tanggal').val(data.tanggal_gaji);
                },
                error: function (data) {
                    $('#show_data').html('Oops Error');
                }
            });
        }
        function do_send() {
            submitAjax("{{ URL::to('pages/gaji/edit') }}");
        }
        function submitAjax(urlx) {
            var data_send=$('#form_send').serialize();
            $.ajax({
                url: urlx,
                method: "POST",
                data: data_send,
                async: false,
                dataType: 'json',
                success: function (data) {
                    var message = '';
                    if (data.message){
                        message+='<span class="text-success">'+data.message+'</success>';
                    }
                    if (data.validate){
                        $.each(data.validate, function (indx, val) {
                            if (val[0]) {
                                message+='<ul class="list-unstyled"><li class="text-danger">' + val[0] + '</li></ul>';
                            }
                        })
                    }
                    $('#show_data').html(message);
                },
                error: function (data) {
                    $('#show_data').html('Oops Error');
                }
            });
        }

    </script>
@endsection
