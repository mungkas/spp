@extends('layouts.app')

@section('page-name','Pembayaran SPP')

@section('content')
    <div class="page-header">
        <h1 class="page-title">
            @yield('page-name')
        </h1>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transaksi</h3>
                </div>
                @if(session()->has('msg'))
                <div class="card-alert alert alert-{{ session()->get('type') }}" id="message" style="border-radius: 0px !important">
                    @if(session()->get('type') == 'success')
                        <i class="fe fe-check mr-2" aria-hidden="true"></i>
                    @else
                        <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> 
                    @endif
                        {{ session()->get('msg') }}
                </div>
                @endif
                <div class="card-body">
                    {{-- <form action="{{ route('keuangan.store') }}" method="post"> --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Siswa</label>
                                    <select id="siswa" class="form-control" name="siswa_id">
                                        <option value="#">[-- Pilih Siswa --]</option>
                                        @foreach($siswa as $item)
                                            <option value="{{ $item->id }}"> {{ $item->nama.' - '.$item->jenjang->nama }} </option>
                                        @endforeach
                                    </select><br>
                                </div>
                                <div class="form-group" style="display: none" id="form-tagihan">
                                    <label class="form-label" >Tagihan</label>
                                    <select id="tagihan" class="form-control" name="tagihan_id">
                                        
                                    </select>
                                </div>
                                <div class="form-group" style="display: none" id="form-tagihan-2">
                                        <label class="form-label">Total Tagihan</label>
                                        IDR. <span id="harga">0</span>
                                </div>
                                <div class="form-group" style="display: none" id="form-total">
                                        <label class="form-label">Total Pembayaran</label>
                                        <input type="text" name="pembayaran" class="form-control" id="total" readonly>
                                </div>
                                <div class="form-group" style="display: none" id="form-pembayaran">
                                    <label class="form-label">Pembayaran</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="via" value="tunai" class="selectgroup-input" checked="">
                                            <span class="selectgroup-button">Tunai</span>
                                        </label>
                                        <label class="selectgroup-item" style="display: none" id="opsi-tabungan">
                                            <input type="radio" name="via" value="tabungan" class="selectgroup-input">
                                            <span class="selectgroup-button">Potong Tabungan</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" style="display: none" id="form-keterangan">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-primary ml-auto" style="display: none" id="btn-simpan">Simpan</button>
                        </div>
                    {{-- </form> --}}
                    
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tagihan Sudah Bayar</h3>
                     <div class="card-options">
                     <!-- <input class="form-control mr-2" type="text" name="dates" style="max-width: 200px" id="daterange" value="{{ now()->subDay(7)->format('m-d-Y')." - ".now()->format('m-d-Y') }}">
                     @foreach($siswa as $item)
                        <button id="btn-cetak-spp" class="btn btn-primary mr-1" value="{{ $item->id }}">Cetak</button>
                        <button id="btn-export-spp" class="btn btn-primary" value="{{ $item->id }}">Export</button>
                     @endforeach -->
                       
                     </div>
                </div>
                <div class="card-body">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Nama Siswa</th>
                            <th>Tagihan</th>
                            <th>Tanggal Bayar</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($keuangan as $index => $item)
                            <tr>
                                <td><span class="text-muted">{{ $index+1 }}</span></td>
                                <td>{{ isset($item->siswa) ? $item->siswa->nama : '-' }}</span></td>
                                <td>{{ isset($item->tagihan) ? $item->tagihan->nama : '-' }}</span></td>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                <td style="max-width:150px;">{{ $item->keterangan }}</td>
                                <td>IDR. {{ format_idr($item->jumlah) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }
        .select2{
            width: 100% !important;
        }
    </style>
@endsection
@section('js')
<script>
    require(['jquery','select2','sweetalert'], function ($, select2, sweetalert) {
        $(document).ready(function () {
            //format IDR
            function formatNumber(num) {
                return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
            }
            $('#siswa').select2({
                placeholder: "Pilih Siswa",
            });
            $('#tagihan').select2({});
            
            var siswa_id;   //siswa_id
            var tagihan_id; //tagihan_id
            var saldo;      //saldo dari siswa
            var harga;      //harga dari tagihan
            var via = 'tunai';  //pembayaran via 
            // memilih siswa
            $('#siswa').on('change',function(){
                if(this.value == '#'){
                    $('#saldo').text('0') 
                    $('#form-tagihan').hide()
                    $('#form-tagihan-2').hide()
                    $('#form-total').hide()
                    $('#form-pembayaran').hide()
                    $('#opsi-tabungan').hide()
                    $('#form-keterangan').hide()
                    $('#btn-simpan').hide()
                    return;
                }else{
                    siswa_id = this.value
                }
                //get saldo
                $.ajax({url: "{{ route('api.getsaldo') }}/" + this.value, success: function(result){
                        $('#saldo').text(result.sal)
                        saldo = result.saldo
                        $('#form-tagihan').show()
                        $('#form-tagihan-2').show()
                        $('#form-total').show()
                        $('#form-pembayaran').show()
                        if(saldo > 0){
                            $('#opsi-tabungan').show()
                        }
                        $('#form-keterangan').show()
                        $('#btn-simpan').show()
                    }, beforeSend: function(){ 
                        $('#saldo').text('tunggu, sedang mengambil saldo.....') 
                        $('#form-tagihan').hide()
                        $('#form-tagihan-2').hide()
                        $('#form-total').hide()
                        $('#form-pembayaran').hide()
                        $('#opsi-tabungan').hide()
                        $('#form-keterangan').hide()
                        $('#btn-simpan').hide()
                }});
                //get tagihan
                $.ajax({url: "{{ route('api.gettagihan') }}/" + this.value, success: function(result){
                    if(result.length == 0){
                        alert('tidak ada item tagihan yang tersedia')
                    }
                    $("#tagihan").empty()
                    for(i=0;i < result.length ;i++){
                        $("#tagihan").append('<option value="'+ result[i].id +'" data-harga="'+ result[i].jumlah +'">'+ result[i].nama +'</option>');
                    }
                    //set harga dari data pertama
                    tagihan_id = result[0].id
                    harga = result[0].jumlah
                    if(harga <= saldo){
                        $('#opsi-tabungan').show()
                    }else{
                        $('#opsi-tabungan').hide()
                    }

                    //menampilkan harga
                    $('#harga').text(formatNumber(harga));
                    $('#total').val(formatNumber(harga));
                },});
            })

            $('#tagihan').on('change', function(){
                tagihan_id = this.value
                //set harga dari opsi yang dipilih
                harga = $('option:selected', this).attr('data-harga');

                if(harga <= saldo){
                    $('#opsi-tabungan').show()
                }else{
                    $('#opsi-tabungan').hide()
                }

                //menampilkan harga
                $('#harga').text(formatNumber(harga));
                $('#total').val(formatNumber(harga));
            })

            //pembayaran via
            $('.selectgroup-input').change(function(){
                via = this.value
            })

            $('#btn-simpan').on('click', function(){
                console.log(harga)
                if((harga) == NaN){
                    alert('invalid')
                }else{
                    $('#btn-simpan').addClass("btn-loading")
                    $.ajax({
                        type: "POST",
                        url: "{{ route('api.tagihan') }}/"+siswa_id,
                        data: {
                            tagihan_id : tagihan_id,
                            siswa_id : siswa_id,
                            jumlah : harga,
                            keterangan : keterangan.value,
                            via : via
                        },
                        success: function(data){
                            console.log(data);
                            swal({title: data.msg})
                            setTimeout(function(){
                                window.location.reload()
                            }, 2000)
                        },
                        error: function(data){
                            swal({title: "Terjadi kesalahan pada transaksi, Transaksi dibatalkan"})
                            setTimeout(function(){
                                window.location.reload()
                            }, 2000)
                        }
                    });
                }
                
            })

            $('#mass-cetak').on('click', function(){
                var ids = []
                $('.tandai').each(function(){
                    if(this.checked){
                        ids.push(this.value)
                    }
                })

                var form = document.createElement("form");
                form.setAttribute("style", "display: none");
                form.setAttribute("method", "post");
                form.setAttribute("action", "{{ route('transaksi.print') }}");
                form.setAttribute("target", "_blank");
                
                var token = document.createElement("input");
                token.setAttribute("name", "_token");
                token.setAttribute("value", "{{csrf_token()}}");
                
                var idsForm = document.createElement("input");
                idsForm.setAttribute("name", "ids");
                idsForm.setAttribute("value", ids);

                form.appendChild(token);
                form.appendChild(idsForm);
                document.body.appendChild(form);
                form.submit();

            })
        });
    });
</script>
@endsection