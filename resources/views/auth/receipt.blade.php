<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Reçu de votre achat chez {{ config('app.name') }}</title>
  </head>
  <body>
    <h1>Reçu de votre achat chez {{ config('app.name') }}</h1>
    <p>
    Ceci est le reçu officiel après avoir fait un achat chez {{ config('app.name') }},
    vous pouvez aussi télécharger votre reçu à partir de votre compte dans la section
    mes reçus.
    <br>
    Date de l'achat : {{$transaction->created_at}}
    </p>
    <table class="table">
    <thead>
      <tr>
        <td class="text-left"><b>Nom du produit </b></td>
        <td class="text-left"><b>quantite</b></td>
        <td class="text-left"><b>prix par unite</b></td>     
      </tr>
      </thead>
      <tbody>
      @foreach($transaction->products as $product)
      <tr>
        <td>
        {{$product["name"]}}
        </td>
        <td>
        {{$product["count"]}} 
        </td>
        <td>
        {{$product["price"]}}$ 
        </td>
      </tr>
      @endforeach

      <tr>
      <td>
      </td>
      <td>
      Total
      </td>
      <td>
      {{$transaction["total"]}}$ 
      </td>
      </tr>
      </tbody>
    </table>

    {{ config('app.name') }}
  </body>
</html>