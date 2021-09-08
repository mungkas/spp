@extends('layouts.app')

@section('site-name','Sistem Informasi SPP')
@section('page-name', (isset($tagihan) ? 'Ubah Tagihan' : 'Tagihan Baru'))

@section('content')
    <div class="row">
        <div class="col-8">
            <form action="{{ (isset($tagihan) ? route('tagihan.update', $tagihan->id) : route('tagihan.create')) }}" method="post" class="card">
                <div class="card-header">
                    <h3 class="card-title">@yield('page-name')</h3>
                </div>
                <div class="card-body">
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
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{ isset($tagihan) ? $tagihan->nama : old('nama') }}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Jumlah</label>
                                <input type="number" class="form-control" name="jumlah" value="{{ isset($tagihan) ? $tagihan->jumlah : old('jumlah') }}" required>
                            </div>
                            <div class="form-group">
                                <div class="form-label">Peserta</div>
                                <div class="custom-switches-stacked">
                                <label class="custom-switch">
                                <input type="radio" name="peserta" value="1" class="custom-switch-input" {{ isset($tagihan) ? ($tagihan->wajib_semua == 1 ? 'checked' : '') : 'checked' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Wajib Semua Siswa</span>
                                </label>
                                <label class="custom-switch">
                                <input type="radio" name="peserta" value="2" class="custom-switch-input" {{ isset($tagihan) ? (($tagihan->jenjang_id != null) ? 'checked' : '') : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Hanya Jenjang</span>
                                </label>
                                <label class="custom-switch">
                                <input type="radio" name="peserta" value="3" class="custom-switch-input" {{ isset($tagihan) ? (($tagihan->jenjang_id == null && $tagihan->wajib_semua == null) ? 'checked' : '') : '' }}>
                                <span class="custom-switch-indicator"></span>
                                <span class="custom-switch-description">Hanya Siswa</span>
                                </label>
                            </div>
                            </div>
                            <div class="form-group" style="display: {{ isset($tagihan) ? (($tagihan->jenjang_id != null) ? 'block' : 'none') : 'none' }}" id="form-jenjang">
                                <label class="form-label">Jenjang</label>
                                <select class="form-control" name="jenjang_id" id="hanya-jenjang">
                                    @foreach($jenjang as $item)
                                        <option value="{{ $item->id }}" {{ isset($tagihan) ? (($tagihan->jenjang_id == $item->id) ? 'selected' : '') : '' }}>
                                            {{ $item->nama }} - {{ isset($item->periode) ? $item->periode->nama : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="display: {{ isset($tagihan) ? (($tagihan->jenjang_id == null && $tagihan->wajib_semua == null) ? 'block' : 'none') : 'none' }}" id="form-siswa">
                                <label class="form-label">Siswa</label>
                                <select class="form-control" name="siswa_id[]" id="hanya-siswa" multiple>
                                    @foreach($siswa as $item)
                                        <option value="{{ $item->id }}" {{ isset($tagihan) ? (($tagihan->wajib_semua == null && $tagihan->jenjang_id == null) ? (in_array($item->id, $tagihan->siswa->pluck('id')->toArray()) ? 'selected' : '') : '') : '' }}>
                                            {{ $item->nama }} - {{ $item->jenjang->nama }} {{ isset($item->jenjang->periode) ? "(". $item->jenjang->periode->nama .")" : ''}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- <div class="form-group">
                                <label class="form-label">Tanggal Mulai s/d Selesai</label>
                                <div class="row gutters-xs">
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="tgl_mulai" data-toggle="datepicker" placeholder="Tanggal Mulai" required autocomplete="off" value="{{ isset($tagihan) ? $tagihan->tgl_mulai : old('tgl_mulai') }}">
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control" name="tgl_selesai" data-toggle="datepicker" placeholder="Tanggal Selesai" required autocomplete="off" value="{{ isset($tagihan) ? $tagihan->tgl_selesai : old('tgl_selesai') }}">
                                    </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <div class="d-flex">
                        <a href="{{ url()->previous() }}" class="btn btn-link">Batal</a>
                        <button type="submit" class="btn btn-primary ml-auto">Simpan</button>
                    </div>
                </div>
            </form>
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
    require(['jquery', 'selectize','select2', 'datepicker'], function ($, selectize) {
        $(document).ready(function () {
            $('#select-beast').selectize({});

            // var date = new Date();
            // var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

            // $('#date').datepicker({ 
            //     minDate: today
            // });

            // $('[data-toggle="datepicker"]').datepicker({
            //     format: 'yyyy-MM-dd'
            // });
        });

        $('#hanya-jenjang').select2({
            placeholder: "Pilih Jenjang",
        });
        $('#hanya-siswa').select2({
            placeholder: "Pilih Siswa",
        });


        $('.custom-switch-input').change(function(){
            if(this.value == 2){
                $('#form-jenjang').show()
                $('#form-siswa').hide()

                $('#hanya-jenjang').prop('required', true)
                $('#hanya-siswa').prop('required', false)
            }else if(this.value == 3){
                $('#form-jenjang').hide()
                $('#form-siswa').show()

                $('#hanya-jenjang').prop('required', false)
                $('#hanya-siswa').prop('required', true)
            }else{
                $('#form-jenjang').hide()
                $('#form-siswa').hide()

                $('#hanya-jenjang').prop('required', false)
                $('#hanya-siswa').prop('required', false)
            }
        })
    });
</script>
@endsection