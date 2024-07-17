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
    $size = $this->request->getGet('size') ?? 5;

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
        $response_akun = curl_exec($ch_jadwal);

        if ($response_akun) {
            $http_status_code_jadwal = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

            if ($http_status_code_jadwal === 200) {
                $jadwal_data = json_decode($response_akun, true);

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
                return $this->renderErrorView($http_status_code_jadwal);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_jadwal);
    } else {
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

        // Initialize cURL session
        $ch_jadwal = curl_init($jadwal_url);
        curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request
        $response_akun = curl_exec($ch_jadwal);

        if ($response_akun) {
            $http_status_code_jadwal = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

            if ($http_status_code_jadwal === 200) {
                $jadwal_data = json_decode($response_akun, true);
                return view('/admin/detailJadwal', ['jadwal_data' => $jadwal_data['data'], 'title' => $title]);
            } else {
                return $this->renderErrorView($http_status_code_jadwal);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_jadwal);
    } else {
        return $this->renderErrorView(401);
    }
}


    public function tambahCuti()
    {
        $title = 'Tambah Cuti';

        // If the request method is not POST or form data is missing, render the add account view
        echo view('/admin/tambahCuti', ['title' => $title]);
    }

    public function submitTambahCuti()
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id_pegawai = $this->request->getPost('id_pegawai');
            $tanggal_mulai = $this->request->getPost('tanggal_mulai');
            $tanggal_selesai = $this->request->getPost('tanggal_selesai');
            $id_alasan_cuti = $this->request->getPost('id_alasan_cuti');
            $status = 'Diproses';

            // Prepare the data to be sent to the API
            $postData = [
                'id_pegawai' => $id_pegawai,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'id_alasan_cuti' => $id_alasan_cuti,
                'status' => $status
            ];;
            
            

            $tambah_cuti_JSON = json_encode($postData);

            $cuti_url = $this->api_url . '/kehadiran/cuti';

            // Check if email and role are provided
            if (session()->has('jwt_token')) {
                // Assume you have some validation logic here for email and role

                $token = session()->get('jwt_token');

                // Initialize cURL session for sending the POST request
                $ch = curl_init($cuti_url);

                // Set cURL options for sending a POST request
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($tambah_cuti_JSON));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($tambah_cuti_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                // Execute the cURL request
                $response = curl_exec($ch);

                // Check if the API request was successful
                if ($response) {

                    // Check if the HTTP status code in the response
                    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($http_status_code === 201) {
                        // Account created successfully
                        $title = 'Data Cuti';

                        // Pass the created account data along with the title to the view
                        return redirect()->to(base_url('datacuti?page=1&size=5'));
                    } else {
                        // Error response from the API
                        return "Error creating account: " . $response;
                    }
                } else {
                    // Error sending request to the API
                    return "Error sending request to the API.";
                }

                // Close the cURL session
                curl_close($ch);
            } else {
                // Email or role is empty
                return "Email and role are required.";
            }
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
