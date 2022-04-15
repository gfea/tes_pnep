@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Data Gaji</div>

                    <div class="card-body">
                        <a href="{{ URL::to('pages/home') }}" class="btn btn-warning">Home</a>
                        <a href="{{ URL::to('pages/gaji') }}" class="btn btn-info">Data Gaji</a>
                        <a href="{{ URL::to('pages/fibonacci') }}" class="btn btn-danger">Fibonacci</a>
                        <a href="{{ URL::to('pages/gaji/show_add') }}" class="btn btn-success">Tambah Gaji</a>
                        <br>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-stipped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>NIK</th>
                                            <th>Nama Karyawan</th>
                                            <th>Tanggal Penggajian</th>
                                            <th>Jumlah Gaji</th>
                                            <th>Tanggal Data</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-data">

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div id="modal_delete" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi Delete</h4>
      </div>
      <div class="modal-body">
          <form id="form_send">
            @csrf
            <input type="hidden" name="id" id="id">
          </form>
        <p>Anda yakin akan menghapus data <span id="name"></span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="do_delete()" class="btn btn-danger">Delete</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            getAjaxData("{{ URL::to('pages/gaji/show') }}");
        })
        function delete_modal(id) {
            getAjaxDataI("{{ URL::to('pages/gaji/view') }}",id);
            $('#modal_delete').modal('show');
        }
        function do_delete() {
            submitAjax("{{ URL::to('pages/gaji/delete') }}");
            getAjaxData("{{ URL::to('pages/gaji/show') }}");
        }
        function submitAjax(urlx) {
            var data_send=$('#form_send').serialize();
            $.ajax({
                url: urlx,
                method: "POST",
                data: {"_token": "{{ csrf_token() }}",id:$('#id').val()},
                async: false,
                dataType: 'json',
                success: function (data) {
                    var message = '';
                    if (data.message){
                        message+=data.message
                    }
                    if (data.validate){
                        $.each(data.validate, function (indx, val) {
                            if (val[0]) {
                                message+='<ul class="list-unstyled"><li class="text-danger">' + val[0] + '</li></ul>';
                            }
                        })
                    }
                    $('#show_data').html(message);
                    $('#modal_delete').modal('toggle');
                },
                error: function (data) {
                    $('#show_data').html('Oops Error');
                }
            });
        }
        function getAjaxDataI(urlx, id) {
            $.ajax({
                url: urlx,
                method: "POST",
                data: {"_token": "{{ csrf_token() }}",id:id},
                async: false,
                dataType: 'json',
                success: function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.nama);
                },
                error: function (data) {
                    $('#table-data').html('Oops Error');
                }
            });
        }
        function getAjaxData(urlx, where=null) {
            $.ajax({
                url: urlx,
                method: "POST",
                data: {"_token": "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function (data) {
                    $('#table-data').html(data.message);
                },
                error: function (data) {
                    $('#table-data').html('Oops Error');
                }
            });
        }
    </script>
@endsection
