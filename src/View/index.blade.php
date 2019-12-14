@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('TwoFactor.form_title') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('2fa-form') }}">
                            @csrf

                            @if(!empty($qr))
                                <div class="row">
                                    <div class="col-md-4">
                                        <img class="img-fluid" src="{{ $qr }}">
                                    </div>
                                    <div class="col-md-8">
                                        {{ __('TwoFactor.form_info') }}
                                    </div>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="2fa" class="col-md-4 col-form-label text-md-right">{{ __('TwoFactor.form_label') }}</label>

                                <div class="col-md-6">
                                    <input id="2fa" type="text" class="form-control @error('2fa') is-invalid @enderror" name="2fa" required autofocus>

                                    @error('2fa')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('TwoFactor.form_submit') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
