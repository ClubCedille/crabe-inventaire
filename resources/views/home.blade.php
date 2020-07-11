@extends('layouts.app')

@section('content')
<section class="hero is-large">
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
            </div>
    </div>
    @if (Auth::user()->isAdmin != 1)
    <items 
        url="{{URL::to('/')}}"
        :data="{{json_encode($products)}}"
        :cart="{{json_encode($cart)}}">
        </items>
        @endif
</section>  
@endsection
