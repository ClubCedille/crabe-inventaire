@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">

        <product-component 
        url="{{URL::to('/product')}}"
        :data="{{json_encode($products)}}"
        :categories="{{json_encode($categories)}}"
       message="{{$message}}"
        
        >
        </product-component>

</section>
@endsection
