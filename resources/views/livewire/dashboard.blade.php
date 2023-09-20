<div>
    @if (session()->has('message'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Anda Berhasil Login',
            showConfirmButton: false,
            timer: 2000
        })
    </script>
    @endif
    <h1>Selamat datang, {{ $dataPribadi->nama_santri }}</h1> <br>
    Upload Bukti Transfer <br>
    <img src="{{ asset('storage/'.$dataPribadi->bukti_transfer) }}" width="600" height="auto">
</div>
