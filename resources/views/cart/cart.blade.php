@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">

        <cart 
        url="{{URL::to('/cart')}}"
        :data="{{json_encode($products)}}"
        :cart="{{json_encode($cart)}}"
        icon="{{asset('images/paypal.svg')}}"
        transactionurl="{{URL::to('/transaction')}}"
        >
       
        </cart>

</section>
@endsection
