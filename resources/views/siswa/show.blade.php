@extends('layouts.app')

@section('page-name','Siswa')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('page-name')</h3>
                </div>
                <div class="card-body">
                    <p><b>Jenjang</b> : {{$siswa->jenjang->nama}} </p>
                    <p><b>Kelas</b> : {{$siswa->kelas->nama}} </p>
                    <p><b>NIS</b> : {{$siswa->nis}} </p>
                    <p><b>Nama</b> : {{$siswa->nama}} </p>
                    <p><b>Tempat, Tanggal Lahir</b> : {{$siswa->tempat_lahir.', '.$siswa->tanggal_lahir}} </p>
                    <p><b>Alamat</b> : {{$siswa->alamat}} </p>
                    <p><b>Nama Wali</b> : {{$siswa->nama_wali}} </p>
                    <p><b>No. Telp Wali</b> : {{$siswa->telp_wali}} </p>
                    <p><b>Pekerjaan Wali</b> : {{$siswa->pekerjaan_wali}} </p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tagihan SPP</h3>
                    <div class="card-options">
                        <input class="form-control mr-2" type="text" name="dates" style="max-width: 200px" id="daterange" value="{{ now()->subDay(7)->format('m-d-Y')." - ".now()->format('m-d-Y') }}">
                        <button id="btn-cetak-spp" class="btn btn-primary mr-1" value="{{ $siswa->id }}">Cetak</button>
                        <button id="btn-export-spp" class="btn btn-primary" value="{{ $siswa->id }}">Export</button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <tr>
                            <th>Nama Tagihan</th>
                            <th>Total</th>
                            <th>Lunas</th>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                        </tr> 
                        @foreach($tagihan as $item)
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>{{ $item['total'] }}</td>
                            <td>
                                @if($item['is_lunas'])
                                    <span class="tag tag-green">Lunas</span>
                                @else
                                    <span class="tag tag-purple">Belum</span>
                                @endif 
                            </td>
                            <td>{{ $item['created_at'] }}</td>
                            <td>{{ $item['keterangan'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker.css') }}" />
@endsection
@section('js')
<script>
    require(['jquery', 'moment','daterangepicker'], function ($, moment, daterangepicker) {
        $(document).ready(function () {
            $('input[name="dates"]').daterangepicker();
        });
        $('#btn-cetak-spp').on('click', function(){
            //form print
            var form = document.createElement("form");
            form.setAttribute("style", "display: none");
            form.setAttribute("method", "post");
            form.setAttribute("action", "{{ route('spp.print') }}/" + this.value);
            form.setAttribute("target", "_blank");
            
            var token = document.createElement("input");
            token.setAttribute("name", "_token");
            token.setAttribute("value", "{{csrf_token()}}");
            
            var dateForm = document.createElement("input");
            dateForm.setAttribute("name", "dates");
            dateForm.setAttribute("value", $('#daterange').val());

            form.appendChild(token);
            form.appendChild(dateForm);
            document.body.appendChild(form);
            form.submit();

            console.log($('#daterange').val())
        })

        $('#btn-export-spp').on('click', function(){
            //form print
            var form = document.createElement("form");
            form.setAttribute("style", "display: none");
            form.setAttribute("method", "post");
            form.setAttribute("action", "{{ route('spp.export') }}/" + this.value);
            form.setAttribute("target", "_blank");
            
            var token = document.createElement("input");
            token.setAttribute("name", "_token");
            token.setAttribute("value", "{{csrf_token()}}");
            
            var dateForm = document.createElement("input");
            dateForm.setAttribute("name", "dates");
            dateForm.setAttribute("value", $('#daterange').val());

            form.appendChild(token);
            form.appendChild(dateForm);
            document.body.appendChild(form);
            form.submit();

            console.log($('#daterange').val())
        })
    });
</script>
@endsection