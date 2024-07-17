<?php

namespace App\Controllers;


class lokasiController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataLokasi()
{
    $title = 'Data Lokasi';

    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $lokasi_url = $this->api_url . '/organisasi';

        $ch_lokasi = curl_init($lokasi_url);
        curl_setopt($ch_lokasi, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_lokasi, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response_lokasi = curl_exec($ch_lokasi);

        if ($response_lokasi) {
            $http_status_code_lokasi = curl_getinfo($ch_lokasi, CURLINFO_HTTP_CODE);

            if ($http_status_code_lokasi === 200) {
                $lokasi_data = json_decode($response_lokasi, true);
                return view('/admin/dataLokasi', [
                    'lokasi_data' => $lokasi_data['data'],
                    'title' => $title
                ]);
            } else {
                return $this->renderErrorView($http_status_code_lokasi);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_lokasi);
    } else {
        return $this->renderErrorView(401);
    }
}


public function submitEditLokasi($userId)
{
    if ($this->request->getPost()) {
        // Retrieve the form data from the POST request
        $id = $this->request->getPost('id');
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $latitude = floatval($this->request->getPost('latitude'));
        $longitude = floatval($this->request->getPost('longitude'));
        $radius = floatval($this->request->getPost('radiusz'));

        // Prepare the data to be sent to the API
        $postData = [
            'id' => $id,
            'nama' => $nama,
            'alamat' => $alamat,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'radius' => $radius,
        ];

        $edit_akun_JSON = json_encode($postData);
        $akun_url = $this->api_url . '/organisasi/' . $userId;

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            // Initialize cURL session for sending the PUT request
            $ch = curl_init($akun_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $edit_akun_JSON);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($edit_akun_JSON),
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request
            $response = curl_exec($ch);

            // Check if the API request was successful
            if ($response) {
                $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    return redirect()->to(base_url('lokasiorganisasi'));
                } else {
                    return $this->renderErrorView($http_status_code);
                }
            } else {
                return $this->renderErrorView(500);
            }

            curl_close($ch);
        } else {
            return $this->renderErrorView(401);
        }
    }
}


  
}
