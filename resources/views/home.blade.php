@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Well done!</h4>
                        <p>{{ session('message')}}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                 @endif
                 @if (session('error'))
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                     <h4 class="alert-heading">Oups!</h4>
                     <p>{{ session('error')}}</p>
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                @endif
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
                        Nom:
                        {{$user->firstName}} {{$user->lastName}}
                    </div>
                    <div class="card-body">
                        Email:
                        {{$user->email}}
                    </div>
                    <div class="card-body">
                        Code universel:
                        {{$user->email}}
                    </div>
                    <div class="card-body">admin:
                        @if ($user->isAdmin == true)
                            <p style="color:green">Oui</p>
                        @else
                            <p style="color:red">non</p>
                        @endif
                    </div>
                    <div class="card-body">
                        Abonnement actif:
                        @if ($user->isMembershipActive() == true)
                            <p style="color:green">Oui</p>
                        @else
                            <p style="color:red">non</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
