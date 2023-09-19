<?php

namespace App\Http\Livewire;

use App\Models\Cabang;
use App\Models\Santri;
use App\Models\Program;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Registration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class Register extends Component
{
    use WithFileUploads;

    public $username;
    public $password;
    public $namaSantri;
    public $jenisKelamin;
    public $cabang;
    public $program;
    public $buktiTransfer;
    public $namaFile;


    public $cabangs;
    public $programs;
    public $photo;
    public $isButtonDisabled = true;
    public $isRegistered = false;
    public $showProgramIDN = false;

    public function mount()
    {
        $this->cabangs = Cabang::all();
        $this->programs = collect();
    }

    public function updatedCabang($value)
    {
        $this->programs = Program::where('cabang_id', $value)->get();
        
        // Memperbarui visibilitas field "Program IDN" berdasarkan apakah field "Cabang" terisi
        $this->showProgramIDN = filled($value);
    }
    
    public function updatedProgram($program)
    {
        $this->checkQuota();
    }

    public function updatedBuktiTransfer()
    {
        $this->namaFile = $this->buktiTransfer->getClientOriginalName();
    }
    
    public function checkQuota()
    {

        $selectedProgram = Program::find($this->program);
        $selectedCabang = Cabang::find($this->cabang);

        if ($selectedProgram && $selectedCabang) {
            $quotaAvailable = $selectedProgram->quota;

            if ($quotaAvailable <= 0) {
                $this->dispatchBrowserEvent('show-swal', [
                    'type' => 'error', 
                    'title' => 'Kuota Terpenuhi!', 
                    'text' => "Kuota untuk {$selectedProgram->name} di {$selectedCabang->name} sudah penuh, silahkan pilih program yang lain"
                ]);
                $this->isButtonDisabled = true;
            } else {
                $this->isButtonDisabled = false;
            }
        }
    }

    public function register()
    {
        $this->validate([
            'username' => 'required|email',
            'password' => 'required',
            'namaSantri' => 'required',
            'jenisKelamin' => 'required',
            'cabang' => 'required',
            'program' => 'required',
            'buktiTransfer' => 'required|image|max:1024', // validasi ukuran maks 1MB dan format image
        ]);

        if ($this->isButtonDisabled) {
            return;
        }

        Santri::create([
            'username' => $this->username,
            'password' => bcrypt($this->password),
            'nama_santri' => $this->namaSantri,
            'jenis_kelamin' => $this->jenisKelamin,
            'cabang_id' => $this->cabang,
            'program_id' => $this->program,
            'bukti_transfer' => $this->buktiTransfer->store('transfers'), // menyimpan path file ke database
            
        ]);

        // Mengurangi kuota setelah pendaftaran berhasil
        $selectedProgram = Program::find($this->program);
        if ($selectedProgram) {
            $selectedProgram->decrement('quota');
        }

        $credentials = ['username' => $this->username, 'password' => $this->password];
        Auth::attempt($credentials);

        $this->resetForm();
        $this->isRegistered = true;
        
        // Tampilkan notifikasi sukses
        session()->flash('registrationSuccess', true);
    }
    public function resetForm()
    {
        $this->username = '';
        $this->password = '';
        $this->namaSantri = '';
        $this->jenisKelamin = '';
        $this->cabang = '';
        $this->program = '';
        $this->buktiTransfer = null;
        $this->photo = null;
    }
    
    protected $rules = [
        'username' => 'required|string|email|unique:santris',
        'password' => 'required|string|min:8',
        'namaSantri' => 'required|string|max:255|min:4',
        'jenisKelamin' => 'required',
        'cabang' => 'required',
        'program' => 'required',
        'buktiTransfer' => 'required|image|max:1024',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function getIsFormValidProperty()
    {
        return 
            filled($this->username) &&
            filled($this->password) &&
            filled($this->namaSantri) &&
            filled($this->jenisKelamin) &&
            filled($this->cabang) &&
            filled($this->program) &&
            filled($this->buktiTransfer) &&
            $this->hasNoValidationErrors()&&
            !$this->isButtonDisabled;
    }

    public function hasNoValidationErrors()
    {
        try {
            $this->validate();
            return true;
        } catch (\Illuminate\Validation\ValidationException $e) {
            return false;
        }
    }

    protected $listeners = [
        'checkEmail' => 'checkEmailAvailability'
    ];
    public function checkEmailAvailability()
    {
        $santriExists = Santri::where('username', $this->username)->exists();
        if ($santriExists) {
            $this->dispatchBrowserEvent('emailTaken', ['message' => 'Email sudah terdaftar, silahkan login disini']);
        }
    }

    public function render()
    {
        return view('livewire.register'); 
    }

}

