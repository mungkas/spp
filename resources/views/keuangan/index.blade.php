@extends('layouts.app')

@section('page-name','Keuangan')

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
                    <h3 class="card-title">Mutasi Keuangan</h3>
                    <div class="card-options">
                        <a href="{{ route('keuangan.export') }}" class="btn btn-primary btn-sm ml-2" download="true">Export</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-hover table-vcenter text-wrap">
                        <thead>
                        <tr>
                            <th class="w-1">No.</th>
                            <th>Tanggal</th>
                            <th>KD</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($keuangan as $index => $item)
                            <tr>
                                <td><span class="text-muted">{{ $index+1 }}</span></td>
                                <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if($item->tipe == 'in')
                                        Uang Masuk
                                    @elseif($item->tipe == 'out')
                                        Uang Keluar
                                    @endif
                                </td>
                                <td style="max-width:150px;">{{ $item->keterangan }}</td>
                                <td>IDR. {{ format_idr($item->jumlah) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="d-flex">
                        <div class="ml-auto mb-0">
                            {{ $keuangan->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    require(['jquery'], function ($) {
        $(document).ready(function () {
            var keperluan = 'in';
            //keperluan
            $('.selectgroup-input').change(function(){
                keperluan = this.value
                $('#form-jumlah').show()
                $('#form-keterangan').show()
                $('#submit').show()
            })

        });
    });
</script>
@endsection