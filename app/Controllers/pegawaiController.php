<?php

namespace App\Controllers;


class pegawaiController extends BaseController
{

    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataPegawai()
{
    $title = 'Data Pegawai dan Alamat';

    $page = $this->request->getGet('page') ?? 1;
    $size = $this->request->getGet('size') ?? 10;

    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $akun_url = $this->api_url . '/pegawai?page=' . $page . '&size=' . $size;

        $ch_akun = curl_init($akun_url);
        curl_setopt($ch_akun, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_akun, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response_akun = curl_exec($ch_akun);

        if ($response_akun) {
            $http_status_code_akun = curl_getinfo($ch_akun, CURLINFO_HTTP_CODE);

            if ($http_status_code_akun === 200) {
                $akun_data = json_decode($response_akun, true);
                $alamat_url = $this->api_url . '/akun/alamat?page=' . $page . '&size=' . $size;

                $ch_alamat = curl_init($alamat_url);
                curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                ]);
                $response_alamat = curl_exec($ch_alamat);

                if ($response_alamat) {
                    $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);

                    if ($http_status_code_alamat === 200) {
                        $alamat_data = json_decode($response_alamat, true);
                        return view('/admin/dataPegawai', [
                            'akun_data' => $akun_data['data']['pegawai'],
                            'alamat_data' => $alamat_data['data']['alamat'],
                            'meta_data' => $akun_data['data'],
                            'title' => $title
                        ]);
                    } else {
                        return $this->renderErrorView($http_status_code_alamat);
                    }
                } else {
                    return $this->renderErrorView(500);
                }
            } else {
                return $this->renderErrorView($http_status_code_akun);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_akun);
    } else {
        return $this->renderErrorView(401);
    }
}


    public function tambahPegawai()
    {
        $title = 'Tambah Pegawai';

         // Check if jwt_token session exists
         if (session()->has('jwt_token')) {
            // If session exists, render the add account view
            return view('/admin/tambahPegawai', ['title' => $title]);
        } else {
            // If session does not exist, redirect or handle unauthorized access
            return $this->renderErrorView(401); // You can define your own error handling method
        }
    }

    public function submitTambahPegawai()
    {
        if ($this->request->getPost()) {
            $id_akun = $this->request->getPost('id_akun');
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $jabatan = intval($this->request->getPost('jabatan'));
            $departemen = intval($this->request->getPost('departemen'));
            $status_aktif = $this->request->getPost('status_aktif');
            $jenis_pegawai = $this->request->getPost('jenis_pegawai');
            $telepon = $this->request->getPost('telepon');
            $tanggal_masuk = $this->request->getPost('tanggal_masuk');
    
            $alamat = $this->request->getPost('alamat');
            $alamat_lat = floatval($this->request->getPost('latitude'));
            $alamat_lon = floatval($this->request->getPost('longitude'));
            $kota = $this->request->getPost('kota');
            $kode_pos = $this->request->getPost('kode_pos');
    
            $pegawaiData = [
                'id_akun' => $id_akun,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'jabatan' => $jabatan,
                'departemen' => $departemen,
                'status_aktif' => $status_aktif,
                'jenis_pegawai' => $jenis_pegawai,
                'telepon' => $telepon,
                'tanggal_masuk' => $tanggal_masuk
            ];
    
            $alamatData = [
                'id_akun' => $id_akun,
                'alamat' => $alamat,
                'alamat_lat' => $alamat_lat,
                'alamat_lon' => $alamat_lon,
                'kota' => $kota,
                'kode_pos' => $kode_pos
            ];
    
            $pegawai_JSON = json_encode($pegawaiData);
            $alamat_JSON = json_encode($alamatData);
    
            $pegawai_url = $this->api_url . '/pegawai';
            $alamat_url = $this->api_url . '/akun/alamat';
    
            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');
    
                $ch_pegawai = curl_init($pegawai_url);
                curl_setopt($ch_pegawai, CURLOPT_POST, 1);
                curl_setopt($ch_pegawai, CURLOPT_POSTFIELDS, $pegawai_JSON);
                curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($pegawai_JSON),
                    'Authorization: Bearer ' . $token,
                ]);
    
                $response_pegawai = curl_exec($ch_pegawai);
    
                if ($response_pegawai) {
                    $http_status_code_pegawai = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);
                    curl_close($ch_pegawai);
    
                    if ($http_status_code_pegawai === 201) {
                        $ch_alamat = curl_init($alamat_url);
                        curl_setopt($ch_alamat, CURLOPT_POST, 1);
                        curl_setopt($ch_alamat, CURLOPT_POSTFIELDS, $alamat_JSON);
                        curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($alamat_JSON),
                            'Authorization: Bearer ' . $token,
                        ]);
    
                        $response_alamat = curl_exec($ch_alamat);
    
                        if ($response_alamat) {
                            $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);
                            curl_close($ch_alamat);
    
                            if ($http_status_code_alamat === 201) {
                                return redirect()->to(base_url('datapegawai?page=1&size=5'));
                            } else {
                                return $this->renderErrorView($http_status_code_alamat);
                            }
                        } else {
                            return $this->renderErrorView(500, curl_error($ch_alamat));
                        }
                    } else {
                        return $this->renderErrorView($http_status_code_pegawai);
                    }
                } else {
                    return $this->renderErrorView(500, curl_error($ch_pegawai));
                }
            } else {
                return $this->renderErrorView(401);
            }
        }
    }
    

    private function uploadFileImg($file_path)
    {
        // Check if the file exists
        if (!file_exists($file_path)) {
            return "Error: File not found.";
        }

        // Check if JWT token is provided
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            // Initialize cURL session for sending the POST request to upload the image
            $ch = curl_init($this->api_url . '/file/img');

            // Set cURL options for sending a POST request to upload the image
            $file_data = ['file' => new \CurlFile($file_path)]; // Create CurlFile object with the file path
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data); // Send as multipart form data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request to upload the image
            $response = curl_exec($ch);

            // Check for errors
            if (curl_errno($ch)) {
                $error_message = curl_error($ch);
                curl_close($ch);
                return "Error uploading image: " . $error_message;
            }

            // Close the cURL session
            curl_close($ch);

            // Decode the response
            $responseData = json_decode($response, true);

            // Check if the response contains URL
            if (isset($responseData['data']['url'])) {
                return $responseData['data']['url']; // Return the URL of the uploaded image
            } else {
                return "Error uploading image: Response does not contain URL. $response";
            }
        } else {
            // JWT token is not provided
            return "Error: JWT token is required.";
        }
    }

    public function editPegawai($pegawaiId)
{
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');

        $pegawai_url = $this->api_url . '/pegawai/' . $pegawaiId;

        $ch_pegawai = curl_init($pegawai_url);
        curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response_pegawai = curl_exec($ch_pegawai);

        if ($response_pegawai) {
            $http_status_code = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);

            if ($http_status_code === 200) {
                $pegawaiData = json_decode($response_pegawai, true);

                if (isset($pegawaiData['data']['id_akun'])) {
                    $id_akun = $pegawaiData['data']['id_akun'];

                    $alamat_url = $this->api_url . '/akun/alamat/' . $id_akun;

                    $ch_alamat = curl_init($alamat_url);
                    curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);

                    $response_alamat = curl_exec($ch_alamat);

                    if ($response_alamat) {
                        $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);

                        if ($http_status_code_alamat === 200) {
                            $alamatData = json_decode($response_alamat, true);

                            return view('/admin/editPegawai', [
                                'pegawaiData' => $pegawaiData['data'],
                                'alamatData' => $alamatData['data'],
                                'pegawaiId' => $pegawaiId,
                                'title' => 'Edit Alamat'
                            ]);
                        } else {
                            return $this->renderErrorView($http_status_code_alamat);
                        }
                    } else {
                        return $this->renderErrorView(500, curl_error($ch_alamat));
                    }

                    curl_close($ch_alamat);
                } else {
                    return $this->renderErrorView(404);
                }
            } else {
                return $this->renderErrorView($http_status_code);
            }
        } else {
            return $this->renderErrorView(500, curl_error($ch_pegawai));
        }

        curl_close($ch_pegawai);
    } else {
        return $this->renderErrorView(401);
    }
}



public function submitEditPegawai($pegawaiId)
{
    if ($this->request->getPost()) {
        $id_akun = $this->request->getPost('id_akun');
        $nip = $this->request->getPost('nip');
        $nama = $this->request->getPost('nama');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $jabatan = intval($this->request->getPost('jabatan'));
        $departemen = intval($this->request->getPost('departemen'));
        $status_aktif = $this->request->getPost('status_aktif');
        $jenis_pegawai = $this->request->getPost('jenis_pegawai');
        $telepon = $this->request->getPost('telepon');
        $tanggal_masuk = $this->request->getPost('tanggal_masuk');

        $pegawaiData = [
            'id_akun' => $id_akun,
            'nip' => $nip,
            'nama' => $nama,
            'jenis_kelamin' => $jenis_kelamin,
            'jabatan' => $jabatan,
            'departemen' => $departemen,
            'status_aktif' => $status_aktif,
            'jenis_pegawai' => $jenis_pegawai,
            'telepon' => $telepon,
            'tanggal_masuk' => $tanggal_masuk
        ];

        $pegawaiDataJSON = json_encode($pegawaiData);
        $pegawaiUrl = $this->api_url . '/pegawai/' . $pegawaiId;

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            $chPegawai = curl_init($pegawaiUrl);
            curl_setopt($chPegawai, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($chPegawai, CURLOPT_POSTFIELDS, $pegawaiDataJSON);
            curl_setopt($chPegawai, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chPegawai, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($pegawaiDataJSON),
                'Authorization: Bearer ' . $token,
            ]);

            $responsePegawai = curl_exec($chPegawai);

            if ($responsePegawai) {
                $httpStatusCodePegawai = curl_getinfo($chPegawai, CURLINFO_HTTP_CODE);
                if ($httpStatusCodePegawai === 200) {
                    $alamat = $this->request->getPost('alamat');
                    $alamat_lat = floatval($this->request->getPost('alamat_lat'));
                    $alamat_lon = floatval($this->request->getPost('alamat_lon'));
                    $kota = $this->request->getPost('kota');
                    $kode_pos = $this->request->getPost('kode_pos');

                    $alamatData = [
                        'id_akun' => $id_akun,
                        'alamat' => $alamat,
                        'alamat_lat' => $alamat_lat,
                        'alamat_lon' => $alamat_lon,
                        'kota' => $kota,
                        'kode_pos' => $kode_pos
                    ];

                    $alamatDataJSON = json_encode($alamatData);
                    $alamatUrl = $this->api_url . '/akun/alamat/' . $id_akun;

                    $chAlamat = curl_init($alamatUrl);
                    curl_setopt($chAlamat, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($chAlamat, CURLOPT_POSTFIELDS, $alamatDataJSON);
                    curl_setopt($chAlamat, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($chAlamat, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($alamatDataJSON),
                        'Authorization: Bearer ' . $token,
                    ]);

                    $responseAlamat = curl_exec($chAlamat);

                    if ($responseAlamat) {
                        $httpStatusCodeAlamat = curl_getinfo($chAlamat, CURLINFO_HTTP_CODE);
                        if ($httpStatusCodeAlamat === 200) {
                            return redirect()->to(base_url('datapegawai?page=1&size=5'));
                        } else {
                            return $this->renderErrorView($httpStatusCodeAlamat, $responseAlamat);
                        }
                    } else {
                        return $this->renderErrorView(500, curl_error($chAlamat));
                    }

                    curl_close($chAlamat);
                } else {
                    return $this->renderErrorView($httpStatusCodePegawai, $responsePegawai);
                }
            } else {
                return $this->renderErrorView(500, curl_error($chPegawai));
            }

            curl_close($chPegawai);
        } else {
            return $this->renderErrorView(401);
        }
    }
}


public function hapusPegawai($pegawaiId)
{
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');

        $fetchIdAkunUrl = $this->api_url . '/pegawai/' . $pegawaiId;
        $chIdAkun = curl_init($fetchIdAkunUrl);

        curl_setopt($chIdAkun, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chIdAkun, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $responseIdAkun = curl_exec($chIdAkun);

        if ($responseIdAkun) {
            $httpStatusCodeIdAkun = curl_getinfo($chIdAkun, CURLINFO_HTTP_CODE);
            curl_close($chIdAkun);

            if ($httpStatusCodeIdAkun === 200) {
                $pegawaiData = json_decode($responseIdAkun, true);
                $idAkun = $pegawaiData['data']['id_akun'];

                $deleteAlamatUrl = $this->api_url . '/akun/alamat/' . $idAkun;
                $chAlamat = curl_init($deleteAlamatUrl);

                curl_setopt($chAlamat, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($chAlamat, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chAlamat, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                ]);

                $responseAlamat = curl_exec($chAlamat);
                $httpStatusCodeAlamat = curl_getinfo($chAlamat, CURLINFO_HTTP_CODE);
                curl_close($chAlamat);

                if ($httpStatusCodeAlamat === 204) {
                    $deletePegawaiUrl = $this->api_url . '/pegawai/' . $pegawaiId;
                    $chPegawai = curl_init($deletePegawaiUrl);

                    curl_setopt($chPegawai, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($chPegawai, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($chPegawai, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);

                    $responsePegawai = curl_exec($chPegawai);
                    $httpStatusCodePegawai = curl_getinfo($chPegawai, CURLINFO_HTTP_CODE);
                    curl_close($chPegawai);

                    if ($httpStatusCodePegawai === 204) {
                        return redirect()->to(base_url('datapegawai?page=1&size=5'));
                    } else {
                        return $this->renderErrorView($httpStatusCodePegawai, $responsePegawai);
                    }
                } else {
                    return $this->renderErrorView($httpStatusCodeAlamat, $responseAlamat);
                }
            } else {
                return $this->renderErrorView($httpStatusCodeIdAkun, $responseIdAkun);
            }
        } else {
            return $this->renderErrorView(500, curl_error($chIdAkun));
        }
    } else {
        return $this->renderErrorView(401);
    }
}

}
