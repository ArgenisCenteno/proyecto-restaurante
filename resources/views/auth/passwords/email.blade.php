@extends('layouts.app')

@section('content')
<section class="vh-100 p-0 bg-light"
    style="background-image: url('{{ asset('/iconos/fondo.jpeg') }}'); background-size: cover; background-position: center;">
    <div class="container-fluid">
        <div class="row min-vh-100 d-flex justify-content-center align-items-center">
            <div class="col-sm-12 text-black">

                <div
                    class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 justify-content-center">

                    <!-- Login Card with Border -->
                    <div class="card bg-white"
                        style="width: 23rem; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <!-- Logo Image -->
                            <div class="text-center mb-4">
                                <img src="{{ asset('/iconos/logo.jpg') }}" alt="Logo"
                                    style="max-width: 150px; border-radius: 8px;">
                            </div>

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="email"
                                        class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Enviar email de recuperación') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>
@endsection