<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PemesananController extends BaseController
{
    public function dataPemesananMedis()
    {
        $title = 'Data Pemesanan Medis';

        $page = $this->request->getGet('page') ?? 1;

        $size = $this->request->getGet('size') ?? 5;

        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $pemesanan_url = $this->api_url . '/pengadaan/pemesanan?page=' . $page . '&size=' . $size;
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan';
            $ch_pemesanan = curl_init($pemesanan_url);
            curl_setopt($ch_pemesanan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pemesanan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_pemesanan = curl_exec($ch_pemesanan);

            $ch_pengajuan = curl_init($pengajuan_url);
            curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_pengajuan = curl_exec($ch_pengajuan);

            if ($response_pemesanan && $response_pengajuan) {
                $http_status_code_pemesanan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                $http_status_code_pengajuan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                if ($http_status_code_pemesanan === 200 && $http_status_code_pengajuan === 200) {
                    $pemesanan_medis_data = json_decode($response_pemesanan, true);
                    $pengajuan_medis_data = json_decode($response_pengajuan, true);

                    return view('/admin/pengadaan/medis/pemesanan/data_pemesanan', [
                        'pemesanan_medis_data' => $pemesanan_medis_data['data']['pemesanan_barang_medis'],
                        'pengajuan_medis_data' => $pengajuan_medis_data['data'],
                        'meta_data' => $pemesanan_medis_data['data'],
                        'title' => $title
                    ]);
                } else {
                    return "Response medis data:" . $response_pemesanan;
                }
            } else {
                return "Error fetching akun data.";
            }
        } else {
            return "User not logged in. Please log in first.";
        }
    }

    public function tambahPemesananMedis()
    {
        $title = 'Tambah Pemesanan Medis';
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $api_url = $this->api_url;
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan';
            $barang_medis_url = $this->api_url . '/inventaris/medis';
            $pegawai_url = $this->api_url . '/pegawai';

            $ch_pegawai = curl_init($pegawai_url);
            curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_pegawai = curl_exec($ch_pegawai);
            $ch_pengajuan = curl_init($pengajuan_url);
            curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_pengajuan = curl_exec($ch_pengajuan);

            $ch_barang_medis = curl_init($barang_medis_url);
            curl_setopt($ch_barang_medis, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_barang_medis, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_barang_medis = curl_exec($ch_barang_medis);

            if ($response_pegawai && $response_pengajuan && $response_barang_medis) {
                $http_status_code_pegawai = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);
                $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                if ($http_status_code_pegawai === 200 && $http_status_code_pengajuan === 200) {
                    $pegawai_data = json_decode($response_pegawai, true);
                    $pengajuan_data = json_decode($response_pengajuan, true);
                    $barang_medis_data = json_decode($response_barang_medis, true);
                } else {
                    return "Response pegawai data:" . $response_pegawai .
                        "<br><br>Response pengajuan data:" . $response_pengajuan .
                        "<br><br>Response barang medis data:" . $response_barang_medis;
                }
            } else {
                return "Error fetching pegawai data.";
            }

            echo view('/admin/pengadaan/medis/pemesanan/tambah_pemesanan', [
                'pegawai_data' => $pegawai_data['data'],
                'pengajuan_data' => $pengajuan_data['data'],
                'barang_medis_data' => $barang_medis_data['data'],
                'api_url' => $api_url,
                'token' => $token,
                'title' => $title
            ]);
        } else {
            return "User not logged in. Please log in first.";
        }
    }

    public function submitTambahPemesananMedis()
    {
        if ($this->request->getPost()) {
            $tglpemesanan = $this->request->getPost('tglpemesanan');
            $nopemesanan = $this->request->getPost('nopemesanan');
            $idpengajuan = $this->request->getPost('idpengajuan');
            $pegawaipemesanan = $this->request->getPost('pegawaipemesanan');


            $tglpengajuan = $this->request->getPost('tglpengajuan');
            $nopengajuan = $this->request->getPost('nopengajuan');
            $supplier = intval($this->request->getPost('supplier'));
            $pegawaipengajuan = $this->request->getPost('pegawaipengajuan');
            $diskonpersen = intval($this->request->getPost('diskonpersen'));
            $diskonjumlah = intval($this->request->getPost('diskonjumlah'));
            $pajakpersen = intval($this->request->getPost('pajakpersen'));
            $pajakjumlah = intval($this->request->getPost('pajakjumlah'));
            $materai = intval($this->request->getPost('materai'));
            $catatanpengajuan = $this->request->getPost('catatanpengajuan');
            $statuspesanan = $this->request->getPost('statuspesanan');

            $pemesanan_url = $this->api_url . '/pengadaan/pemesanan';

            $postDataPemesanan = [
                'tanggal_pesan' => $tglpemesanan,
                'no_pemesanan' => $nopemesanan,
                'id_pengajuan' => $idpengajuan,
                'id_pegawai' => $pegawaipemesanan,
            ];
            $tambah_pemesanan_JSON = json_encode($postDataPemesanan);


            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');
                $ch_pemesanan = curl_init($pemesanan_url);

                curl_setopt($ch_pemesanan, CURLOPT_POST, 1);
                curl_setopt($ch_pemesanan, CURLOPT_POSTFIELDS, ($tambah_pemesanan_JSON));
                curl_setopt($ch_pemesanan, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_pemesanan, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($tambah_pemesanan_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                $response_pemesanan = curl_exec($ch_pemesanan);

                if ($response_pemesanan) {
                    $http_status_code_pemesanan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                    if ($http_status_code_pemesanan === 201) {
                        $pengajuan_url = $this->api_url . '/pengadaan/pengajuan/' . $idpengajuan;
                        $putDataPengajuan = [
                            'tanggal_pengajuan' => $tglpengajuan,
                            'nomor_pengajuan' => $nopengajuan,
                            'id_supplier' => $supplier,
                            'id_pegawai' => $pegawaipengajuan,
                            'diskon_persen' => $diskonpersen,
                            'diskon_jumlah' => $diskonjumlah,
                            'pajak_persen' => $pajakpersen,
                            'pajak_jumlah' => $pajakjumlah,
                            'materai' => $materai,
                            'status_pesanan' => $statuspesanan,
                            'catatan' => $catatanpengajuan,
                        ];

                        $update_pengajuan_JSON = json_encode($putDataPengajuan);
                        $ch_pengajuan = curl_init($pengajuan_url);
                        curl_setopt($ch_pengajuan, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch_pengajuan, CURLOPT_POSTFIELDS, $update_pengajuan_JSON);
                        curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $token,
                        ]);

                        $response_pengajuan = curl_exec($ch_pengajuan);

                        if ($response_pengajuan) {
                            $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                            if ($http_status_code_pengajuan === 200) {

                                return redirect()->to(base_url('pemesananmedis'));
                            } else {
                                return "Error Update Pengajuan: " . $response_pengajuan;
                            }
                            curl_close($ch_pemesanan);
                            curl_close($ch_pengajuan);
                        } else {
                            return "Error sending request to the obat API.";
                        }
                    } else {
                        return "Error Insert Pemesanan: " . $response_pemesanan;
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
    public function editPemesananMedis($pemesananId)
    {
        if (session()->has('jwt_token')) {
            // Ambil data medis berdasarkan ID barang medis
            $token = session()->get('jwt_token');
            $barang_medis_url = $this->api_url . '/inventaris/medis';
            $pegawai_url = $this->api_url . '/pegawai';
            $pemesanan_url = $this->api_url . '/pengadaan/pemesanan/' . $pemesananId;

            $ch_pegawai = curl_init($pegawai_url);
            curl_setopt($ch_pegawai, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pegawai, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);

            $response_pegawai = curl_exec($ch_pegawai);

            $ch_barang_medis = curl_init($barang_medis_url);
            curl_setopt($ch_barang_medis, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_barang_medis, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
            $response_barang_medis = curl_exec($ch_barang_medis);
            $ch_pemesanan = curl_init($pemesanan_url);
            curl_setopt($ch_pemesanan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pemesanan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
            $response_pemesanan = curl_exec($ch_pemesanan);
            $pemesanan_data = json_decode($response_pemesanan, true);
            $idpengajuan = $pemesanan_data['data']['id_pengajuan'];
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan/' . $idpengajuan;
            $pesanan_url = $this->api_url . '/pengadaan/pesanan/pengajuan/' . $idpengajuan;
            $ch_pengajuan = curl_init($pengajuan_url);
            curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
            $response_pengajuan = curl_exec($ch_pengajuan);

            $ch_pesanan = curl_init($pesanan_url);
            curl_setopt($ch_pesanan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pesanan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
            $response_pesanan = curl_exec($ch_pesanan);

            if ($response_pemesanan && $response_pesanan && $response_pengajuan && $response_barang_medis && $response_pegawai) {
                $http_status_code_pemesanan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                $http_status_code_pesanan = curl_getinfo($ch_pesanan, CURLINFO_HTTP_CODE);
                $http_status_code_barang_medis = curl_getinfo($ch_barang_medis, CURLINFO_HTTP_CODE);
                $http_status_code_pegawai = curl_getinfo($ch_pegawai, CURLINFO_HTTP_CODE);

                $barang_medis_data = json_decode($response_barang_medis, true);
                $pengajuan_data = json_decode($response_pengajuan, true);
                $pesanan_data = json_decode($response_pesanan, true);
                $pegawai_data = json_decode($response_pegawai, true);
                // $barang_medis_data = json_decode($response_barang_medis, true);
                if ($http_status_code_pemesanan === 200 && $http_status_code_pesanan === 200 && $http_status_code_pengajuan === 200) {
                    return view('/admin/pengadaan/medis/pemesanan/edit_pemesanan', [
                        'pemesanan_data' => $pemesanan_data['data'],
                        'pesanan_data' => $pesanan_data['data'],
                        'pengajuan_data' => $pengajuan_data['data'],
                        'barang_medis_data' => $barang_medis_data['data'],
                        'pegawai_data' => $pegawai_data['data'],
                        'pemesananId' => $pemesananId,
                        'title' => 'Edit pemesanan Medis'
                    ]);
                } else {
                    // Error: Gagal mengambil data medis
                    return "Error fetching data. HTTP Status Code pemesanan: $http_status_code_pemesanan, HTTP Status Code Pesanan: $http_status_code_pesanan";
                }
            } else {
                // Error: Gagal mengambil respons dari API untuk data medis
                return "Error fetching data.";
            }
            // Tutup sesi cURL untuk data medis dan obat
            curl_close($ch_pemesanan);
            curl_close($ch_pesanan);
        } else {
            // User belum login
            return "User not logged in. Please log in first.";
        }
    }
    public function submitEditPemesananMedis($pemesananId)
    {
        if ($this->request->getPost()) {
            $tglpemesanan = $this->request->getPost('tglpemesanan');
            $nopemesanan = $this->request->getPost('nopemesanan');
            $idpengajuan = $this->request->getPost('idpengajuan');
            $pegawaipemesanan = $this->request->getPost('pegawaipemesanan');

            $pemesanan_url = $this->api_url . '/pengadaan/pemesanan/' . $pemesananId;

            $postDatapemesanan = [
                'tanggal_pesan' => $tglpemesanan,
                'no_pemesanan' => $nopemesanan,
                'id_pengajuan' => $idpengajuan,
                'id_pegawai' => $pegawaipemesanan,
            ];
            $edit_pemesanan_JSON = json_encode($postDatapemesanan);

            if (session()->has('jwt_token')) {
                $token = session()->get('jwt_token');
                $ch_pemesanan = curl_init($pemesanan_url);

                curl_setopt($ch_pemesanan, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch_pemesanan, CURLOPT_POSTFIELDS, $edit_pemesanan_JSON);
                curl_setopt($ch_pemesanan, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_pemesanan, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($edit_pemesanan_JSON),
                    'Authorization: Bearer ' . $token,
                ]);

                $response_pemesanan = curl_exec($ch_pemesanan);

                if ($response_pemesanan) {
                    $http_status_code_pemesanan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                    if ($http_status_code_pemesanan === 200) {

                        return redirect()->to(base_url('pemesananmedis'));

                        curl_close($ch_pemesanan);
                    } else {
                        // Error response from the API
                        curl_close($ch_pemesanan); // Tutup session cURL untuk medis_url di sini
                        return "Error Update pemesanan: " . $response_pemesanan;
                    }
                } else {
                    // Error sending request to the API
                    return "Error sending request to the API.";
                }
            } else {
                // Email or role is empty
                return "User not logged in. Please log in first.";
            }
        } else {
            return "Data is required.";
        }
    }
    public function hapusPemesananMedis($pemesananId)
    {
        // Check if the user is logged in
        if (session()->has('jwt_token')) {
            $token = session()->get('jwt_token');
            $pemesanan_url = $this->api_url . '/pengadaan/pemesanan/' . $pemesananId;

            $ch_pemesanan = curl_init($pemesanan_url);

            curl_setopt($ch_pemesanan, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch_pemesanan, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
            ]);
            $response_pemesanan = curl_exec($ch_pemesanan);
            $pemesanan_data = json_decode($response_pemesanan, true);
            $pengajuanId = $pemesanan_data['data']['id_pengajuan'];
            $pengajuan_url = $this->api_url . '/pengadaan/pengajuan/' . $pengajuanId;
            if ($response_pemesanan) {
                $http_status_code_pemesanan = curl_getinfo($ch_pemesanan, CURLINFO_HTTP_CODE);
                if ($http_status_code_pemesanan === 200) {
                    $ch_pengajuan = curl_init($pengajuan_url);

                    curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                        'Authorization: Bearer ' . $token,
                    ]);
                    $response_pengajuan = curl_exec($ch_pengajuan);
                    $pengajuan_data = json_decode($response_pengajuan, true);

                    $putDataPengajuan = [
                        'tanggal_pengajuan' => $pengajuan_data['data']['tanggal_pengajuan'],
                        'nomor_pengajuan' => $pengajuan_data['data']['nomor_pengajuan'],
                        'id_supplier' => $pengajuan_data['data']['id_supplier'],
                        'id_pegawai' => $pengajuan_data['data']['id_pegawai'],
                        'diskon_persen' => $pengajuan_data['data']['diskon_persen'],
                        'diskon_jumlah' => $pengajuan_data['data']['diskon_jumlah'],
                        'pajak_persen' => $pengajuan_data['data']['pajak_persen'],
                        'pajak_jumlah' => $pengajuan_data['data']['pajak_jumlah'],
                        'materai' => $pengajuan_data['data']['materai'],
                        'status_pesanan' => '2',
                        'catatan' => $pengajuan_data['data']['catatan'],
                    ];
                    $update_pengajuan_JSON = json_encode($putDataPengajuan);
                    $ch_pengajuan = curl_init($pengajuan_url);
                    curl_setopt($ch_pengajuan, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch_pengajuan, CURLOPT_POSTFIELDS, $update_pengajuan_JSON);
                    curl_setopt($ch_pengajuan, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch_pengajuan, CURLOPT_HTTPHEADER, [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $token,
                    ]);

                    $response_pengajuan = curl_exec($ch_pengajuan);

                    // Check if the API request to obat_url was successful
                    if ($response_pengajuan) {
                        $http_status_code_pengajuan = curl_getinfo($ch_pengajuan, CURLINFO_HTTP_CODE);
                        if ($http_status_code_pengajuan === 200) {
                            // Data berhasil ditambahkan ke obat_url
                            $ch_delete_pemesanan = curl_init($pemesanan_url);
                            curl_setopt($ch_delete_pemesanan, CURLOPT_CUSTOMREQUEST, "DELETE");
                            curl_setopt($ch_delete_pemesanan, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch_delete_pemesanan, CURLOPT_HTTPHEADER, [
                                'Authorization: Bearer ' . $token,
                            ]);
                            // Execute the cURL request to obat_url
                            $response_pemesanan = curl_exec($ch_delete_pemesanan);
                            $http_status_code_pemesanan = curl_getinfo($ch_delete_pemesanan, CURLINFO_HTTP_CODE);
                            if ($http_status_code_pemesanan === 204) {
                                return redirect()->to(base_url('pemesananmedis'));
                            } else {
                                // Error response from the API
                                return "Error deleting pemesanan: " . $response_pemesanan;
                            }

                        } else {
                            // Error response dari obat_url
                            return "Error Update Pengajuan: " . $response_pengajuan;
                        }
                        curl_close($ch_pengajuan);
                        curl_close($ch_pemesanan);
                    } else {
                        return "Error sending request to the obat API.";
                    }
                } else {
                    return "Error mendapatkan data pengajuan: " . $response_pemesanan;
                }
            } else {
                return "Error mendapatkan data pengajuan.";
            }
            //delete pemesanan

        } else {
            // User not logged in
            return "User not logged in. Please log in first.";
        }
    }
}
