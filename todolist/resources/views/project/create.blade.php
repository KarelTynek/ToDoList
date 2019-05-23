@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-12">
      @if ($errors->any())
      <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        {{$error}}<br />
        @endforeach
      </div>
      @endif
    </div>
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          Vytvoření projektu
        </div>
        
        <div class="card-body">
          <form method="post" action="{{ route('project.store') }}">
            @csrf
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Název</div>
                </div>
                <input name="title" type="text" class="form-control" max="32" required />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Popisek</div>
                </div>
                <textarea name="desc" class="form-control" placeholder="Nepovinné"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Typ</div>
                </div>
                <select name="type" class="form-control" required>
                  <option value="1">Soukromý</option> 
                  <option value="0">Veřejný</option>
                <select>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Vytvořit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection