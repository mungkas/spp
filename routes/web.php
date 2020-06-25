<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth:web'])->group(function(){
    Route::get('/', 'HomeController@index')->name('web.index');

    Route::get('pengaturan','HomeController@pengaturan')->name('pengaturan.index');
    Route::get('ubah-pengaturan','HomeController@editPengaturan')->name('pengaturan.edit');
    Route::post('ubah-pengaturan','HomeController@storePengaturan')->name('pengaturan.store');
    Route::Post('cetak-laporan-harian','HomeController@cetak')->name('laporan-harian.cetak');
    Route::post('export-laporan-harian','HomeController@export')->name('laporan-harian.export');

    //Siswa
    Route::get('siswa','SiswaController@index')->name('siswa.index');
    Route::get('tambah-siswa','SiswaController@create')->name('siswa.create');
    Route::post('tambah-siswa', 'SiswaController@store')->name('siswa.store');
    Route::get('siswa/{siswa}/detail', 'SiswaController@show')->name('siswa.show');
    Route::get('siswa/{siswa}/ubah', 'SiswaController@edit')->name('siswa.edit');
    Route::post('siswa/{siswa}/ubah','SiswaController@update')->name('siswa.update');
    Route::post('siswa/{siswa}/hapus', 'SiswaController@destroy')->name('siswa.destroy');
    Route::get('import-siswa', 'SiswaController@showFormImport')->name('siswa.showimport');
    Route::post('import-siswa', 'SiswaController@import')->name('siswa.import');
    Route::get('export-siswa', 'SiswaController@export')->name('siswa.export');

    //Periode
    Route::get('periode','PeriodeController@index')->name('periode.index');
    Route::get('tambah-periode','PeriodeController@create')->name('periode.create');
    Route::post('tambah-periode', 'PeriodeController@store')->name('periode.store');
    Route::get('periode/{periode}/ubah', 'PeriodeController@edit')->name('periode.edit');
    Route::post('periode/{periode}/ubah','PeriodeController@update')->name('periode.update');
    Route::post('periode/{periode}/hapus', 'PeriodeController@destroy')->name('periode.destroy'); 

    //Jenjang
    Route::get('jenjang','JenjangController@index')->name('jenjang.index');
    Route::get('tambah-jenjang','JenjangController@create')->name('jenjang.create');
    Route::post('tambah-jenjang', 'JenjangController@store')->name('jenjang.store');
    Route::get('jenjang/{jenjang}/ubah', 'JenjangController@edit')->name('jenjang.edit');
    Route::post('jenjang/{jenjang}/ubah','JenjangController@update')->name('jenjang.update');
    Route::post('jenjang/{jenjang}/hapus', 'JenjangController@destroy')->name('jenjang.destroy');

     //Kelas
     Route::get('kelas','KelasController@index')->name('kelas.index');
     Route::get('tambah-kelas','KelasController@create')->name('kelas.create');
     Route::post('tambah-kelas', 'KelasController@store')->name('kelas.store');
     Route::get('kelas/{kelas}/ubah', 'KelasController@edit')->name('kelas.edit');
     Route::post('kelas/{kelas}/ubah','KelasController@update')->name('kelas.update');
     Route::post('kelas/{kelas}/hapus', 'KelasController@destroy')->name('kelas.destroy');

    //Tingkat
    Route::get('tingkat','TingkatController@index')->name('tingkat.index');
    Route::get('tambah-tingkat','TingkatController@create')->name('tingkat.create');
    Route::post('tambah-tingkat', 'TingkatController@store')->name('tingkat.store');
    Route::get('tingkat/{tingkat}/ubah', 'TingkatController@edit')->name('tingkat.edit');
    Route::post('tingkat/{tingkat}/ubah','TingkatController@update')->name('tingkat.update');
    Route::post('tingkat/{tingkat}/hapus', 'TingkatController@destroy')->name('tingkat.destroy');

    //Tagihan
    Route::get('tagihan','TagihanController@index')->name('tagihan.index');
    Route::get('tambah-tagihan','TagihanController@create')->name('tagihan.create');
    Route::post('tambah-tagihan', 'TagihanController@store')->name('tagihan.store');
    Route::get('tagihan/{tagihan}/ubah', 'TagihanController@edit')->name('tagihan.edit');
    Route::post('tagihan/{tagihan}/ubah','TagihanController@update')->name('tagihan.update');
    Route::post('tagihan/{tagihan}/hapus', 'TagihanController@destroy')->name('tagihan.destroy');

    //Users
    Route::get('user','UserController@index')->name('user.index');
    Route::get('tambah-user','UserController@create')->name('user.create');
    Route::post('tambah-user', 'UserController@store')->name('user.store');
    Route::get('user/{user}/ubah', 'UserController@edit')->name('user.edit');
    Route::post('user/{user}/ubah','UserController@update')->name('user.update');
    Route::post('user/{user}/hapus', 'UserController@destroy')->name('user.destroy');

    //Hasil
    Route::get('hasil', 'HasilController@index')->name('hasil.index');
    Route::post('hasilt', 'HasilController@menabung')->name('hasil.store');
    Route::get('cetak-hasil/{id}', 'HasilController@transaksiCetak')->name('hasil.transaksicetak');
    Route::get('export-mutasi', 'HasilController@export')->name('hasil.export');
    Route::get('cetak-hasil-siswa/{siswa}', 'HasilController@cetak')->name('hasil.cetak');
    Route::get('export-hasil/{siswa}', 'HasilController@siswaexport')->name('hasil.siswa.export');

    //Keuangan 
    Route::get('keuangan', 'KeuanganController@index')->name('keuangan.index');
    Route::post('keuangan', 'KeuanganController@store')->name('keuangan.store');
    Route::get('export-keuangan', 'KeuanganController@export')->name('keuangan.export');

    //Pembayaran SPP
    Route::get('transaksi-spp','TransaksiController@index')->name('spp.index');
    Route::post('print-spp', 'TransaksiController@transaksiPrint')->name('transaksi.print');
    Route::get('export-spp','TransaksiController@transaksiExport')->name('transaksi.export');
    Route::post('print-spp/{siswa?}','TransaksiController@print')->name('spp.print');
    Route::post('export-spp/{siswa?}','TransaksiController@export')->name('spp.export');

});
