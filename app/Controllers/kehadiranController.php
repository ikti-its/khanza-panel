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


        // Retrieve the value of the 'page' parameter from the request, default to 1 if not present
        $page = $this->request->getGet('page') ?? 1;

        // Retrieve the value of the 'size' parameter from the request, default to 5 if not present
        $size = $this->request->getGet('size') ?? 5;

        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            // URL for fetching akun data
            $kehadiran_url = $this->api_url . '/kehadiran/presensi?page=' . $page . '&size=' . $size;

            // Initialize cURL session
            $ch_kehadiran = curl_init($kehadiran_url);

            // Set cURL options
            curl_setopt($ch_kehadiran, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_kehadiran, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching akun data
            $response_kehadiran = curl_exec($ch_kehadiran);

            // Check the API response for akun data
            if ($response_kehadiran) {
                $http_status_code_kehadiran = curl_getinfo($ch_kehadiran, CURLINFO_HTTP_CODE);

                if ($http_status_code_kehadiran === 200) {
                    // Akun data fetched successfully
                    $kehadiran_data = json_decode($response_kehadiran, true);

                    // $total_pages = $akun_data['data']['total'];

                    return  view('/admin/dataKehadiran', ['kehadiran_data' => $kehadiran_data['data']['presensi'], 'meta_data' => $kehadiran_data['data'], 'title' => $title]);
                } else {
                    // Error fetching akun data
                    return "Error fetching akun data. HTTP Status Code: $http_status_code_kehadiran";
                }
            } else {
                // Error fetching akun data
                return "Error fetching akun data.";
            }

            // Close the cURL session for akun data
            curl_close($ch_kehadiran);
        } else {
            return "User not logged in. Please log in first.";
        }
    }
    

    
}
