@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">
<form method="POST" id="update-product-form" action="{{URL::to('/product')}}/{{$products->code}}">
    @csrf
    @method('PUT')

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" placeholder="name" name=name value="{{$products->name}}">
            </div>
        </div>

        <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="description" name=description value="{{$products->description}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="code" name=code value="{{$products->code}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="price" name=price value="{{$products->price}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="category_id" name=category_id value="{{$products->category_id}}">
                </div>
        </div>

        <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="quantity" name=quantity value="{{$products->quantity}}">
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