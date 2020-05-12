@component('mail::message')
# Reçu de votre achat chez {{ config('app.name') }}

Bonjour, {{$name}}, ceci est le reçu officiel après avoir fait un achat chez {{ config('app.name') }},
vous pouvez aussi télécharger votre reçu à partir de votre compte dans la section
MES REÇUS.

Date de l'achat : {{$date}}

@component('mail::table')
| Nom du produit       | quantite         | prix par unite  |
| ------------- |:-------------:| --------:|
@foreach($products as $product)
| {{$product["name"]}}      | {{$product["count"]}}      |{{$product["price"]}}$      |
@endforeach
| | total|`{{$total}}$`     |
@endcomponent

Merci !,<br>
{{ config('app.name') }}
@endcomponent
