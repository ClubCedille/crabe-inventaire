@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>

                <div class="card-body">
                    Nom: {{$user->firstName}} {{$user->lastName}}
                </div>
                <div class="card-body">
                    Email: {{$user->email}}
                </div>
                <div class="card-body">
                    Code universel: {{$user->email}}
                </div>
                <div class="card-body">admin:
                    @if ($user->isAdmin == true)
                        <p style="color:green">Oui</p>
                    @endif
                    @if ($user->isAdmin == false)
                        <p style="color:red">non</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
