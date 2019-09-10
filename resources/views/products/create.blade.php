
@extends('layouts.app')

@section('content')
<div>
        <h1 class="title">Créer un produit</h1>
        <br/>
        <form method="POST" action="product">
            {{csrf_field()}}
            
            <label for="code">Code</label>
            <input name="code" />
            <br/>
            <label for="name">Nom</label>
            <input name="name" />
            <br/>
            <label for="description">Description</label>
            <input name="description" />
            <br/>
            <label for="price">Prix</label>
            <input name="price" />
            <br/>
            <label for="category_id">Id de la Catégorie</label>
            <input name="category_id" />
            <br/>
            <button type="submit">Créer</button>
        </form>
        
</div>
@endsection
