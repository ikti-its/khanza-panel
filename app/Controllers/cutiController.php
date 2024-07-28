<?php

namespace App\Controllers;


class CutiController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataCuti()
{
    $title = 'Data Cuti';

    // Retrieve the value of the 'page' parameter from the request, default to 1 if not present
    $page = $this->request->getGet('page') ?? 1;
    $size = $this->request->getGet('size') ?? 5;

    // Check if the user is logged in
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $cuti_url = $this->api_url . '/kehadiran/cuti?page=' . $page . '&size=' . $size;

        // Initialize cURL session
        $ch_cuti = curl_init($cuti_url);
        curl_setopt($ch_cuti, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_cuti, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request
        $response_cuti = curl_exec($ch_cuti);

        if ($response_cuti) {
            $http_status_code_cuti = curl_getinfo($ch_cuti, CURLINFO_HTTP_CODE);

            if ($http_status_code_cuti === 200) {
                $cuti_data = json_decode($response_cuti, true);

                // Close the cURL session for cuti data
                curl_close($ch_cuti);

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

                        // Merge cuti data with akun data
                        $cuti = $cuti_data['data']['cuti'];
                        $akun_pegawai = $data_pegawai['data'];

                        // Create an associative array for akun data with id_pegawai as the key
                        $akun_pegawai_assoc = [];
                        foreach ($akun_pegawai as $akun) {
                            $akun_pegawai_assoc[$akun['id']] = $akun['nama'];
                        }

                        // Add 'nama' field to cuti data if id_pegawai matches
                        foreach ($cuti as &$c) {
                            if (isset($akun_pegawai_assoc[$c['id_pegawai']])) {
                                $c['nama'] = $akun_pegawai_assoc[$c['id_pegawai']];
                            } else {
                                $c['nama'] = 'Nama tidak ditemukan';
                            }
                        }

                        // Return the view with the merged data
                        return view('/admin/dataCuti', [
                            'cuti_data' => $cuti,
                            'meta_data' => $cuti_data['data'],
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
                // Error fetching cuti data
                curl_close($ch_cuti);
                return $this->renderErrorView($http_status_code_cuti);
            }
        } else {
            // Error fetching cuti data
            $error_message = curl_error($ch_cuti);
            curl_close($ch_cuti);
            return $this->renderErrorView(500);
        }
    } else {
        // User not logged in
        return $this->renderErrorView(401);
    }
}



public function tambahCuti()
{
    $title = 'Tambah Cuti';

    // Check if the user is logged in
    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');

        // Fetch alasan cuti data
        $alasan_cuti_url = $this->api_url . '/ref/alasan-cuti';
        $ch_alasan_cuti = curl_init($alasan_cuti_url);
        curl_setopt($ch_alasan_cuti, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_alasan_cuti, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response_alasan_cuti = curl_exec($ch_alasan_cuti);

        if ($response_alasan_cuti) {
            $http_status_code_alasan_cuti = curl_getinfo($ch_alasan_cuti, CURLINFO_HTTP_CODE);

            if ($http_status_code_alasan_cuti === 201) {
                $alasan_cuti_data = json_decode($response_alasan_cuti, true);
                curl_close($ch_alasan_cuti);

                // Render the add cuti view with the alasan cuti data
                return view('/admin/tambahCuti', [
                    'title' => $title,
                    'alasan_cuti_data' => $alasan_cuti_data['data']
                ]);
            } else {
                // Error fetching alasan cuti data
                curl_close($ch_alasan_cuti);
                return $this->renderErrorView($http_status_code_alasan_cuti);
            }
        } else {
            // Error fetching alasan cuti data
            $error_message = curl_error($ch_alasan_cuti);
            curl_close($ch_alasan_cuti);
            return $this->renderErrorView(500);
        }
    } else {
        // User not logged in
        return $this->renderErrorView(401);
    }
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

    public function editCuti($userId)
{
    if (session()->has('jwt_token')) {
        // Retrieve the stored JWT Token
        $token = session()->get('jwt_token');

        // Fetch the user data from the API or database based on the user ID
        $cuti_url = $this->api_url . '/kehadiran/cuti/' . $userId;

        // Initialize cURL session
        $ch_cuti = curl_init($cuti_url);

        // Set cURL options
        curl_setopt($ch_cuti, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_cuti, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        // Execute the cURL request for fetching user data
        $response_cuti = curl_exec($ch_cuti);

        // Check the API response for user data
        if ($response_cuti) {
            $http_status_code = curl_getinfo($ch_cuti, CURLINFO_HTTP_CODE);

            if ($http_status_code === 200) {
                // User data fetched successfully
                $cutiData = json_decode($response_cuti, true);

                // Fetch alasan cuti data
                $alasan_cuti_url = $this->api_url . '/ref/alasan-cuti';
                $ch_alasan_cuti = curl_init($alasan_cuti_url);
                curl_setopt($ch_alasan_cuti, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_alasan_cuti, CURLOPT_HTTPHEADER, [
                    'Authorization: Bearer ' . $token,
                ]);

                $response_alasan_cuti = curl_exec($ch_alasan_cuti);

                if ($response_alasan_cuti) {
                    $http_status_code_alasan_cuti = curl_getinfo($ch_alasan_cuti, CURLINFO_HTTP_CODE);

                    if ($http_status_code_alasan_cuti === 201) {
                        $alasan_cuti_data = json_decode($response_alasan_cuti, true);
                        curl_close($ch_alasan_cuti);

                        // Render the view to edit user data, passing the user data and alasan cuti data
                        return view('/admin/editCuti', [
                            'cutiData' => $cutiData['data'],
                            'userId' => $userId,
                            'title' => 'Edit Cuti',
                            'alasan_cuti_data' => $alasan_cuti_data['data']
                        ]);
                    } else {
                        // Error fetching alasan cuti data
                        curl_close($ch_alasan_cuti);
                        return "Error fetching alasan cuti data. HTTP Status Code: $http_status_code_alasan_cuti";
                    }
                } else {
                    // Error fetching alasan cuti data
                    $error_message = curl_error($ch_alasan_cuti);
                    curl_close($ch_alasan_cuti);
                    return "Error fetching alasan cuti data: $error_message";
                }
            } else {
                // Error fetching user data
                curl_close($ch_cuti);
                return "Error fetching user data. HTTP Status Code: $http_status_code";
            }
        } else {
            // Error fetching user data
            $error_message = curl_error($ch_cuti);
            curl_close($ch_cuti);
            return "Error fetching user data: $error_message";
        }
    } else {
        // User not logged in
        return "User not logged in. Please log in first.";
    }
}

    public function submitEditCuti($userId)
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id_pegawai = $this->request->getPost('id_pegawai');
            $tanggal_mulai = $this->request->getPost('tanggal_mulai');
            $tanggal_selesai = $this->request->getPost('tanggal_selesai');
            $id_alasan_cuti = $this->request->getPost('id_alasan_cuti');
            $status = $this->request->getPost('status');

            // Prepare the data to be sent to the API
            $postData = [
                'id_pegawai' => $id_pegawai,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'id_alasan_cuti' => $id_alasan_cuti,
                'status' => $status
            ];;

            $edit_akun_JSON = json_encode($postData);

            $akun_url = $this->api_url . '/kehadiran/cuti/' . $userId;

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
                        $title = 'Data Cuti';

                        // Pass the updated account data along with the title to the view
                        return redirect()->to(base_url('datacuti?page=1&size=5'));
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
