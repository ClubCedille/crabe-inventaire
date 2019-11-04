@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">

        <product-component 
        url="{{URL::to('/product')}}"
        :data="{{json_encode($products)}}"
        >
        </product-component>

</section>
@endsection
