<?php

namespace App\Controllers;


class FileController extends BaseController
{
    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataFile()
    {
        $title = 'Data Akun';


        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            return  view('/admin/dataFile', ['title' => $title]);
        }
    }


    public function submitUnggahFile()
    {
        // Log request method
        log_message('debug', 'Request method: ' . $this->request->getMethod());

        // Check if the request method is POST
        if ($this->request->getMethod() === 'post') {
            // Log POST data
            log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));

            $file = $this->request->getFile('file_up');

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

                // Store the URL in session flashdata and redirect
                session()->setFlashdata('file_url2', $file_url2);
                log_message('debug', 'File uploaded successfully and URL stored in session: ' . $file_url2);
                return redirect()->back();
            } else {
                log_message('error', 'File upload failed.');
                // Handle file upload errors
                session()->setFlashdata('error', 'File upload failed. Please try again.');
                return redirect()->back();
            }
        } else {
            log_message('error', 'Request method is not POST. It is: ' . $this->request->getMethod());
            return "Request method is not POST. It is: " . $this->request->getMethod();
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

    public function dataFotoPegawai()
    {
        $title = 'Data Foto Pegawai';

        // Retrieve the value of the 'page' parameter from the request, default to 1 if not present
        $page = $this->request->getGet('page') ?? 1;

        // Retrieve the value of the 'size' parameter from the request, default to 5 if not present
        $size = $this->request->getGet('size') ?? 10;

        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');

            // URLs for fetching data
            $akun_url = $this->api_url . '/pegawai';
            $foto_url = $this->api_url . '/pegawai/foto?page=' . $page . '&size=' . $size;

            // Initialize cURL session for akun data
            $ch_akun = curl_init($akun_url);

            // Set cURL options for akun data
            curl_setopt($ch_akun, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_akun, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching akun data
            $response_akun = curl_exec($ch_akun);

            // Check the API response for akun data
            if ($response_akun) {
                $http_status_code_akun = curl_getinfo($ch_akun, CURLINFO_HTTP_CODE);

                if ($http_status_code_akun === 200) {
                    // Akun data fetched successfully
                    $akun_data = json_decode($response_akun, true);

                    // Close the cURL session for akun data
                    curl_close($ch_akun);

                    // Initialize cURL session for foto data
                    $ch_foto = curl_init($foto_url);

                    // Set cURL options for foto data
                    curl_setopt($ch_foto, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_foto, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);

                    // Execute the cURL request for fetching foto data
                    $response_foto = curl_exec($ch_foto);

                    // Check the API response for foto data
                    if ($response_foto) {
                        $http_status_code_foto = curl_getinfo($ch_foto, CURLINFO_HTTP_CODE);

                        if ($http_status_code_foto === 200) {
                            // Foto data fetched successfully
                            $foto_data = json_decode($response_foto, true);

                            // Close the cURL session for foto data
                            curl_close($ch_foto);

                            // Match foto with pegawai data
                            $matched_data = [];
                            foreach ($akun_data['data'] as $pegawai) {
                                foreach ($foto_data['data']['foto_pegawai'] as $foto) {
                                    if ($foto['id_pegawai'] === $pegawai['id']) {
                                        // Match found, add foto to matched data
                                        $matched_data[] = [
                                            'pegawai' => $pegawai,
                                            'foto' => $foto['foto']
                                        ];
                                        break; // No need to check further once matched
                                    }
                                }
                            }

                            return view('/admin/dataFotoPegawai', [
                                'akun_data' => $akun_data['data'],
                                'meta_data' => $foto_data['data'],
                                'matched_data' => $matched_data,
                                'title' => $title
                            ]);
                        } else {
                            // Error fetching foto data
                            return "Error fetching foto data. HTTP Status Code: $http_status_code_foto";
                        }
                    } else {
                        // Error fetching foto data
                        return "Error fetching foto data.";
                    }
                } else {
                    // Error fetching akun data
                    return "Error fetching akun data. HTTP Status Code: $http_status_code_akun";
                }
            } else {
                // Error fetching akun data
                return "Error fetching akun data.";
            }
        } else {
            return "User not logged in. Please log in first.";
        }
    }


    public function tambahFotoPegawai()
    {
        $title = 'Detail berkas';
        if (session()->has('jwt_token')) {



            return view('/admin/tambahFotoPegawai', ['title' => $title]);
        }
    }

    public function submitHasilFoto()
    {
        // Check if it's a POST request
        if ($this->request->getMethod() === 'post') {

            // Get the base64 image data from the request
            $base64Image = $this->request->getPost('photo');

            // Decode the base64 image data
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

            // Generate a unique name for the image file
            $imageFileName = uniqid() . '.png';

            // Define the path to save the image file
            $imageFilePath = ROOTPATH . 'public/uploads/' . $imageFileName;

            // Save the decoded image data to a file
            if (file_put_contents($imageFilePath, $imageData)) {
                // Obtain the file path after saving
                $foto_url = $imageFilePath;

                // Call the uploadFileImg method to upload the file and get the URL
                $foto_url2 = $this->uploadFileImg($foto_url);

                // Delete the uploaded file if the final URL was successfully obtained
                if ($foto_url2) {
                    // unlink($foto_url);

                    // Prepare the data to be sent to the view
                    $postData = [
                        'foto' => $foto_url2
                    ];

                    session()->set('foto_data', $postData);

                    return redirect()->to("/konfirmasifotopegawai");
                } else {
                    // Handle case where $foto_url2 is empty or null
                    return redirect()->back()->with('error', 'Failed to get photo URL after upload.');
                }
            } else {
                // Handle error if file could not be saved
                return redirect()->back()->with('error', 'Failed to save the photo.');
            }
        }

        // Handle cases where the request is not a POST request
        return redirect()->to('/');
    }


    public function konfirmasiFotoPegawai()
    {
        $title = 'Detail berkas';
        if (session()->has('jwt_token')) {



            return view('/admin/tambahKonfirmasiFoto', ['title' => $title]);
        }
    }


    public function submitKonfirmasiFotoPegawai()
    {
        if ($this->request->getMethod() === 'post') {

            // Retrieve the form data from the POST request
            $id_pegawai = $this->request->getPost('id_pegawai');
            $foto = $this->request->getPost('foto');

            // Prepare the data to be sent to the API
            $postData = [
                'id_pegawai' => $id_pegawai,
                'foto' => $foto,

            ];
            // Check if $foto is not empty or null
            if (empty($foto)) {
                return "Error: Foto field is empty or not provided.";
            }

            $tambah_foto_JSON = json_encode($postData);

            $akun_url = $this->api_url . '/pegawai/foto';

            // Check if the JWT token is present
            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');

                // Initialize cURL session for sending the POST request
                $ch = curl_init($akun_url);

                // Set cURL options for sending a POST request
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $tambah_foto_JSON);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($tambah_foto_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                // Execute the cURL request
                $response = curl_exec($ch);

                // Check if the API request was successful
                if ($response) {
                    // Check the HTTP status code in the response
                    $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                    if ($http_status_code === 201) {
                        return redirect()->to(base_url('datafotopegawai?page=1&size=5'));
                    } else {
                        // Error response from the API
                        log_message('error', 'Error creating account: ' . $response);
                        return "Error creating account: " . $response;
                    }
                } else {
                    // Error sending request to the API
                    $error_message = curl_error($ch);
                    log_message('error', 'Error sending request to the API: ' . $error_message);
                    return "Error sending request to the API: " . $error_message;
                }

                // Close the cURL session
                curl_close($ch);
            } else {
                // JWT token is missing
                log_message('error', 'JWT token is missing.');
                return "JWT token is required.";
            }
        } else {
            log_message('error', 'Request method is not POST.');
            return "Request method is not POST.";
        }
    }


    public function editFotoPegawai($userId)
    {

        if (session()->has('jwt_token')) {

            //retrieve the stored JWT Token
            $token = session()->get('jwt_token');

            // Fetch the user data from the API or database based on the user ID
            $user_url = $this->api_url . '/pegawai/foto/' . $userId;

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
                    return view('/admin/editFotoPegawai', ['userData' => $userData['data'], 'title' => 'Edit Foto Pegawai']);
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

    public function submitEditFotoPegawai($userId)
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id_pegawai = $this->request->getPost('id_pegawai');
            $base64Image = $this->request->getPost('photo');

            // Decode the base64 image data
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));

            // Generate a unique name for the image file
            $imageFileName = uniqid() . '.png';

            // Define the path to save the image file
            $imageFilePath = ROOTPATH . 'public/uploads/' . $imageFileName;

            // Save the decoded image data to a file
            if (file_put_contents($imageFilePath, $imageData)) {
                // Obtain the file path after saving
                $foto_url = $imageFilePath;

                // Call the uploadFileImg method to upload the file and get the URL
                $foto_url2 = $this->uploadFileImg($foto_url);

                // Delete the temporary uploaded file
                if (file_exists($foto_url)) {
                    if (unlink($foto_url)) {
                        // File deleted successfully
                        // Continue with your code
                    } else {
                        // Failed to delete the file
                        return redirect()->back()->with('error', 'Failed to delete temporary file.');
                    }
                } else {
                    // File does not exist at the expected path
                    return redirect()->back()->with('error', 'File not found at: ' . $foto_url);
                }


                if ($foto_url2) {
                    // Prepare the data to be sent to the API
                    $postData = [
                        'id_pegawai' => $id_pegawai,
                        'foto' => $foto_url2,
                    ];

                    $edit_akun_JSON = json_encode($postData);

                    // Proceed with API request
                    $akun_url = $this->api_url . '/pegawai/foto/' . $userId;

                    // Check if JWT token is present
                    if (session()->has('jwt_token')) {
                        $token = session()->get('jwt_token');

                        // Initialize cURL session for sending the PUT request
                        $ch = curl_init($akun_url);

                        // Set cURL options for sending a PUT request
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
                            // Check the HTTP status code in the response
                            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                            if ($http_status_code === 200) {
                                // Account updated successfully
                                return redirect()->to(base_url('datafotopegawai?page=1&size=10'));
                            } else {
                                // Error response from the API
                                log_message('error', 'Error updating account: ' . $response);
                                return "Error updating account: " . $response;
                            }
                        } else {
                            // Error sending request to the API
                            $error_message = curl_error($ch);
                            log_message('error', 'Error sending request to the API: ' . $error_message);
                            return "Error sending request to the API: " . $error_message;
                        }

                        // Close the cURL session
                        curl_close($ch);
                    } else {
                        // JWT token is missing
                        log_message('error', 'JWT token is missing.');
                        return "JWT token is required.";
                    }
                } else {
                    // Failed to get photo URL after upload
                    return redirect()->back()->with('error', 'Failed to get photo URL after upload.');
                }
            } else {
                // Failed to save the photo file
                return redirect()->back()->with('error', 'Failed to save the photo file.');
            }
        } else {
            // No POST data received
            log_message('error', 'No POST data received.');
            return "No POST data received.";
        }
    }


    public function hapusFotoPegawai($pegawaiId)
    {
        // Check if the user is logged in
        if (session()->has('jwt_token')) {
            // Retrieve the stored JWT token
            $token = session()->get('jwt_token');

            // URL for deleting the user data
            $delete_url = $this->api_url . '/pegawai/foto/' . $pegawaiId;

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
                return redirect()->to(base_url('datafotopegawai?page=1&size=5'));
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
