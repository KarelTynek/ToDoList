@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row mt-2">
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
                <input name="title" type="text" class="form-control" max="32" />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Popisek</div>
                </div>
                <textarea class="form-control"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <div class="input-group-prepend">
                  <div class="input-group-text">Typ</div>
                </div>
                <select class="form-control">
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