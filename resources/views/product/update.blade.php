@extends('layouts.app')

@section('content')

    <product-edit-component
    url="{{URL::to('/product')}}"
    :data="{{json_encode($product)}}"
    :categories="{{json_encode($categories)}}"
    message="{{$message}}">
    </product-edit-component>


@endsection
