<?php

namespace App\Controllers;


class KehadiranController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataKehadiran()
    {
        $title = 'Data Kehadiran';
    
        $page = $this->request->getGet('page') ?? 1;
        $size = $this->request->getGet('size') ?? 10;
    
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $kehadiran_url = $this->api_url . '/kehadiran/presensi?page=' . $page . '&size=' . $size;
    
            // Initialize cURL session for kehadiran
            $ch_kehadiran = curl_init($kehadiran_url);
            curl_setopt($ch_kehadiran, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_kehadiran, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
    
            // Execute the cURL request for kehadiran
            $response_kehadiran = curl_exec($ch_kehadiran);
    
            if ($response_kehadiran) {
                $http_status_code_kehadiran = curl_getinfo($ch_kehadiran, CURLINFO_HTTP_CODE);
    
                if ($http_status_code_kehadiran === 200) {
                    $kehadiran_data = json_decode($response_kehadiran, true);
    
                    // Close the cURL session for kehadiran data
                    curl_close($ch_kehadiran);
    
                    // Now, include data from dataPegawai controller
                    // URL for fetching data pegawai
                    $data_pegawai_url = $this->api_url . '/pegawai'; // Assuming a large size to fetch all data
    
                    // Initialize cURL session for data pegawai
                    $ch_data_pegawai = curl_init($data_pegawai_url);
                    curl_setopt($ch_data_pegawai, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_data_pegawai, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);
    
                    // Execute the cURL request for fetching data pegawai
                    $response_data_pegawai = curl_exec($ch_data_pegawai);
    
                    // Check the API response for data pegawai
                    if ($response_data_pegawai) {
                        $http_status_code_data_pegawai = curl_getinfo($ch_data_pegawai, CURLINFO_HTTP_CODE);
    
                        if ($http_status_code_data_pegawai === 200) {
                            // Data pegawai fetched successfully
                            $data_pegawai = json_decode($response_data_pegawai, true);
    
                            // Close the cURL session for data pegawai
                            curl_close($ch_data_pegawai);
    
                            // Create an associative array for akun data with id_pegawai as the key
                            $akun_pegawai_assoc = [];
                            foreach ($data_pegawai['data'] as $akun) {
                                $akun_pegawai_assoc[$akun['id']] = $akun['nama'];
                            }
    
                            // Add 'nama' field to kehadiran data if id_pegawai matches
                            foreach ($kehadiran_data['data']['presensi'] as &$kehadiran) {
                                if (isset($akun_pegawai_assoc[$kehadiran['id_pegawai']])) {
                                    $kehadiran['nama'] = $akun_pegawai_assoc[$kehadiran['id_pegawai']];
                                } else {
                                    $kehadiran['nama'] = 'Nama tidak ditemukan';
                                }
                            }
    
                            return view('/admin/dataKehadiran', [
                                'kehadiran_data' => $kehadiran_data['data']['presensi'],
                                'meta_data' => $kehadiran_data['data'],
                                'title' => $title
                            ]);
                        } else {
                            // Error fetching data pegawai
                            curl_close($ch_data_pegawai);
                            return $this->renderErrorView($http_status_code_data_pegawai);
                        }
                    } else {
                        // Error fetching data pegawai
                        $error_message = curl_error($ch_data_pegawai);
                        curl_close($ch_data_pegawai);
                        return $this->renderErrorView(500);
                    }
                } else {
                    // Error fetching kehadiran data
                    curl_close($ch_kehadiran);
                    return $this->renderErrorView($http_status_code_kehadiran);
                }
            } else {
                // Error fetching kehadiran data
                $error_message = curl_error($ch_kehadiran);
                curl_close($ch_kehadiran);
                return $this->renderErrorView(500);
            }
        } else {
            return $this->renderErrorView(401);
        }
    }
    

    

    
}
