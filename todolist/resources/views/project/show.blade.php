@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#columnmodal">
            Přidat sloupec
         </button>
         <span class="align-middle ml-2 text-muted">
            {{ $projectData->title }}
            @if ($projectData->description != null)
            - {{ str_limit($projectData->description, $limit = 150, $end = '...') }}
            @endif
         </span>
      </div>
   </div>
   <hr />
   @foreach ($columns->chunk(4) as $chunk)
   <div class="row">
      @foreach ($chunk as $item)
      <div class="col-md-3 mb-3">
         <div class="card shadow-sm">
            <div class="card-header">{{ $item->name }}
               <div class="float-right">
                  <i class="fas fa-plus mr-1"></i>
                  <i class="fas fa-pen mr-1"></i>
                  <form method="POST" action="{{ route('column.delete') }}" id="delete">
                     @csrf
                     @method('DELETE')
                     <input name="id" type="hidden" value="{{ $item->id_column }}" />
                  </form>
                  <a href="#" data-toggle="modal" data-target="#deletemodal"><i class="fas fa-trash-alt"></i></a>
               </div>
            </div>
            <div class="card-body text-secondary"></div>
         </div>
      </div>
      @endforeach
   </div>
   @endforeach
</div>

<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="deletemodallabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="deletemodallabel"><i class="fas fa-trash-alt"></i> Smazat sloupec</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            Opravdu chcete smazat tento sloupec?<br />
            <i>Tato akce smaže všechny poznámky v tomto sloupci.</i>
         </div>
         <div class="modal-footer">
            <button id="cancel" type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
            <button id="deletebtn" type="button" class="btn btn-danger">Smazat</button>
         </div>
      </div>
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
            <form method="post" action="{{ route('project.column') }}">
               @csrf
               <div class="form-group">
                  <label for="name">Název</label>
                  <input name="name" type="text" class="form-control" placeholder="Název">
                  <input name="project" type="hidden" value="{{ $project }}">
               </div>
               <button id="addcolumn" type="submit" class="btn btn-success w-100">Přidat</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@push('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script>
       $('#deletebtn').click(function() {
         $(this).prop('disabled', 'true');
         $('#cancel').prop('disabled', 'true');
         $('#delete').submit();
       });
    </script>
@endpush