<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PersetujuanController extends BaseController
{
    public function dataPersetujuan()
    {
        $title = 'Data Pengajuan Medis';

        $page = $this->request->getGet('page') ?? 1;
        $size = $this->request->getGet('size') ?? 5;

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $api_url = $this->api_url;
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan?page=' . $page . '&size=' . $size;
            $pesanan_url = $this->api_url . '/pengadaan/pesanan';
            $user_url = $this->api_url . '/auth';
            $persetujuan_url = $this->api_url . '/pengadaan/persetujuan';

            // Initialize cURL for fetching pengajuan data
            $ch_pengajuan = curl_init($pengajuan_url);
            curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request to fetch pengajuan data
            $response_pengajuan = curl_exec($ch_pengajuan);
            $ch_pesanan = curl_init($pesanan_url);
            curl_setopt($ch_pesanan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pesanan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request to fetch pesanan data
            $response_pesanan = curl_exec($ch_pesanan);

            // Initialize cURL for fetching user data
            $ch_user = curl_init($user_url);
            curl_setopt($ch_user, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_user, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request to fetch user data
            $response_user = curl_exec($ch_user);

            // Initialize cURL for fetching approval data
            $ch_persetujuan = curl_init($persetujuan_url);
            curl_setopt($ch_persetujuan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_persetujuan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            // Execute the cURL request to fetch approval data
            $response_persetujuan = curl_exec($ch_persetujuan);

            if ($response_pengajuan && $response_pesanan && $response_persetujuan) {
                // Check if the responses are successful

                $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                $http_status_code_pesanan = curl_getinfo($ch_pesanan, CURLINFO_HTTP_CODE);
                $http_status_code_persetujuan = curl_getinfo($ch_persetujuan, CURLINFO_HTTP_CODE);

                if ($http_status_code_pengajuan === 200 && $http_status_code_pesanan === 200 && $http_status_code_persetujuan === 200) {
                    // Decode the JSON responses
                    $pengajuan_medis_data = json_decode($response_pengajuan, true);
                    $pesanan_data = json_decode($response_pesanan, true);
                    $user_data = json_decode($response_user, true);
                    $persetujuan_data = json_decode($response_persetujuan, true);

                    // Render the view with the fetched data
                    return view('/admin/pengadaan/persetujuan', [
                        'pengajuan_medis_data' => $pengajuan_medis_data['data']['pengajuan_barang_medis'],
                        'meta_data' => $pengajuan_medis_data['data'],
                        'pesanan_data' => $pesanan_data['data'], // Add pesanan data to the view
                        'user_data' => $user_data['data'], // Add user data to the view
                        'persetujuan_data' => $persetujuan_data['data'], // Add approval data to the view
                        'api_url' => $api_url,
                        'token' => $token,
                        'title' => $title
                    ]);
                } else {
                    // Error handling for unsuccessful HTTP status codes
                    return "Error fetching data. HTTP Status Code Pengajuan: " . $http_status_code_pengajuan . ", HTTP Status Code Pesanan: " . $http_status_code_pesanan . ", HTTP Status Code Persetujuan: " . $response_persetujuan;
                }
            } else {
                // Error handling for failed cURL requests
                return "Error fetching data.";
            }
        } else {
            return "User not logged in. Please log in first.";
        }
    }
    public function submitTambahPersetujuan($pengajuanId)
    {
        if ($this->request->getPost()) {
            $idpengajuan = $this->request->getPost('idpengajuan');
            $statusapoteker = $this->request->getPost('statusapoteker') ?? "Menunggu Persetujuan";
            $statuskeuangan = $this->request->getPost('statuskeuangan') ?? "Menunggu Persetujuan";
            $statuspersetujuan = $this->request->getPost('statuspersetujuan');
            $idapoteker = $this->request->getPost('idapoteker');
            $idkeuangan = $this->request->getPost('idkeuangan');

            $persetujuan_url = $this->api_url . '/pengadaan/persetujuan/' . $pengajuanId;
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan/' . $idpengajuan;

            $postDataPersetujuan = [
                'id_pengajuan' => $idpengajuan,
                'status' => $statuspersetujuan,
                'status_apoteker' => $statusapoteker,
                'status_keuangan' => $statuskeuangan,
                'id_apoteker' => $idapoteker,
                'id_keuangan' => $idkeuangan,
            ];
            $tambah_persetujuan_JSON = json_encode($postDataPersetujuan);

            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');
                $ch_persetujuan = curl_init($persetujuan_url);

                curl_setopt($ch_persetujuan, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch_persetujuan, CURLOPT_POSTFIELDS, ($tambah_persetujuan_JSON));
                curl_setopt($ch_persetujuan, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_persetujuan, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($tambah_persetujuan_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                $response_persetujuan = curl_exec($ch_persetujuan);

                if ($response_persetujuan) {
                    $http_status_code_persetujuan = curl_getinfo($ch_persetujuan, CURLINFO_HTTP_CODE);
                    if ($http_status_code_persetujuan === 200) {
                        return redirect()->to(base_url('persetujuanpengadaan'));
                        // $ch_pengajuan = curl_init($pengajuan_url);

                        // curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
                        // curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                        //     'Authorization: Bearer ' . $token,
                        // ]);
                        // $response_pengajuan = curl_exec($ch_pengajuan);
                        // $pengajuan_data = json_decode($response_pengajuan, true);

                        // $putDataPengajuan = [
                        //     'tanggal_pengajuan' => $pengajuan_data['data']['tanggal_pengajuan'],
                        //     'nomor_pengajuan' => $pengajuan_data['data']['nomor_pengajuan'],
                        //     'id_supplier' => $pengajuan_data['data']['id_supplier'],
                        //     'id_pegawai' => $pengajuan_data['data']['id_pegawai'],
                        //     'diskon_persen' => $pengajuan_data['data']['diskon_persen'],
                        //     'diskon_jumlah' => $pengajuan_data['data']['diskon_jumlah'],
                        //     'pajak_persen' => $pengajuan_data['data']['pajak_persen'],
                        //     'pajak_jumlah' => $pengajuan_data['data']['pajak_jumlah'],
                        //     'materai' => $pengajuan_data['data']['materai'],
                        //     'status_pesanan' => '3',
                        //     'catatan' => $pengajuan_data['data']['catatan'],
                        // ];
                        // $update_pengajuan_JSON = json_encode($putDataPengajuan);

                        // $ch_pengajuan = curl_init($pengajuan_url);
                        // curl_setopt($ch_pengajuan, CURLOPT_CUSTOMREQUEST, "PUT");
                        // curl_setopt($ch_pengajuan, CURLOPT_POSTFIELDS, $update_pengajuan_JSON);
                        // curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
                        // curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                        //     'Content-Type: application/json',
                        //     'Authorization: Bearer ' . $token,
                        // ]);

                        // $response_pengajuan = curl_exec($ch_pengajuan);

                        // if ($response_pengajuan) {
                        //     $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                        //     if ($http_status_code_pengajuan === 200) {

                        //         return redirect()->to(base_url('persetujuanmedis'));
                        //     } else {
                        //         return "Error Update Pengajuan: " . $response_pengajuan;
                        //     }
                        //     curl_close($ch_persetujuan);
                        //     curl_close($ch_pengajuan);
                        // } else {
                        //     return "Error sending request to the obat API.";
                        // }
                    } else {
                        return "Error Insert Persetujuan: " . $response_persetujuan;
                    }
                } else {
                    return "Error sending request to the API.";
                }
            } else {
                return "User not logged in. Please log in first.";
            }
        } else {
            return "Data is required.";
        }
    }
}
