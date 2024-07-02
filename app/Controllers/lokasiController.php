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


        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            // URL for fetching akun data
            $lokasi_url = $this->api_url . '/organisasi/current';

            // Initialize cURL session
            $ch_lokasi = curl_init($lokasi_url);

            // Set cURL options
            curl_setopt($ch_lokasi, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_lokasi, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching akun data
            $response_lokasi = curl_exec($ch_lokasi);

            // Check the API response for akun data
            if ($response_lokasi) {
                $http_status_code_lokasi = curl_getinfo($ch_lokasi, CURLINFO_HTTP_CODE);

                if ($http_status_code_lokasi === 200) {
                    // Akun data fetched successfully
                    $lokasi_data = json_decode($response_lokasi, true);

                    // $total_pages = $akun_data['data']['total'];
                
                    return  view('/admin/dataLokasi', ['lokasi_data' => $lokasi_data['data'], 'title' => $title]);
                } else {
                    // Error fetching akun data
                    return "Error fetching akun data. HTTP Status Code: $http_status_code_lokasi";
                }
            } else {
                // Error fetching akun data
                return "Error fetching akun data.";
            }

            // Close the cURL session for akun data
            curl_close($ch_lokasi);
        } else {
            return "User not logged in. Please log in first.";
        }
    }

    public function dataDetailJadwal($pegawaiID)
    {
        $title = 'Data Detail Jadwal';


        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            // URL for fetching akun data
            $jadwal_url = $this->api_url . '/kehadiran/jadwal/pegawai/' . $pegawaiID;

            // Initialize cURL session
            $ch_jadwal = curl_init($jadwal_url);

            // Set cURL options
            curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching akun data
            $response_akun = curl_exec($ch_jadwal);

            // Check the API response for akun data
            if ($response_akun) {
                $http_status_code_cuti = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

                if ($http_status_code_cuti === 200) {
                    // Akun data fetched successfully
                    $jadwal_data = json_decode($response_akun, true);

                    // $total_pages = $akun_data['data']['total'];

                    return  view('/admin/detailJadwal', ['jadwal_data' => $jadwal_data['data'], 'title' => $title]);
                } else {
                    // Error fetching akun data
                    return "Error fetching akun data. HTTP Status Code: $http_status_code_cuti";
                }
            } else {
                // Error fetching akun data
                return "Error fetching akun data.";
            }

            // Close the cURL session for akun data
            curl_close($ch_jadwal);
        } else {
            return "User not logged in. Please log in first.";
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

            //retrieve the stored JWT Token
            $token = session()->get('jwt_token');

            // Fetch the user data from the API or database based on the user ID
            $jadwal_url = $this->api_url . '/kehadiran/jadwal/' . $userId;

            //Initialize cURL session
            $ch_jadwal = curl_init($jadwal_url);

            // Set cURL options
            curl_setopt($ch_jadwal, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_jadwal, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching user data
            $response_user = curl_exec($ch_jadwal);

            // Check the API response for user data

            if ($response_user) {
                $http_status_code = curl_getinfo($ch_jadwal, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    //user data fetched successfully
                    $jadwalData = json_decode($response_user, true);

                    //Render the view to edit user data, passing the user data
                    return view('/admin/editJadwal', ['jadwalData' => $jadwalData['data'], 'userId' => $userId, 'title' => 'Edit Cuti']);
                } else {
                    // Error fetching user data
                    return "Error fetching user data. HTTP Status Code: $http_status_code $userId";
                }
            } else {
                //Error fetching user data
                return "Error fetching user data.";
            }

            //Close the cURL session for user data
            curl_close($ch_jadwal);
        } else {
            //User not logged in
            return "User not logged in. Please log in first. ";
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

            // Prepare the data to be sent to the API
            $postData = [
                'id' => $id,
                'nama' => $nama,
                'alamat' => $alamat,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ];;

            $edit_akun_JSON = json_encode($postData);

            $akun_url = $this->api_url . '/organisasi/' . $userId;

            // Check if email and role are provided
            if (session()->has('jwt_token')) {
                // Assume you have some validation logic here for email and role

                $token = session()->get('jwt_token');

                // Initialize cURL session for sending the PUT request
                $ch = curl_init($akun_url);

                // Set cURL options for sending a PUT request
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, ($edit_akun_JSON));
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

                    // Check if the HTTP status code in the response
                    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($http_status_code === 200) {
                        // Account updated successfully
                        $title = 'Data Lokasi';

                        // Pass the updated account data along with the title to the view
                        return redirect()->to(base_url('lokasiorganisasi'));
                    } else {
                        // Error response from the API
                        return "Error updating account: " . $response;
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

    public function hapusCuti($userId)
    {
        // Check if the user is logged in
        if (session()->has('jwt_token')) {
            // Retrieve the stored JWT token
            $token = session()->get('jwt_token');

            // URL for deleting the user data
            $delete_url = $this->api_url .  '/kehadiran/cuti/' . $userId;

            // Initialize cURL session for sending the DELETE request
            $ch = curl_init($delete_url);

            // Set cURL options for sending a DELETE request
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request
            $response = curl_exec($ch);

            // Check the HTTP status code in the response
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_status_code === 204) {
                // User deleted successfully
                return redirect()->to(base_url('datacuti?page=1&size=5'));
            } else {
                // Error response from the API
                return "Error deleting user: " . $response;
            }

            // Close the cURL session
            curl_close($ch);
        } else {
            // User not logged in
            return "User not logged in. Please log in first.";
        }
    }
}
