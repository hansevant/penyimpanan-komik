<?php

namespace App\Controllers;

use App\Models\KomikModel;
use CodeIgniter\I18n\Time;

$myTime = new Time('now');

class Komik extends BaseController
{
    protected $helper = ['date'];
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    public function index()
    {
        $data = [
            'title' => 'Daftar Komik',
            'komik' => $this->komikModel->getKomik()
        ];

        // $komikModel = new \App\Models\KomikModel();
        // dd($komik);

        return view('komik/index', $data);
    }
    public function detail($slug)
    {
        $komik = $this->komikModel->getKomik($slug);
        if (empty($komik)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("komik $slug tidak ada");
        }
        $judul = $komik['judul'];
        $time = Time::parse($komik['created_at'], 'Asia/Jakarta');
        $time = $time->humanize();
        $data = [
            'title' => "Detail Komik $judul",
            'komik' => $komik,
            'time' => $time
        ];

        return view('/komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Komik',
            'validation' => \Config\Services::validation()
        ];

        return view('/komik/create', $data);
    }

    public function store()
    {
        // validasi
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules' => 'uploaded[sampul]|is_image[sampul]|max_size[sampul,1024]',
                'errors' => [
                    'uploaded' => 'Silahkan Pilih Gambar',
                    'max_size' => 'Ukuran gambar oversize',
                    'is_image' => 'ini bukan gambar!'
                ]
            ]
        ])) {
            // $validation = \Config\Services::validation();
            // return redirect()->to('komik/create')->withInput()->with('validation', $validation);
            return redirect()->to('komik/create')->withInput();
        }

        // ambil gambar
        $sampul = $this->request->getFile('sampul');
        // pindahin filenya
        $sampul->move('img');
        // ambil nama file
        $namaSampul = $sampul->getName();

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesantambah', 'Komik baru berhasil ditambahkan!');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        // cari gambar dari id
        $komik = $this->komikModel->find($id);

        // hapus gambar
        unlink('img/' . $komik['sampul']);

        $this->komikModel->delete($id);
        session()->setFlashdata('pesanhapus', 'Komik berhasil dihapus!');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Komik',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('/komik/edit', $data);
    }

    public function update($id)
    {
        // cek judul
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $ruleJudul = 'required';
        } else {
            $ruleJudul = 'required|is_unique[komik.judul]';
        }

        // validasi
        if (!$this->validate([
            'judul' => [
                'rules' => $ruleJudul,
                'errors' => [
                    'required' => '{field} komik harus diisi',
                    'is_unique' => '{field} komik sudah ada'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus diisi'
                ]
            ],
            'sampul' => [
                'rules' => 'uploaded[sampul]|is_image[sampul]|max_size[sampul,1024]',
                'errors' => [
                    'uploaded' => 'Silahkan Pilih Gambar',
                    'max_size' => 'Ukuran gambar oversize',
                    'is_image' => 'ini bukan gambar!'
                ]
            ]
        ])) {
            return redirect()->to('komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        $sampulLama = $this->request->getVar('sampulLama');

        // cek gambar, apakah tetap gambar lama
        if ($fileSampul->getError() == 4) {
            $namaSampul = $sampulLama;
        } else {
            $namaSampul = $fileSampul->getName();
            $fileSampul->move('img', $namaSampul);
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);

        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesantambah', 'Komik baru berhasil diubah!');

        return redirect()->to('/komik');
    }
}
