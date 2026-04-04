<?php namespace App\Controllers;

use App\Models\PerusahaanModel;
use App\Models\LaporanModel;
use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;

class User extends BaseController
{
    protected $perusahaanModel;
    protected $laporanModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->perusahaanModel = new PerusahaanModel();
        $this->laporanModel = new LaporanModel();
    }
    
    // ======================
    // 1. DASHBOARD USER
    // ======================
    public function index()
    {
        $userId = user_id(); // ID user yang login

        $data = [
            'judul' => 'Dashboard User',
            'totalLaporan'    => $this->laporanModel->where('user_id', $userId)->countAllResults(),
            'approvedLaporan' => $this->laporanModel->where(['user_id' => $userId, 'status' => 'acc'])->countAllResults(),
            'rejectedLaporan' => $this->laporanModel->where(['user_id' => $userId, 'status' => 'tolak'])->countAllResults(),
            'daftarLaporan'   => $this->laporanModel->where('user_id', $userId)
                                                    ->orderBy('created_at', 'DESC')
                                                    ->findAll(),
        ];
        
        return view('user/index', $data);
    }

    // ======================
    // 2. FORM INPUT TAMBANG
    // ======================
    public function inputTambang()
    {
        $data = [
            'judul' => 'Form Input Data Tambang',
            'validation' => \Config\Services::validation(),
        ];

        return view('user/v_input', $data);
    }

    // ======================
    // 3. SIMPAN DATA TAMBANG
    // ======================
    public function saveInputTambang()
    {
        // Rules Validasi
        $rules = [
            'nama_blok' => 'required|max_length[255]',
            'luas_ha' => 'required|numeric|greater_than_equal_to[0]',
            'sd_tereka_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_tereka_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terunjuk_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'sd_terukur_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terkira_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terkira_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_volume' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'cd_terbukti_tonase' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_harian' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_bulanan' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'prod_tahunan' => 'permit_empty|numeric|greater_than_equal_to[0]',
            'umur_tambang' => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'validation' => $this->validator,
                'judul' => 'Form Input Data Tambang',
            ];
            return view('user/v_input', $data);
        }

        // Simpan Data
        $this->laporanModel->save([
            'user_id' => user_id(),
            'nama_blok' => $this->request->getPost('nama_blok'),
            'luas_ha' => $this->request->getPost('luas_ha'),
            'sd_tereka_volume' => $this->request->getPost('sd_tereka_volume'),
            'sd_tereka_tonase' => $this->request->getPost('sd_tereka_tonase'),
            'sd_terunjuk_volume' => $this->request->getPost('sd_terunjuk_volume'),
            'sd_terunjuk_tonase' => $this->request->getPost('sd_terunjuk_tonase'),
            'sd_terukur_volume' => $this->request->getPost('sd_terukur_volume'),
            'sd_terukur_tonase' => $this->request->getPost('sd_terukur_tonase'),
            'cd_terkira_volume' => $this->request->getPost('cd_terkira_volume'),
            'cd_terkira_tonase' => $this->request->getPost('cd_terkira_tonase'),
            'cd_terbukti_volume' => $this->request->getPost('cd_terbukti_volume'),
            'cd_terbukti_tonase' => $this->request->getPost('cd_terbukti_tonase'),
            'prod_harian' => $this->request->getPost('prod_harian'),
            'prod_bulanan' => $this->request->getPost('prod_bulanan'),
            'prod_tahunan' => $this->request->getPost('prod_tahunan'),
            'umur_tambang' => $this->request->getPost('umur_tambang'),
            'status' => 'pending',
            'catatan_penolakan' => null
        ]);

        return redirect()->to(base_url('user'))->with('success', 'Data tambang berhasil disimpan! Status saat ini: Pending.');
    }

    // ======================
    // 4. IDENTITAS PERUSAHAAN
    // ======================
    public function inputPerusahaan()
    {
        $userId = user_id();
        $perusahaan = $this->perusahaanModel->where('user_id', $userId)->first();
        
        $data = [
            'judul' => empty($perusahaan) ? 'Form Identitas Perusahaan' : 'Edit Identitas Perusahaan',
            'perusahaan' => $perusahaan,
            'validation' => \Config\Services::validation(),
        ];

        return view('user/input-perusahaan', $data);
    }

    public function saveInputPerusahaan()
    {
        $userId = user_id();
        $rules = [
            'nama_perusahaan'   => 'required|min_length[3]',
            'alamat_perusahaan' => 'required',
            'jenis_usaha'       => 'required',
            'tahun_berdiri'     => 'required|numeric',
            'email_perusahaan'  => 'required|valid_email',
            'no_telepon'        => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
             $perusahaanData = [
                'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
                'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
                'nama_direktur' => $this->request->getPost('nama_direktur'),
                'email_perusahaan' => $this->request->getPost('email_perusahaan'),
                'no_telepon' => $this->request->getPost('no_telepon'),
                'website' => $this->request->getPost('website'),
            ];

            return view('user/input-perusahaan', [
                'validation' => $this->validator,
                'judul' => 'Edit Identitas Perusahaan',
                'perusahaan' => $perusahaanData 
            ]);
        }

        $data = [
            'user_id'           => $userId,
            'nama_perusahaan'   => $this->request->getPost('nama_perusahaan'),
            'alamat_perusahaan' => $this->request->getPost('alamat_perusahaan'),
            'npwp'              => $this->request->getPost('npwp'),
            'jenis_usaha'       => $this->request->getPost('jenis_usaha'),
            'tahun_berdiri'     => $this->request->getPost('tahun_berdiri'),
            'nib'               => $this->request->getPost('nib'),
            'izin_usaha'        => $this->request->getPost('izin_usaha'),
            'masa_berlaku'      => $this->request->getPost('masa_berlaku'),
            'nama_direktur'     => $this->request->getPost('nama_direktur'),
            'email_perusahaan'  => $this->request->getPost('email_perusahaan'),
            'no_telepon'        => $this->request->getPost('no_telepon'),
            'website'           => $this->request->getPost('website')
        ];

        $existingPerusahaan = $this->perusahaanModel->where('user_id', $userId)->first();
        
        if ($existingPerusahaan) {
            $this->perusahaanModel->update($existingPerusahaan['id'], $data);
            $message = 'Data identitas perusahaan berhasil diperbarui!';
        } else {
            $this->perusahaanModel->insert($data);
            $message = 'Data identitas perusahaan berhasil disimpan!';
        }

        return redirect()->to(base_url('user/input-perusahaan'))->with('success', $message);
    }

    // ======================
    // 5. MANAJEMEN PROFILE USER (PASSWORD SUPPORT)
    // ======================
    public function profile(): string
    {
        $data['judul'] = 'Account Settings';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, users.username, users.email, auth_groups.name as role');
        $builder->join('auth_groups_users', 'users.id = auth_groups_users.user_id', 'left');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id', 'left');
        $builder->where('users.id', user_id());

        $query = $builder->get();
        $data['user'] = $query->getRow();

        return view('user/profile', $data);
    }

    public function editProfile(): string
    {
        $data['judul'] = 'Edit Account Profile';
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->where('id', user_id());
        $data['user'] = $builder->get()->getRow();

        return view('user/edit_profile', $data);
    }

    public function updateProfile()
    {
        $rules = [
            'username' => 'required|min_length[3]|alpha_numeric_space',
            'email'    => 'required|valid_email',
            'password' => 'permit_empty|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new UserModel();
        $user = $users->find(user_id());

        $user->username = $this->request->getPost('username');
        $user->email = $this->request->getPost('email');

        if ($this->request->getPost('password')) {
            $user->setPassword($this->request->getPost('password'));
        }

        $users->save($user);

        return redirect()->to('/user/profile')->with('success', 'Akun & Password berhasil diperbarui!');
    }
}