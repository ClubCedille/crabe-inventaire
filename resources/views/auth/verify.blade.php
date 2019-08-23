@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verifyEmailAddress') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                        {{ __('auth.verificationLinkSent') }}
                                                             </div>
@endif

{{ __('auth.pleaseCheckEmail') }}
                    {{ __('auth.ifNotReceiveEmail') }}, <a href="{{ route('verification.resend') }}">{{ __('auth.requestAnother') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
