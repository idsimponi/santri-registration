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
    <h1>Selamat datang, {{ $santriName }}</h1>
</div>
