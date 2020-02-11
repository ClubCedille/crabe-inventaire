@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">

    <category-edit-component
    url="{{URL::to('/category')}}"
    :data="{{json_encode($category)}}"
    message="{{$message}}">
    </category-edit-component>

</section>
@endsection
