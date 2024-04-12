@extends('layouts.default')

@section('content')
    <div class="container">
        <div class="logo-wrap">
            <img src="{{ asset('img/logo_mark.png') }}" class="rounded mx-auto d-block" width="140px">

            <img src="{{ asset('img/logo_name.png') }}" class="rounded mx-auto d-block py-3" width="150px">
            <h3 class="text-center mb-4 fw-bold">マスター管理</h3>
        </div>

        <div class="alert alert-danger mb-3 max-w-500 mx-auto" role="alert">
            ユーザIDまたはパスワードに誤りがあります
        </div>

        <div class="card max-w-500 mx-auto px-5 py-3">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card-body">
                <div class="mb-3">
                    <label for="staff-no" class="form-label">
                        <i class="fas fa-user ms-1"></i>
                        ユーザID</label>
                    <input id="staff_no" type="text" class="form-control @error('staff_no') is-invalid @enderror" name="staff_no" value="{{ old('staff_no') }}" required>
                    @error('staff_no')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-key ms-1"></i>
                        パスワード</label>
                    <input id="password" type="password" class="form-control @error('staff_no') is-invalid @enderror" name="password" required>

                    @error('staff_no')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-75 py-2 mt-4 d-block mx-auto">ログイン</button>
            </div>
            </form>
        </div>
    </div>
@endsection
