
@extends('layouts.app')

@section('content')
<div>
        <h1 class="title">Voir un produit</h1>
        <br/>
        <label for="Id">Id : {{$product->id}}</label>
        <br/>        
        <label name="code_label">Code : {{$product->code}}</label>
        <br/>
        <label name="name_label">Nom : {{$product->name}}</label>
        <br/>
        <label name="description_label">Description : {{$product->description}}</label>
        <br/>
        <label name="price_label">Prix : {{$product->price}}</label>
        <br/>
        <label name="category_id_label">Id de la Catégorie : {{$product->category_id}}</label>
        <br/>
        <form>
            <button type="submit" formaction="/product/{{$product->id}}/edit" formmethod="GET">Modifier</button>
        </form>
            
        </form>
        
    </div>
@endsection
