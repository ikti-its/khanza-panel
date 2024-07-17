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

    $page = $this->request->getGet('page') ?? 1;
    $size = $this->request->getGet('size') ?? 5;

    if (session()->has('jwt_token')) {
        $token = session()->get('jwt_token');
        $kehadiran_url = $this->api_url . '/kehadiran/presensi?page=' . $page . '&size=' . $size;

        $ch_kehadiran = curl_init($kehadiran_url);
        curl_setopt($ch_kehadiran, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_kehadiran, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
        ]);

        $response_kehadiran = curl_exec($ch_kehadiran);

        if ($response_kehadiran) {
            $http_status_code_kehadiran = curl_getinfo($ch_kehadiran, CURLINFO_HTTP_CODE);

            if ($http_status_code_kehadiran === 200) {
                $kehadiran_data = json_decode($response_kehadiran, true);
                return view('/admin/dataKehadiran', [
                    'kehadiran_data' => $kehadiran_data['data']['presensi'],
                    'meta_data' => $kehadiran_data['data'],
                    'title' => $title
                ]);
            } else {
                return $this->renderErrorView($http_status_code_kehadiran);
            }
        } else {
            return $this->renderErrorView(500);
        }

        curl_close($ch_kehadiran);
    } else {
        return $this->renderErrorView(401);
    }
}

    

    
}
