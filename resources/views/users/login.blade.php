@extends('layouts.mainAuth')

@section('title', 'Login')

@push('style')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Login</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<div class="content d-flex justify-content-center align-items-center">
    <div class="container d-flex justify-content-center align-items-center">
        @livewire('login')
    </div><!-- /.container-fluid -->
</div>

@endsection