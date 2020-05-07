@extends('layouts.app')

@section('content')
<section class="hero is-large">
    <receipts 
        url="{{URL::to('/')}}"
        :data="{{json_encode($transactions)}}"
      >
        </receipts>

</section>  
@endsection
