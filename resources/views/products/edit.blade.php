
@extends('layouts.app')

@section('content')
<div align="center" class="container">
        <h1 class="title">Modifier un produit</h1>
        <br/>
        <div align="left">
        <form method="POST" action="/product/{{$product->id}}">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            
            <label for="Id">Id : {{$product->id}}</label>
            <br/>
            <label for="code">Code</label>
            <input name="code" value="{{$product->code}}"/>
            <br/>
            <label for="name">Nom</label>
            <input name="name" value="{{$product->name}}"/>
            <br/>
            <label for="description">Description</label>
            <input name="description" value="{{$product->description}}"/>
            <br/>
            <label for="price">Prix</label>
            <input name="price" value="{{$product->price}}"/>
            <br/>
            <label for="category_id">Id de la Catégorie</label>
            <input name="category_id" value="{{$product->category_id}}"/>
            <br/>
            <button type="submit">Soumettre</button>
        </form>
        
    </div>
@endsection
