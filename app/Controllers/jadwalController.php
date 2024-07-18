<?php

namespace App\Controllers;


class JadwalController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataJadwal()
{
    $title = 'Data Jadwal';

    // Retrieve the value of the 'page' parameter from the request, default to 1 if not present
    $page = $this->request->getGet('page') ?? 1;
    $size = $this->request->getGet('size') ?? 20;

    // Check if the user is logged in
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $jadwal_url = $this->api_url . '/kehadiran/jadwal?page=' . $page . '&size=' . $size;

        // Initialize cURL session
        $ch_jadwal = curl_init($jadwal_url);
        curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request
        $response_jadwal = curl_exec($ch_jadwal);

        if ($response_jadwal) {
            $http_status_code_jadwal = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

            if ($http_status_code_jadwal === 200) {
                $jadwal_data = json_decode($response_jadwal, true);

                // Close the cURL session for jadwal data
                curl_close($ch_jadwal);

                // Now, include data from dataPegawai controller
                // URL for fetching data pegawai
                $data_pegawai_url = $this->api_url . '/pegawai';

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

                        // Add 'nama' field to jadwal data if id_pegawai matches
                        foreach ($jadwal_data['data']['jadwal_pegawai'] as &$jadwal) {
                            if (isset($akun_pegawai_assoc[$jadwal['id_pegawai']])) {
                                $jadwal['nama'] = $akun_pegawai_assoc[$jadwal['id_pegawai']];
                            } else {
                                $jadwal['nama'] = 'Nama tidak ditemukan';
                            }
                        }

                        // Group the data by 'id_pegawai'
                        $groupedData = [];
                        foreach ($jadwal_data['data']['jadwal_pegawai'] as $jadwalEntry) {
                            if (!isset($groupedData[$jadwalEntry['id_pegawai']])) {
                                $groupedData[$jadwalEntry['id_pegawai']] = $jadwalEntry;
                            }
                        }

                        // Prepare meta data for pagination
                        $metaData = [
                            'page' => $page,
                            'size' => $size,
                            'total' => ceil(count($groupedData) / $size)
                        ];

                        return view('/admin/dataJadwal', [
                            'jadwal_data' => array_values($groupedData),
                            'meta_data' => $metaData,
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
                // Error fetching jadwal data
                curl_close($ch_jadwal);
                return $this->renderErrorView($http_status_code_jadwal);
            }
        } else {
            // Error fetching jadwal data
            $error_message = curl_error($ch_jadwal);
            curl_close($ch_jadwal);
            return $this->renderErrorView(500);
        }
    } else {
        // User not logged in
        return $this->renderErrorView(401);
    }
}


    

public function dataDetailJadwal($pegawaiID)
{
    $title = 'Data Detail Jadwal';

    // Check if the user is logged in
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $jadwal_url = $this->api_url . '/kehadiran/jadwal/pegawai/' . $pegawaiID;

        // Initialize cURL session for jadwal
        $ch_jadwal = curl_init($jadwal_url);
        curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request for jadwal
        $response_jadwal = curl_exec($ch_jadwal);

        if ($response_jadwal) {
            $http_status_code_jadwal = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

            if ($http_status_code_jadwal === 200) {
                $jadwal_data = json_decode($response_jadwal, true);

                // Close the cURL session for jadwal data
                curl_close($ch_jadwal);

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

                        // Add 'nama' field to jadwal data if id_pegawai matches
                        foreach ($jadwal_data['data'] as &$jadwal) {
                            if (isset($akun_pegawai_assoc[$jadwal['id_pegawai']])) {
                                $jadwal['nama'] = $akun_pegawai_assoc[$jadwal['id_pegawai']];
                            } else {
                                $jadwal['nama'] = 'Nama tidak ditemukan';
                            }
                        }

                        // Return the view with the merged data
                        return view('/admin/detailJadwal', [
                            'jadwal_data' => $jadwal_data['data'],
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
                // Error fetching jadwal data
                curl_close($ch_jadwal);
                return $this->renderErrorView($http_status_code_jadwal);
            }
        } else {
            // Error fetching jadwal data
            $error_message = curl_error($ch_jadwal);
            curl_close($ch_jadwal);
            return $this->renderErrorView(500);
        }
    } else {
        // User not logged in
        return $this->renderErrorView(401);
    }
}




    public function editJadwal($userId)
{
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $jadwal_url = $this->api_url . '/kehadiran/jadwal/' . $userId;

        // Initialize cURL session
        $ch_jadwal = curl_init($jadwal_url);
        curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request for fetching user data
        $response_user = curl_exec($ch_jadwal);

        if ($response_user) {
            $http_status_code = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

            if ($http_status_code === 200) {
                $jadwalData = json_decode($response_user, true);
                return view('/admin/editJadwal', ['jadwalData' => $jadwalData['data'], 'userId' => $userId, 'title' => 'Edit Cuti']);
            } else {
                return $this->renderErrorView($http_status_code);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_jadwal);
    } else {
        return $this->renderErrorView(401);
    }
}


public function submitEditJadwal($userId)
{
    if ($this->request->getPost()) {
        $id = $this->request->getPost('id');
        $id_pegawai = $this->request->getPost('id_pegawai');
        $id_hari = intval($this->request->getPost('id_hari'));
        $id_shift = $this->request->getPost('id_shift');

        $postData = [
            'id' => $id,
            'id_pegawai' => $id_pegawai,
            'id_hari' => $id_hari,
            'id_shift' => $id_shift,
        ];

        $edit_akun_JSON = json_encode($postData);
        $akun_url = $this->api_url . '/kehadiran/jadwal/' . $userId;

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            $ch = curl_init($akun_url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $edit_akun_JSON);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($edit_akun_JSON),
                'Authorization: Bearer ' . $token,
            ]);

            $response = curl_exec($ch);

            if ($response) {
                $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    return redirect()->to(base_url('jadwalpegawai?page=1&size=5'));
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


public function hapusCuti($userId)
{
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $delete_url = $this->api_url . '/kehadiran/cuti/' . $userId;

        $ch = curl_init($delete_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response = curl_exec($ch);
        $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_status_code === 204) {
            return redirect()->to(base_url('datacuti?page=1&size=5'));
        } else {
            return $this->renderErrorView($http_status_code);
        }

        curl_close($ch);
    } else {
        return $this->renderErrorView(401);
    }
}

}
