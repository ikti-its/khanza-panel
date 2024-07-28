<?php

namespace App\Controllers;


class ShiftController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataShift()
    {
        $title = 'Data Shift';

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $shift_url = $this->api_url . '/ref/shift';
    
            $ch_shift = curl_init($shift_url);
            curl_setopt($ch_shift, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_shift, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
    
            $response_shift = curl_exec($ch_shift);
    
            if ($response_shift) {
                $http_status_code_shift = curl_getinfo($ch_shift, CURLINFO_HTTP_CODE);
    
                if ($http_status_code_shift === 201) {
                    $shift_data = json_decode($response_shift, true);
                    return view('/admin/dataShift', ['shift_data' => $shift_data['data'], 'title' => $title]);
                } else {
                    return $this->renderErrorView($http_status_code_shift);
                }
            } else {
                return $this->renderErrorView(500);
            }
    
            curl_close($ch_shift);
        } else {
            return $this->renderErrorView(401);
        }
    }


    public function tambahShift()
    {
        $title = 'Tambah Shift Kerja';

         // Check if jwt_token session exists
         if (session()->has('jwt_token')) {
            // If session exists, render the add account view
            return view('/admin/tambahShift', ['title' => $title]);
        } else {
            // If session does not exist, redirect or handle unauthorized access
            return $this->renderErrorView(401); // You can define your own error handling method
        }
    }

    public function submitTambahShift()
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id = $this->request->getPost('id');
            $nama = $this->request->getPost('nama');
            $jam_masuk = $this->request->getPost('jam_masuk');
            $jam_pulang = $this->request->getPost('jam_pulang');

            // Prepare the data to be sent to the API
            $postData = [
                'id' => $id,
                'nama' => $nama,
                'jam_masuk' => $jam_masuk,
                'jam_pulang' => $jam_pulang,
            ];;
            
            

            $tambah_cuti_JSON = json_encode($postData);

            $cuti_url = $this->api_url . '/ref/shift';

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
                        $title = 'Data Shift';

                        // Pass the created account data along with the title to the view
                        return redirect()->to(base_url('datashift'));
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

    public function editShift($userId)
    {

        if (session()->has('jwt_token')) {

            //retrieve the stored JWT Token
            $token = session()->get('jwt_token');

            // Fetch the user data from the API or database based on the user ID
            $cuti_url = $this->api_url . '/ref/shift/' . $userId;

            //Initialize cURL session
            $ch_shift = curl_init($cuti_url);

            // Set cURL options
            curl_setopt($ch_shift, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_shift, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching user data
            $response_user = curl_exec($ch_shift);

            // Check the API response for user data

            if ($response_user) {
                $http_status_code = curl_getinfo($ch_shift, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    //user data fetched successfully
                    $shiftData = json_decode($response_user, true);

                    //Render the view to edit user data, passing the user data
                    return view('/admin/editShift', ['cutiData' => $shiftData['data'], 'userId' => $userId, 'title' => 'Edit Shift']);
                } else {
                    // Error fetching user data
                    return "Error fetching user data. HTTP Status Code: $http_status_code $userId";
                }
            } else {
                //Error fetching user data
                return "Error fetching user data.";
            }

            //Close the cURL session for user data
            curl_close($ch_shift);
        } else {
            //User not logged in
            return "User not logged in. Please log in first. ";
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
