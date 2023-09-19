<div>
    {{-- Alert  --}}
        <script>
            window.addEventListener('emailTaken', event => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: event.detail.message,
                    showConfirmButton: false,
                    footer: '<a href="{{ route('login') }}">Login Disini</a>',
                })
            });
        </script>
        <script>
            window.addEventListener('show-swal', event => {
                Swal.fire({
                    icon: event.detail.type,
                    title: event.detail.title,
                    text: event.detail.text,
                })
            });
        </script>
        @if (session()->has('registrationSuccess'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Selamat! Pendaftaran Berhasil',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
        <!-- Alert for successful registration -->
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <!-- Alert for error message -->
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    {{-- endAlert --}}
    <div class="card card-primary my-50">
        <!-- form start -->
        @if (!$isRegistered)
            <form wire:submit.prevent="register">
                <div class="card-body">
                    <div class="form-group">
                        <label for="username" class="form-label form-control-md ">Username (Email)</label>
                        <input wire:model="username" type="email" wire:keydown.debounce.500ms="checkEmailAvailability"
                            class="form-control form-control-md @error('username') is-invalid @enderror" id="username">
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label ">Password</label>
                        <input wire:model="password" type="password"
                            class="form-control form-control-md @error('password') is-invalid @enderror" id="password">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="namaSantri" class="form-label">Nama Santri</label>
                        <input wire:model="namaSantri" type="text"
                            class="form-control form-control-md @error('namaSantri') is-invalid @enderror"
                            id="namaSantri">
                        @error('namaSantri')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label @error('jenisKelamin') is-invalid @enderror">Jenis Kelamin</label>
                        <div>
                            <div class="form-check">
                                <input wire:model="jenisKelamin" class="form-check-input" type="radio"
                                    name="jenisKelamin" id="lakiLaki" value="Laki-laki">
                                <label class="form-check-label" for="lakiLaki">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input wire:model="jenisKelamin" class="form-check-input" type="radio"
                                    name="jenisKelamin" id="perempuan" value="Perempuan">
                                <label class="form-check-label" for="perempuan">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        @error('jenisKelamin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cabang" class="form-label @error('cabang') is-invalid @enderror">Cabang
                            IDN</label>
                        <select wire:model="cabang" class="form-control form-control-md" id="cabang" required>
                            <option value="">Pilih Cabang</option>
                            @foreach ($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->name }}</option>
                            @endforeach
                        </select>
                        @error('cabang')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    @if ($showProgramIDN)
                        <div class="form-group">
                            <label for="program" class="form-label @error('program') is-invalid @enderror">Program
                                IDN</label>
                            <select wire:model="program" class="form-control form-control-md" id="program" required>
                                <option value="">Pilih Program</option>
                                @foreach ($programs as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </select>
                            @error('program')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    @endif


                    <div class="form-group">
                        <label for="buktiTransfer"
                            class="form-label @error('buktiTransfer') is-invalid @enderror">BuktiTransfer</label>

                        <div class="custom-file">
                            <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <input wire:model="buktiTransfer" type="file" class="custom-file-input"
                                    id="exampleInputFile">
                                <div x-show="isUploading" class="progress mt-2 rounded">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" :style="`width: ${progress}%`;" aria-valuenow="40"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <label class="custom-file-label" for="exampleInputFile"> {{ $namaFile ?? 'Pilih File' }}</label>
                        </div>
                        @error('buktiTransfer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <label class="form-label">Preview Bukti Transfer</label>
                    <!-- Preview Bukti Transfer -->
                    @if ($buktiTransfer)
                        <div class="mb-3">
                            @if (str_starts_with($buktiTransfer->getMimeType(), 'image'))
                                <img src="{{ $buktiTransfer->temporaryUrl() }}" class="img-fluid" width="200"
                                    height="300">
                            @else
                                <p>File yang diunggah bukan gambar.</p>
                            @endif
                        </div>
                    @endif
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"
                        {{ $this->isFormValid ? '' : 'disabled' }}>Daftar</button>
                </div>
            </form>
        @endif
        <!---/ End Form ---->
    </div>

    @if ($isRegistered)
        <div class="alert alert-success">
            Pendaftaran berhasil! Silakan <a href="{{ route('dashboard') }}" class="alert-link">masuk di sini</a>.
        </div>
        <a href="{{ route('logoutAndRedirectToLogin') }}" class="btn btn-primary">Ke Halaman Login</a>
    @endif

</div>
