@extends('layouts.app')

@section('content')
<section class="bd-index-fullscreen hero is-fullheight">
<form method="POST" id="update-category-form" action="{{URL::to('/category')}}/{{$category->id}}">
    @csrf
    @method('PUT')
    <div class="field">
            <label class="label">Name</label>
            <div class="control">
              <input class="input" type="text" placeholder="name" name=name value="{{$category->name}}">
            </div>
          </div>

          <div class="field">
                <label class="label">Name</label>
                <div class="control">
                  <input class="input" type="text" placeholder="description" name=description value="{{$category->description}}">
                </div>
            </div>
         
            <div class="field is-grouped">
                    <p class="control">
         <input class="button is-rounde is-info" type="submit" value="Update">
        </p>
        <p class="control">
            <a  class="button is-rounde" href="{{URL::to('/category')}}" >Cancel</a>
        </p>
        </div>
         
</form>

</section>
@endsection