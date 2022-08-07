<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'tes' => ['satu', 'dua', 'tiga']
        ];
        return view('pages/home', $data);
    }

    public function about()
    {
        $data = [
            'title' => 'About'
        ];
        return view('pages/about', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contact',
            'alamat' => [
                [
                    'tipe' => 'Rumah',
                    'alamat' => 'Jl. Maninjau',
                    'kota' => 'Depok'
                ],
                [
                    'tipe' => 'Kampus',
                    'alamat' => 'Jl. Margonda',
                    'kota' => 'Depok'
                ],
                [
                    'tipe' => 'Kantor',
                    'alamat' => 'Jl. Jendral Sudirman',
                    'kota' => 'Jakarta Pusat'
                ]
            ]
        ];

        return view('pages/contact', $data);
    }
}
