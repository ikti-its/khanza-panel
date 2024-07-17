<?php

namespace App\Controllers;


class AkunController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataAkun()
    {
        $title = 'Data Akun';
        $page = $this->request->getGet('page') ?? 1;
        $size = $this->request->getGet('size') ?? 5;
    
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $akun_url = $this->api_url . '/akun?page=' . $page . '&size=' . $size;
    
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
                    return view('/admin/dataAkun', ['akun_data' => $akun_data['data']['akun'], 'meta_data' => $akun_data['data'], 'title' => $title]);
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


    public function tambahAkun()
    {
        $title = 'Tambah Akun';
    
        // Check if jwt_token session exists
        if (session()->has('jwt_token')) {
            // If session exists, render the add account view
            return view('/admin/tambahAkun', ['title' => $title]);
        } else {
            // If session does not exist, redirect or handle unauthorized access
            return $this->renderErrorView(401); // You can define your own error handling method
        }
    }
    

    public function submitTambahAkun()
    {
        if ($this->request->getMethod() === 'post') {

            // Retrieve the form data from the POST request
            $email = $this->request->getPost('email');
            $role = intval($this->request->getPost('role'));
            $password = $this->request->getPost('password');
            $file = $this->request->getFile('profilePhoto');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                log_message('debug', 'File is valid and not moved yet.');

                $fileName = $file->getRandomName();
                $file->move(ROOTPATH . 'public/uploads/', $fileName);

                $file_url = ROOTPATH . 'public/uploads/' . $fileName;

                $file_url2 = $this->uploadFileImg($file_url);

                // Delete the uploaded file if the final URL was successfully obtained
                if ($file_url2) {
                    unlink($file_url); // Delete the file
                }

                // Prepare the data to be sent to the API
                $postData = [
                    'email' => $email,
                    'role' => $role,
                    'password' => $password,
                    'foto' => $file_url2 // Use the URL obtained after uploading the file
                ];

                $tambah_akun_JSON = json_encode($postData);

                $akun_url = $this->api_url . '/akun';

                // Check if the JWT token is present
                if (session()->has('jwt_token')) {
                    $token = session()->get('jwt_token');

                    // Initialize cURL session for sending the POST request
                    $ch = curl_init($akun_url);

                    // Set cURL options for sending a POST request
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $tambah_akun_JSON);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($tambah_akun_JSON),
                        'Authorization: Bearer ' . $token,
                    ]);

                    // Execute the cURL request
                    $response = curl_exec($ch);

                    // Check if the API request was successful
                    if ($response) {
                        // Check the HTTP status code in the response
                        $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                        curl_close($ch);

                        if ($http_status_code === 201) {
                            // Account created successfully
                            log_message('debug', 'Account created successfully.');
                            return redirect()->to(base_url('dataakun?page=1&size=5'));
                        } else {
                            // Error response from the API
                            log_message('error', 'Error creating account: ' . $response);
                            return $this->renderErrorView($http_status_code);
                        }
                    } else {
                        // Error sending request to the API
                        $error_message = curl_error($ch);
                        curl_close($ch);
                        log_message('error', 'Error sending request to the API: ' . $error_message);
                        return $this->renderErrorView(500);
                    }
                } else {
                    // JWT token is missing
                    log_message('error', 'JWT token is missing.');
                    return $this->renderErrorView(401);
                }
            } else {
                // File upload failed
                log_message('error', 'File upload failed.');
                return $this->renderErrorView(400);
            }
        } else {
            log_message('error', 'Request method is not POST.');
            return $this->renderErrorView(405);
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

    public function editAkun($userId)
    {

        if (session()->has('jwt_token')) {

            //retrieve the stored JWT Token
            $token = session()->get('jwt_token');

            // Fetch the user data from the API or database based on the user ID
            $user_url = $this->api_url . '/akun/' . $userId;

            //Initialize cURL session
            $ch_user = curl_init($user_url);

            // Set cURL options
            curl_setopt($ch_user, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_user, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching user data
            $response_user = curl_exec($ch_user);

            // Check the API response for user data

            if ($response_user) {
                $http_status_code = curl_getinfo($ch_user, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    //user data fetched successfully
                    $userData = json_decode($response_user, true);

                    //Render the view to edit user data, passing the user data
                    return view('/admin/editAkun', ['userData' => $userData['data'], 'userId' => $userId, 'title' => 'Edit User']);
                } else {
                    // Error fetching user data
                    return "Error fetching user data. HTTP Status Code: $http_status_code $userId";
                }
            } else {
                //Error fetching user data
                return "Error fetching user data.";
            }

            //Close the cURL session for user data
            curl_close($ch_user);
        } else {
            //User not logged in
            return "User not logged in. Please log in first. ";
        }
    }

    public function submitEditAkun($userId)
{
    if ($this->request->getPost()) {
        // Retrieve the form data from the POST request
        $email = $this->request->getPost('email');
        $role = intval($this->request->getPost('role'));
        $password = $this->request->getPost('password');
        $file = $this->request->getFile('profilePhoto');

        // Get the current photo URL from the form data
        $currentPhoto = $this->request->getPost('currentPhoto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            log_message('debug', 'File is valid and not moved yet.');

            $fileName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/', $fileName);

            $file_url = ROOTPATH . 'public/uploads/' . $fileName;

            $file_url2 = $this->uploadFileImg($file_url);

            // Delete the uploaded file if the final URL was successfully obtained
            if ($file_url2) {
                unlink($file_url); // Delete the file
            }

            // Use the new photo URL
            $photoUrl = $file_url2;
        } else {
            // Use the existing photo URL
            $photoUrl = $currentPhoto;
        }

        // Prepare the data to be sent to the API
        $postData = [
            'email' => $email,
            'role' => $role,
            'password' => $password,
            'foto' => $photoUrl
        ];

        $edit_akun_JSON = json_encode($postData);

        $akun_url = $this->api_url . '/akun/' . $userId;

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
                    $title = 'Data Akun';

                    // Pass the updated account data along with the title to the view
                    return redirect()->to(base_url('dataakun?page=1&size=5'));
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


    public function hapusAkun($userId)
    {
        // Check if the user is logged in
        if (session()->has('jwt_token')) {
            // Retrieve the stored JWT token
            $token = session()->get('jwt_token');

            // URL for deleting the user data
            $delete_url = $this->api_url .  '/akun/' . $userId;

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
                return redirect()->to(base_url('dataakun?page=1&size=5'));
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
