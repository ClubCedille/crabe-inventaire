@extends('layouts.app')

@section('content')
  <section class="bd-index-fullscreen hero is-fullheight">
    <form method="POST" id="update-category-form" action="{{URL::to('/category')}}/{{$category->id}}">
      @csrf
      @method('PUT')
      <div class="field">
        <label class="label">{{__('category.name')}}</label>
        <div class="control">
          <input class="input" type="text" placeholder="{{__('category.placeholder.name')}}" name=name value="{{$category->name}}">
        </div>
      </div>

      <div class="field">
        <label class="label">{{__('category.description')}}</label>
        <div class="control">
          <input class="input" type="text" placeholder="{{__('category.placeholder.description')}}" name=description value="{{$category->description}}">
        </div>
      </div>

      <div class="field is-grouped">
        <p class="control">
          <input class="button is-rounde is-info" type="submit" value="{{__('actions.save')}}">
        </p>
        <p class="control">
          <a  class="button is-rounde" href="{{URL::to('/category')}}" >{{__('actions.cancel')}}</a>
        </p>
      </div>

    </form>

  </section>
@endsection
