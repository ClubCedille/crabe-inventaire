@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">
<form method="POST" id="update-product-form" action="{{URL::to('/product')}}/{{$product->id}}">
    @csrf
    @method('PUT')

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" placeholder="name" name=name value="{{$product->name}}">
            </div>
        </div>

        <div class="field">
                <label class="label">Description</label>
                <div class="control">
                  <input class="input" type="text" placeholder="description" name=description value="{{$product->description}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Code</label>
                <div class="control">
                  <input class="input" type="text" placeholder="code" name=code value="{{$product->code}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Price</label>
                <div class="control">
                  <input class="input" type="text" placeholder="price" name=price value="{{$product->price}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Category</label>
                <div class="control">
                  <input class="input" type="text" placeholder="category_id" name=category_id value="{{$product->category_id}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Quantity</label>
                <div class="control">
                  <input class="input" type="text" placeholder="quantity" name=quantity value="{{$product->quantity}}">
                </div>
        </div>
         
        <div class="field is-grouped">
                    <p class="control">
         <input class="button is-rounde is-info" type="submit" value="Update">
        </p>
        <p class="control">
            <a  class="button is-rounde" href="{{URL::to('/product')}}" >Cancel</a>
        </p>
        </div>
         
</form>

</section>
@endsection
