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
}
