<?php

namespace App\Controllers;


class pegawaiController extends BaseController
{

    protected $api_url;

    public function __construct()
    {
        $this->api_url = getenv('api_URL');
    }


    public function dataPegawai()
    {
        $title = 'Data Pegawai dan Alamat';

        // Retrieve the value of the 'page' parameter from the request, default to 1 if not present
        $page = $this->request->getGet('page') ?? 1;

        // Retrieve the value of the 'size' parameter from the request, default to 5 if not present
        $size = $this->request->getGet('size') ?? 10;

        // Check if the user is logged in
        // Retrieve the stored JWT token
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            // URL for fetching akun data
            $akun_url = $this->api_url . '/pegawai?page=' . $page . '&size=' . $size;

            // Initialize cURL session
            $ch_akun = curl_init($akun_url);

            // Set cURL options
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

                    // URL for fetching alamat data
                    $alamat_url = $this->api_url . '/akun/alamat?page=' . $page . '&size=' . $size;

                    // Initialize cURL session for alamat data
                    $ch_alamat = curl_init($alamat_url);
                    curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);
                    $response_alamat = curl_exec($ch_alamat);

                    if ($response_alamat) {
                        $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);

                        if ($http_status_code_alamat === 200) {
                            //Alamat data fetched successfully
                            $alamat_data = json_decode($response_alamat, true);

                            //return the view both pegawai and alamat data
                            return view('/admin/dataPegawai', [

                                'akun_data' => $akun_data['data']['pegawai'],
                                'alamat_data' => $alamat_data['data']['alamat'],
                                'meta_data' => $akun_data['data'],
                                'title' => $title

                            ]);
                        }
                    }
                } else {
                    // Error fetching akun data
                    return "Error fetching akun data. HTTP Status Code: $http_status_code_akun";
                }
            } else {
                // Error fetching akun data
                return "Error fetching akun data.";
            }

            // Close the cURL session for akun data
            curl_close($ch_akun);
        } else {
            return "User not logged in. Please log in first.";
        }
    }

    public function tambahPegawai()
    {
        $title = 'Tambah Pegawai';

        // If the request method is not POST or form data is missing, render the add account view
        echo view('/admin/tambahPegawai', ['title' => $title]);
    }

    public function submitTambahPegawai()
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id_akun = $this->request->getPost('id_akun');
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $jabatan = intval($this->request->getPost('jabatan'));
            $departemen = intval($this->request->getPost('departemen'));
            $status_aktif = $this->request->getPost('status_aktif');
            $jenis_pegawai = $this->request->getPost('jenis_pegawai');
            $telepon = $this->request->getPost('telepon');
            $tanggal_masuk = $this->request->getPost('tanggal_masuk');

            // Retrieve additional alamat data from the POST request
            $alamat = $this->request->getPost('alamat');
            $alamat_lat = floatval($this->request->getPost('alamat_lat'));
            $alamat_lon = floatval($this->request->getPost('alamat_lon'));
            $kota = $this->request->getPost('kota');
            $kode_pos = $this->request->getPost('kode_pos');

            // Prepare the data to be sent to the API for pegawai
            $pegawaiData = [
                'id_akun' => $id_akun,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'jabatan' => $jabatan,
                'departemen' => $departemen,
                'status_aktif' => $status_aktif,
                'jenis_pegawai' => $jenis_pegawai,
                'telepon' => $telepon,
                'tanggal_masuk' => $tanggal_masuk
            ];

            // Prepare the data to be sent to the API for alamat
            $alamatData = [
                'id_akun' => $id_akun,
                'alamat' => $alamat,
                'alamat_lat' => $alamat_lat,
                'alamat_lon' => $alamat_lon,
                'kota' => $kota,
                'kode_pos' => $kode_pos
            ];

            $pegawai_JSON = json_encode($pegawaiData);
            $alamat_JSON = json_encode($alamatData);

            $pegawai_url = $this->api_url . '/pegawai';
            $alamat_url = $this->api_url . '/akun/alamat';

            // Check if JWT token is present
            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');

                // Initialize cURL session for pegawai data
                $ch_pegawai = curl_init($pegawai_url);
                curl_setopt($ch_pegawai, CURLOPT_POST, 1);
                curl_setopt($ch_pegawai, CURLOPT_POSTFIELDS, $pegawai_JSON);
                curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($pegawai_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                // Execute the cURL request for pegawai data
                $response_pegawai = curl_exec($ch_pegawai);

                // Check if the API request was successful for pegawai data
                if ($response_pegawai) {
                    $http_status_code_pegawai = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);

                    // Close the cURL session for pegawai data
                    curl_close($ch_pegawai);

                    if ($http_status_code_pegawai === 201) {
                        // Account created successfully for pegawai data

                        // Initialize cURL session for alamat data
                        $ch_alamat = curl_init($alamat_url);
                        curl_setopt($ch_alamat, CURLOPT_POST, 1);
                        curl_setopt($ch_alamat, CURLOPT_POSTFIELDS, $alamat_JSON);
                        curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($alamat_JSON),
                            'Authorization: Bearer ' . $token,
                        ]);

                        // Execute the cURL request for alamat data
                        $response_alamat = curl_exec($ch_alamat);

                        // Check if the API request was successful for alamat data
                        if ($response_alamat) {
                            $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);

                            // Close the cURL session for alamat data
                            curl_close($ch_alamat);

                            if ($http_status_code_alamat === 201) {
                                // Account created successfully for alamat data

                                // Redirect to a success page or perform any other necessary action
                                return redirect()->to(base_url('datapegawai?page=1&size=5'));
                            } else {
                                // Error response from the API for alamat data
                                return "Error creating alamat: " . $alamat_JSON;
                            }
                        } else {
                            // Error sending request to the API for alamat data
                            return "Error sending request to the API for alamat data.";
                        }
                    } else {
                        // Error response from the API for pegawai data
                        return "Error creating pegawai account: " . $pegawai_JSON;
                    }
                } else {
                    // Error sending request to the API for pegawai data
                    return "Error sending request to the API for pegawai data.";
                }
            } else {
                // JWT token is not present
                return "JWT token is required.";
            }
        }
    }

    public function editPegawai($pegawaiId)
    {
        if (session()->has('jwt_token')) {
            // Retrieve the stored JWT Token
            $token = session()->get('jwt_token');

            // Fetch the Pegawai data from the API or database based on the Pegawai ID
            $pegawai_url = $this->api_url . '/pegawai/' . $pegawaiId;

            // Initialize cURL session
            $ch_pegawai = curl_init($pegawai_url);

            // Set cURL options
            curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching Pegawai data
            $response_pegawai = curl_exec($ch_pegawai);

            // Check the API response for Pegawai data
            if ($response_pegawai) {
                $http_status_code = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);

                if ($http_status_code === 200) {
                    // Pegawai data fetched successfully
                    $pegawaiData = json_decode($response_pegawai, true);

                    // Check if the Pegawai has associated Alamat data
                    if (isset($pegawaiData['data']['id_akun'])) {
                        $id_akun = $pegawaiData['data']['id_akun'];

                        // Fetch the Alamat data based on id_akun
                        $alamat_url = $this->api_url . '/akun/alamat/' . $id_akun;

                        // Initialize cURL session for fetching Alamat data
                        $ch_alamat = curl_init($alamat_url);

                        // Set cURL options
                        curl_setopt($ch_alamat, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch_alamat, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $token,
                        ]);

                        // Execute the cURL request for fetching Alamat data
                        $response_alamat = curl_exec($ch_alamat);

                        // Check the API response for Alamat data
                        if ($response_alamat) {
                            $http_status_code_alamat = curl_getinfo($ch_alamat, CURLINFO_HTTP_CODE);

                            if ($http_status_code_alamat === 200) {
                                // Alamat data fetched successfully
                                $alamatData = json_decode($response_alamat, true);

                                // Render the view to edit Alamat data, passing the Alamat data
                                return view('/admin/editPegawai', ['pegawaiData' => $pegawaiData['data'], 'alamatData' => $alamatData['data'], 'pegawaiId' => $pegawaiId, 'title' => 'Edit Alamat']);
                            } else {
                                // Error fetching Alamat data
                                return "Error fetching Alamat data. HTTP Status Code: $http_status_code_alamat";
                            }
                        } else {
                            // Error fetching Alamat data
                            return "Error fetching Alamat data.";
                        }

                        // Close the cURL session for Alamat data
                        curl_close($ch_alamat);
                    } else {
                        // Pegawai does not have associated Alamat data
                        return "Pegawai does not have associated Alamat data.";
                    }
                } else {
                    // Error fetching Pegawai data
                    return "Error fetching Pegawai data. HTTP Status Code: $http_status_code";
                }
            } else {
                // Error fetching Pegawai data
                return "Error fetching Pegawai data.";
            }

            // Close the cURL session for Pegawai data
            curl_close($ch_pegawai);
        } else {
            // User not logged in
            return "User not logged in. Please log in first.";
        }
    }



    public function submitEditPegawai($pegawaiId)
    {
        if ($this->request->getPost()) {

            // Retrieve the form data from the POST request
            $id_akun = $this->request->getPost('id_akun');
            $nip = $this->request->getPost('nip');
            $nama = $this->request->getPost('nama');
            $jenis_kelamin = $this->request->getPost('jenis_kelamin');
            $jabatan = intval($this->request->getPost('jabatan'));
            $departemen = intval($this->request->getPost('departemen'));
            $status_aktif = $this->request->getPost('status_aktif');
            $jenis_pegawai = $this->request->getPost('jenis_pegawai');
            $telepon = $this->request->getPost('telepon');
            $tanggal_masuk = $this->request->getPost('tanggal_masuk');

            // Prepare the Pegawai data to be sent to the API
            $pegawaiData = [
                'id_akun' => $id_akun,
                'nip' => $nip,
                'nama' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'jabatan' => $jabatan,
                'departemen' => $departemen,
                'status_aktif' => $status_aktif,
                'jenis_pegawai' => $jenis_pegawai,
                'telepon' => $telepon,
                'tanggal_masuk' => $tanggal_masuk
            ];

            // Convert Pegawai data to JSON format
            $pegawaiDataJSON = json_encode($pegawaiData);

            // Pegawai API endpoint for updating Pegawai data
            $pegawaiUrl = $this->api_url . '/pegawai/' . $pegawaiId;

            // Check if email and role are provided
            if (session()->has('jwt_token')) {
                // Assume you have some validation logic here for email and role

                $token = session()->get('jwt_token');

                // Initialize cURL session for sending the PUT request to update Pegawai data
                $chPegawai = curl_init($pegawaiUrl);

                // Set cURL options for sending a PUT request to update Pegawai data
                curl_setopt($chPegawai, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($chPegawai, CURLOPT_POSTFIELDS, $pegawaiDataJSON);
                curl_setopt($chPegawai, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($chPegawai, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($pegawaiDataJSON),
                    'Authorization: Bearer ' . $token,
                ]);

                // Execute the cURL request to update Pegawai data
                $responsePegawai = curl_exec($chPegawai);

                // Check if the API request to update Pegawai data was successful
                if ($responsePegawai) {
                    // Check if the HTTP status code in the response
                    $httpStatusCodePegawai = curl_getinfo($chPegawai, CURLINFO_HTTP_CODE);
                    if ($httpStatusCodePegawai === 200) {
                        // Data updated successfully

                        // Now, update Alamat data
                        // Retrieve Alamat data from the POST request
                        $alamat = $this->request->getPost('alamat');
                        $alamat_lat = floatval($this->request->getPost('alamat_lat'));
                        $alamat_lon = floatval($this->request->getPost('alamat_lon'));
                        $kota = $this->request->getPost('kota');
                        $kode_pos = $this->request->getPost('kode_pos');

                        // Prepare the Alamat data to be sent to the API
                        $alamatData = [
                            'id_akun' => $id_akun,
                            'alamat' => $alamat,
                            'alamat_lat' => $alamat_lat,
                            'alamat_lon' => $alamat_lon,
                            'kota' => $kota,
                            'kode_pos' => $kode_pos
                        ];

                        // Convert Alamat data to JSON format
                        $alamatDataJSON = json_encode($alamatData);

                        // Alamat API endpoint for updating Alamat data
                        $alamatUrl = $this->api_url . '/akun/alamat/' . $id_akun;

                        // Initialize cURL session for sending the PUT request to update Alamat data
                        $chAlamat = curl_init($alamatUrl);

                        // Set cURL options for sending a PUT request to update Alamat data
                        curl_setopt($chAlamat, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($chAlamat, CURLOPT_POSTFIELDS, $alamatDataJSON);
                        curl_setopt($chAlamat, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($chAlamat, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($alamatDataJSON),
                            'Authorization: Bearer ' . $token,
                        ]);

                        // Execute the cURL request to update Alamat data
                        $responseAlamat = curl_exec($chAlamat);

                        // Check if the API request to update Alamat data was successful
                        if ($responseAlamat) {
                            // Check if the HTTP status code in the response
                            $httpStatusCodeAlamat = curl_getinfo($chAlamat, CURLINFO_HTTP_CODE);
                            if ($httpStatusCodeAlamat === 200) {
                                // Data updated successfully
                                $title = 'Data Updated';

                                // Redirect to the appropriate page after successful update
                                return redirect()->to(base_url('datapegawai?page=1&size=5'));
                            } else {
                                // Error response from the API for Alamat update
                                return "Error updating Alamat data: " . $responseAlamat;
                            }
                        } else {
                            // Error sending request to the API for Alamat update
                            return "Error sending request to the API for Alamat update.";
                        }

                        // Close the cURL session for updating Alamat data
                        curl_close($chAlamat);
                    } else {
                        // Error response from the API for Pegawai update
                        return "Error updating Pegawai data: " . $responsePegawai;
                    }
                } else {
                    // Error sending request to the API for Pegawai update
                    return "Error sending request to the API for Pegawai update.";
                }

                // Close the cURL session for updating Pegawai data
                curl_close($chPegawai);
            } else {
                // Email or role is empty
                return "Email and role are required.";
            }
        }
    }


    public function hapusPegawai($pegawaiId)
    {
        // Check if the user is logged in
        if (session()->has('jwt_token')) {
            // Retrieve the stored JWT token
            $token = session()->get('jwt_token');

            // URL for fetching the id_akun associated with the provided pegawaiId
            $fetchIdAkunUrl = $this->api_url . '/pegawai/' . $pegawaiId;

            // Initialize cURL session for sending the GET request to fetch id_akun
            $chIdAkun = curl_init($fetchIdAkunUrl);

            // Set cURL options for sending a GET request
            curl_setopt($chIdAkun, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chIdAkun, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request for fetching id_akun
            $responseIdAkun = curl_exec($chIdAkun);

            if ($responseIdAkun) {
                // Check the HTTP status code in the response
                $httpStatusCodeIdAkun = curl_getinfo($chIdAkun, CURLINFO_HTTP_CODE);
                // Close the cURL session for fetching id_akun
                curl_close($chIdAkun);

                // Check if fetching id_akun was successful
                if ($httpStatusCodeIdAkun === 200) {
                    // Decode the response to extract id_akun
                    $pegawaiData = json_decode($responseIdAkun, true);

                    // Extract id_akun
                    $idAkun = $pegawaiData['data']['id_akun'];


                    // URL for deleting the Alamat data using id_akun
                    $deleteAlamatUrl = $this->api_url . '/akun/alamat/' . $idAkun;

                    // Initialize cURL session for sending the DELETE request for Alamat
                    $chAlamat = curl_init($deleteAlamatUrl);

                    // Set cURL options for sending a DELETE request for Alamat
                    curl_setopt($chAlamat, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($chAlamat, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($chAlamat, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);

                    // Execute the cURL request for deleting Alamat data
                    $responseAlamat = curl_exec($chAlamat);

                    // Check the HTTP status code in the response for Alamat deletion
                    $httpStatusCodeAlamat = curl_getinfo($chAlamat, CURLINFO_HTTP_CODE);

                    // Close the cURL session for Alamat deletion
                    curl_close($chAlamat);

                    // Check if Alamat data deletion was successful
                    if ($httpStatusCodeAlamat === 204) {
                        // URL for deleting the Pegawai data
                        $deletePegawaiUrl = $this->api_url . '/pegawai/' . $pegawaiId;

                        // Initialize cURL session for sending the DELETE request for Pegawai
                        $chPegawai = curl_init($deletePegawaiUrl);

                        // Set cURL options for sending a DELETE request for Pegawai
                        curl_setopt($chPegawai, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($chPegawai, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($chPegawai, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . $token,
                        ]);

                        // Execute the cURL request for deleting Pegawai data
                        $responsePegawai = curl_exec($chPegawai);

                        // Check the HTTP status code in the response for Pegawai deletion
                        $httpStatusCodePegawai = curl_getinfo($chPegawai, CURLINFO_HTTP_CODE);

                        // Close the cURL session for Pegawai deletion
                        curl_close($chPegawai);

                        // Check if Pegawai data deletion was successful
                        if ($httpStatusCodePegawai === 204) {
                            // Both Pegawai and Alamat data deleted successfully
                            return redirect()->to(base_url('datapegawai?page=1&size=5'));
                        } else {
                            // Error response from the API for Pegawai deletion
                            return "Error deleting Pegawai data: " . $responsePegawai;
                        }
                    } else {
                        // Error response from the API for Alamat deletion
                        return "Error deleting Alamat data: " . $responseAlamat;
                    }
                } else {
                    // Error response from the API for fetching id_akun
                    return "Error fetching id_akun: " . $responseIdAkun;
                }
            }
        } else {
            // User not logged in
            return "User not logged in. Please log in first.";
        }
    }
}
