@extends('layouts.app')
@section('styles')
  <link href="{{ asset('public/css/register_blade.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('ユーザー新規登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-6">
                                <input  id="user" type="text" required class="form-control @error('user') is-invalid @enderror" name="name" placeholder="ユーザー名">

                                @error('user')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-6">
                                <input  id="email" type="text" required="required" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="メールアドレス">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-6">
                                <input id="password" type="password" required="required" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="パスワード">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="confPassword" class="col-md-4 col-form-label text-md-end"></label>
                            <div class="col-md-6">
                                <input id="confPassword" type="password" required="required" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" placeholder="パスワード（確認用）">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary touroku">新規登録</button>
                                <button type="submit" class="btn btn-primary modoru" onclick="location.href='{{ route('register') }}'">戻る</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
