@extends('layouts.app')

@section('page-name','Dashboard')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            Dashboard
        </h1>
    </div>
    <div class="row">
        
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="h1 m-0">IDR {{ format_idr($total_uang_spp) }}</div>
                <div class="text-muted mb-4">Total Uang SPP</div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="h1 m-0">{{ $siswa }}</div>
                <div class="text-muted mb-4">Siswa</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="h1 m-0">{{ $jenjang }}</div>
                <div class="text-muted mb-4">Jenjang</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3 col-lg-3">
            <div class="card">
                <div class="card-body p-3 text-center">
                <div class="h1 m-0">{{ $item }}</div>
                <div class="text-muted mb-4">Item Tagihan</div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Laporan Per-Bulan</h3>

                    <div class="card-options">
                        <!-- <input class="form-control mr-2" type="text" name="dates" style="max-width: 200px" id="daterange" value="{{ now()->subDay(7)->format('m-d-Y')." - ".now()->format('m-d-Y') }}">
                        <button id="btn-cetak-spp" class="btn btn-primary mr-1" value="#">Cetak</button> -->
                    </div>
                </div>

                <div class="card-body">
                    <table class="table card-table table-hover table-vcenter text-nowrap title" id="print">
                        <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenjang</th>
                            <th>NIS</th>
                            <th>Siswa</th>   
                            <th>Tagihan</th>                         
                            <th>Pembayaran</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($transaksi as $item)
                            <tr>
                                <td>{{ $item->created_at->format('d-m-Y')}}</td>
                                <td>{{ $item->siswa->jenjang->nama }}</td>                                
                                <td>{{ $item->siswa->nis }}</td>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->tagihan->nama }}</td>
                                <td>{{ format_idr($item->tagihan->jumlah) }}
                                <td>IDR. {{ format_idr($item->keuangan->jumlah) }}</td>
                                @php
                                    $jumlah += $item->keuangan->jumlah
                                @endphp
                            </tr>
                        @endforeach
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>IDR. {{ format_idr($jumlah) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

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