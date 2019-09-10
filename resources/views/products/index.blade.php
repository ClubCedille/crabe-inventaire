
@extends('layouts.app')

@section('content')
<div align="center">
        <h1 class="title">Liste des produits</h1>
        <br/>
        <ul class="rows">    
        @foreach ($products as $product)
        <li>
            {{-- <div class="row"> --}}
            <label for="name">
                <a href="/product/{{$product->id}}">{{$product->name}}
                </a>
            </label>
            <form method="POST" action="/product/{{$product->id}}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                <button type="submit">Supprimer</button>
            </form>
            <form method="GET" action="product/{{$product->id}}/edit">
                {{ csrf_field() }}
                <button type="submit">Modifier</button>
            </form>
        {{-- </div> --}}
        </li>
        @endforeach
    </ul>
    <br/>
<form METHOD="GET" action="/newProduct">
<button type="submit">
        Créer un Produit
    </button>
</form>
            
        
    </div>
@endsection
