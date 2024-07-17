<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'authController::index');
$routes->get('/login', 'authController::index');
$routes->get('/logout', 'authController::logout', ['filter' => 'auth']);


$routes->get('/dashboard', 'authController::dashboard', ['filter' => 'auth']);
$routes->post('/dashboard', 'authController::login', ['filter' => 'noauth']);

//kalo mau akses halaman pake auth, pertama kali pake no auth(contoh di login)
$routes->get('/dataakun', 'akunController::dataAkun', ['filter' => 'auth'] );

$routes->get('/tambahakun', 'akunController::tambahAkun', ['filter' => 'auth']);
$routes->post('/submittambahakun', 'akunController::submitTambahAkun', ['filter' => 'auth']);

$routes->get('/editakun/(:any)', 'akunController::editAkun/$1', ['filter' => 'auth']);
$routes->post('/submiteditakun', 'akunController::submitEditAkun', ['filter' => 'auth']);

$routes->post('/submiteditakun/(:segment)', 'AkunController::submitEditAkun/$1');

$routes->get('/hapusakun/(:segment)', 'AkunController::hapusAkun/$1');


//kalo mau akses halaman pake auth, pertama kali pake no auth(contoh di login)
$routes->get('/datacuti', 'cutiController::dataCuti', ['filter' => 'auth'] );

$routes->get('/tambahcuti', 'cutiController::tambahCuti', ['filter' => 'auth']);
$routes->post('/submittambahcuti', 'cutiController::submitTambahCuti', ['filter' => 'auth']);

$routes->get('/editcuti/(:any)', 'cutiController::editCuti/$1', ['filter' => 'auth']);
$routes->post('/submiteditcuti/(:segment)', 'cutiController::submitEditCuti/$1');

$routes->get('/hapuscuti/(:segment)', 'cutiController::hapusCuti/$1');


$routes->get('/jadwalpegawai', 'jadwalController::dataJadwal', ['filter' => 'auth'] );
$routes->get('/detailjadwal/(:any)', 'jadwalController::dataDetailJadwal/$1', ['filter' => 'auth']);

$routes->get('/tambahjadwal', 'jadwalController::tambahJadwal', ['filter' => 'auth']);
$routes->post('/submittambahjadwal', 'jadwalController::submitTambahJadwal', ['filter' => 'auth']);

$routes->get('/editjadwal/(:any)', 'jadwalController::editJadwal/$1', ['filter' => 'auth']);
$routes->post('/submiteditjadwal/(:segment)', 'jadwalController::submitEditJadwal/$1', ['filter' => 'auth']);

// $routes->get('/hapusjadwal/(:segment)', 'jadwalController::hapusJadwal/$1');

$routes->get('/lokasiorganisasi', 'lokasiController::dataLokasi', ['filter' => 'auth'] );
$routes->post('/submiteditlokasi/(:segment)', 'lokasiController::submitEditLokasi/$1', ['filter' => 'auth']);

$routes->get('/datafile', 'fileController::dataFile', ['filter' => 'auth']);

$routes->post('/submittambahfile', 'fileController::submitUnggahFile', ['filter' => 'auth']);

// $routes->get('/datapegawai', 'akunController::dataPegawai');


// $routes->get('/admin', 'authController::dashboard');

// $routes->get('/logout', 'authController::logout');

// $routes->get('/datapegawai', 'adminController::dataPegawai', ['filter' => 'noauth']);

// $routes->get('/signup', 'adminController::daftarPegawai');
// $routes->get('/editpegawai', 'adminController::editPegawai');
// $routes->get('/presensipegawai', 'adminController::presensiPegawai');

//==============================================================================
$routes->get('/datapegawai', 'pegawaiController::dataPegawai', ['filter' => 'auth'] );

$routes->get('/datapegawai-test', 'pegawaiController::dataPegawaiTest',  ['filter' => 'auth'] );

$routes->get('/tambahpegawai', 'pegawaiController::tambahPegawai', ['filter' => 'auth']);
$routes->post('/submittambahpegawai', 'pegawaiController::submitTambahPegawai', ['filter' => 'auth']);

$routes->get('/editpegawai/(:any)', 'pegawaiController::editPegawai/$1', ['filter' => 'auth']);
$routes->post('/submiteditpegawai/(:segment)', 'pegawaiController::submitEditPegawai/$1', ['filter' => 'auth']);

$routes->get('/hapuspegawai/(:segment)', 'pegawaiController::hapusPegawai/$1', ['filter' => 'auth']);

//==========================================================================================
$routes->get('/presensi', 'presensiController::halamanPresensi', ['filter' => 'auth']);
// Route to serve the JavaScript file (loadModel.js)
$routes->get('loadModel.js', 'PresensiController::script', ['filter' => 'auth']);


//==========================================================================================
$routes->get('/alamatpegawai', 'alamatController::alamatPegawai', ['filter' => 'auth'] );
$routes->get('/tambahalamat', 'alamatController::tambahAlamat', ['filter' => 'auth']);

$routes->post('/submittambahalamat', 'alamatController::submitTambahAlamat', ['filter' => 'auth']);

$routes->get('/editalamat/(:any)', 'alamatController::editAlamat/$1', ['filter' => 'auth']);
$routes->post('/submiteditalamat/(:segment)', 'alamatController::submitEditAlamat/$1', ['filter' => 'auth']);

$routes->get('/hapusalamat/(:segment)', 'alamatController::hapusAlamat/$1', ['filter' => 'auth']);

//===========================================================================================
$routes->get('/berkaspegawai', 'berkasController::berkasPegawai', ['filter' => 'auth'] );
$routes->get('/tambahberkas', 'berkasController::tambahBerkas', ['filter' => 'auth']);

$routes->post('/submittambahberkas', 'berkasController::submitTambahBerkas', ['filter' => 'auth']);

$routes->get('/editberkas/(:any)', 'berkasController::editBerkas/$1', ['filter' => 'auth']);

$routes->post('/submiteditberkas/(:segment)', 'berkasController::submitEditBerkas/$1', ['filter' => 'auth']);
$routes->post('/submiteditktp/(:segment)', 'berkasController::submitEditKTP/$1', ['filter' => 'auth']);
$routes->post('/submiteditkk/(:segment)', 'berkasController::submitEditKK/$1', ['filter' => 'auth']);
$routes->post('/submiteditnpwp/(:segment)', 'berkasController::submitEditNPWP/$1', ['filter' => 'auth']);
$routes->post('/submiteditbpjs/(:segment)', 'berkasController::submitEditBPJS/$1', ['filter' => 'auth']);
$routes->post('/submiteditijazah/(:segment)', 'berkasController::submitEditIjazah/$1', ['filter' => 'auth']);
$routes->post('/submiteditskck/(:segment)', 'berkasController::submitEditSkck/$1', ['filter' => 'auth']);
$routes->post('/submiteditstr/(:segment)', 'berkasController::submitEditStr/$1', ['filter' => 'auth']);
$routes->post('/submiteditserkom/(:segment)', 'berkasController::submitEditSerkom/$1', ['filter' => 'auth']);

$routes->get('/hapusberkas/(:segment)', 'berkasController::hapusBerkas/$1', ['filter' => 'auth']);

$routes->get('/datafotopegawai', 'fileController::dataFotoPegawai', ['filter' => 'auth'] );
$routes->get('/tambahfotopegawai', 'fileController::tambahFotoPegawai', ['filter' => 'auth'] );
$routes->post('/submittambahfotopegawai', 'fileController::submitHasilFoto', ['filter' => 'auth']);

$routes->get('/konfirmasifotopegawai', 'fileController::konfirmasiFotoPegawai', ['filter' => 'auth'] );

$routes->post('/submitkonfirmasitambahfoto', 'fileController::submitKonfirmasiFotoPegawai', ['filter' => 'auth']);

$routes->get('/editfotopegawai/(:any)', 'fileController::editFotoPegawai/$1', ['filter' => 'auth']);
$routes->post('/submiteditfotopegawai/(:segment)', 'fileController::submitEditFotoPegawai/$1', ['filter' => 'auth']);

$routes->delete('/hapusfotopegawai/(:segment)', 'fileController::hapusFotoPegawai/$1', ['filter' => 'auth']);

$routes->get('/datakehadiran', 'kehadiranController::dataKehadiran', ['filter' => 'auth'] );

?>