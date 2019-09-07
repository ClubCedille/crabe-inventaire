@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">

        <category-component 
        url="{{URL::to('/category')}}"
        :data="{{json_encode($categories)}}"
        message="{{$message}}">
        </category-component>

</section>
@endsection
