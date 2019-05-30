@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3" data-project="{{ $project }}">
   <div class="row">
      <div class="col-md-12">
         <div id="err"></div>
         @include('flash::message')
         @if ($errors->any())
         <div class="alert alert-warning">
            @foreach ($errors->all() as $error)
            {{$error}}<br />
            @endforeach
         </div>
         @endif
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#columnmodal">
            Přidat sloupec
         </button>
      <span class="ml-2 d-flex p-1 float-left lead text-dark"></span>
         <span class="ml-1 d-flex p-2 float-left text-muted"></span>

         @if ($projectData->owner == Auth::id())
         <span class="float-right d-flex">
            @if ($projectData->type == 0)
            <div class="dropdown mr-2">
               <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  Sdílení <i class="fas fa-share-alt"></i>
               </button>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#share">Sdílet</a>
                  <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#sharelist">Seznam</a>
               </div>
            </div>
            @endif
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">
               <i class="fas fa-trash"></i>
            </button>
         </span>
         @endif
      </div>
   </div>
   <hr />
   <div id="columnscontainer">
      @include('project.columns')
   </div>
</div>

<div class="modal fade" id="columnmodal" tabindex="-1" role="dialog" aria-labelledby="columnmodallabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="columnmodallabel">Přidat sloupec</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <span id="errors"></span>
            <div class="form-group">
               <label for="name">Název</label>
               <input name="name" type="text" class="form-control" placeholder="Název">
               <input name="project" type="hidden" value="{{ $project }}">
            </div>
            <button id="addcolumn" type="button" class="btn btn-success w-100">Přidat</button>
         </div>
      </div>
   </div>
</div>
@if ($projectData->type == 0 && $projectData->owner == Auth::id())
<div class="modal fade" id="share" tabindex="-1" role="dialog" aria-labelledby="sharelabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="sharelabel">Sdílení</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="POST" action="{{ route('project.share') }}">
               @csrf
               <div class="form-group">
                  <label for="email">E-mail</label>
                  <input name="email" type="email" class="form-control" placeholder="E-mail">
                  <input name="project" type="hidden" value="{{ $project }}">
               </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
            <button type="submit" class="btn btn-primary">Sdílet</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="sharelist" tabindex="-1" role="dialog" aria-labelledby="sharelistlabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="sharelistlabel">Seznam sdílení</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">Jméno</th>
                        <th scope="col">Email</th>
                        <th scope="col">Akce</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($shared as $item)
                     <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td><a href="{{ route('sharedelete', ['email' => $item->email ]) }}">Odebrat</a></td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
         </div>
      </div>
   </div>
</div>
@endif
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="deletelabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deletelabel">Smazat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            Opravdu chcete tento projekt smazat?
            <form method="POST" action="{{ route('project.delete') }}">
               @method('DELETE')
               @csrf
               <input name="project" type="hidden" value="{{ $project }}">
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
            <button type="submit" class="btn btn-primary">Ano</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="{{ asset('js/projects.js') }}"></script>
@endpush