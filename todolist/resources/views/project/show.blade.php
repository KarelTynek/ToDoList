@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <div class="row">
      <div class="col-md-12">
         <div id="columns" class="row">
            @foreach ($columns as $column)
               <div class="col-3">
                     <div class="card border-secondary">
                           <div class="card-header">{{ $column->name }}</div>
                           <div class="card-body text-secondary"></div>
                        </div>   
               </div>
            @endforeach
         </div>
      </div>
   </div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#columnmodal">
   Přidat sloupec
</button>
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
            <form>
               <div class="form-group">
                  <label for="name">Název</label>
                  <input name="name" type="text" class="form-control" placeholder="Název">
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
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $.ajax({
            type: "POST",
            url: "{{ route('project.column') }}",
            data: { 
               name: $('input[name=name]').val(),
               project: '{{ $project }}'
            },success: function(data) {
               $('#columnmodal').modal('toggle');

               $('#columns').append(
                  `
                  <div class="col-3">
                     <div class="card border-secondary">
                        <div class="card-header">${data.column.name}</div>
                        <div class="card-body text-secondary"></div>
                     </div>
                  </div>
                  `
               );
            },error: function(data) {
               console.log("error");
            }
         });
         
      });
   </script>
@endpush