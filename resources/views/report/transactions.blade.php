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
        <td class="text-left"><b>First name</b></td>
        <td class="text-left"><b>Last name</b></td>
        <td class="text-left"><b>status</b></td>
        <td class="text-left"><b>net_amount</b></td>
        <td class="text-left"><b>paypal_fee</b></td>
        <td class="text-left"><b>payer_id</b></td>     
        <td class="text-left"><b>total</b></td>     
      </tr>
      </thead>
      <tbody>
      @foreach($transactions as $transaction)
      <tr>
        <td>
        {{$transaction["user"]->firstName}}
        </td>
        <td>
        {{$transaction["user"]->lastName}}
        </td>
        <td>
        {{$transaction["status"]}}
        </td>
        <td>
        {{$transaction["net_amount"]}}$ 
        </td>
        <td>
        {{$transaction["paypal_fee"]}}$ 
        </td>
        <td>
        {{$transaction["payer_id"]}} 
        </td>
        <td>
        {{$transaction["total"]}}$ 
        </td>
      </tr>
      @endforeach
      </tbody>
    </table>

    {{ config('app.name') }}
  </body>
</html>