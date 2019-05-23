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
            <form id="columnform" method="post" action="{{ route('project.column') }}">
               @csrf
               <div class="form-group">
                  <label for="name">Název</label>
                  <input name="name" type="text" class="form-control" placeholder="Název">
                  <input name="project" type="hidden" value="{{ $project }}">
               </div>
               <button id="addcolumn" type="button" class="btn btn-success w-100">Přidat</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection


@push('scripts')
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
   <script>
      $('#addcolumn').click(function() {
         $.ajax({
            url: '{{ route('reload') }}',
            data: {
               id: '{{ $project }}'
            }
         }).done(function(data) {
            $('#columnscontainer').html(data.view);
         }).fail(function(request, status, error) {
            console.log(request.responseText);
         });
      });
   </script>
@endpush