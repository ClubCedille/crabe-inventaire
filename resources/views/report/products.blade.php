<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rapport de l'inventaire {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body>
    <h1>Rapport de l'inventaire {{ config('app.name') }}</h1>
    <p>
    Rapport de l'invetaire actuelle
    <br>
    Date : {{$currentDate}}
    </p>
    <table class="table">
    <thead>
      <tr>
        <td class="text-left"><b>Nom du produit </b></td>
        <td class="text-left"><b>code</b></td>
        <td class="text-left"><b>quantite en inventaire</b></td>
        <td class="text-left"><b>prix par unite</b></td>     
      </tr>
      </thead>
      <tbody>
      @foreach($products as $product)
      <tr>
        <td>
        {{$product["name"]}}
        </td>
        <td>
        {{$product["code"]}} 
        </td>
        <td>
        {{$product["price"]}}$ 
        </td>
        <td>
        {{$product["price"]}}$ 
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>

    {{ config('app.name') }}
  </body>
</html>