@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Bilangan Fibonacci</div>

                    <div class="card-body">
                        <a href="{{ URL::to('pages/home') }}" class="btn btn-warning">Home</a>
                        <a href="{{ URL::to('pages/gaji') }}" class="btn btn-info">Data Gaji</a>
                        <a href="{{ URL::to('pages/fibonacci') }}" class="btn btn-danger">Fibonacci</a>

                        <form id="form_send">
                            @csrf
                            <label>Masukkan Angka</label>
                            <input class="form-control" name ="bilangan" type="number" placeholder="Masukkan Angka"/>
                            <div id="show_data"></div>
                            <br>
                            <button onclick="do_send()" type="button" class="btn btn-success">Hitung</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        function do_send() {
            submitAjax("{{ route('pages/pages/fibonacci/send') }}");
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
                },
                error: function (data) {
                    $('#show_data').html('Oops Error');
                }
            });
        }

    </script>
@endsection
