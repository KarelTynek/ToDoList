@extends('layouts.app')

@section('content')
<div class="container-fluid">
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
   </div>
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
@endsection


@push('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
   integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>
<script>
   function addForm(column) {
      var parent = $(column).parents('.card').find('.main');

      if ($(parent).children(".item").length <= 0) {
         parent.prepend(
         `
         <div class="item border mb-2 p-2">
            <div class="form-group">
               <textarea name="desc" class="form-control" placeholder="Text poznámky"></textarea>
            </div>
            <div class="row">
               <div class="col-md-6 mt-2">
                  <button type="button" class="btn btn-secondary w-100">Zrušit</button>
               </div>
               <div class="col-md-6 mt-2">
                  <button onclick="addRow(this)" type="button" class="btn btn-success w-100">Přidat</button>
               </div>   
            </div>
         </div>
         `
      )
      }

   }

   function addRow(column) {
      var id = $(column).parents('.card-body').find('input[name=id]').val();
      var text = $(column).parents('.card-body').find('textarea[name=desc]').val();

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

       $.ajax({
         type: "POST",
         url: "{{ route('row.add') }}",
         data: { 
            desc: text,
            id: id
         },success: function(data) {
            reload()
         },error: function(request, status, error) {
            console.log(request.responseText);
         }
      });  
   }

   function edit(column) {
      var id = $(column).parents('.card').find('input[name=id]').val();
      var target = $(column).parents('.card').find('.cardname');
      var name = $(column).parents('.card').find('.cardname').html();

      target.html(`<input id="${id}" type="text" value="${name}" class="form-control" />`);

      $(target).focusout(function() {
         target.html($(`#${id}`).val());

         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $.ajax({
            type: "POST",
            url: "{{ route('column.rename') }}",
            data: { 
               id: id,
               title: target.html()
            },success: function(data) {
               reload()
            },error: function(request, status, error) {
               var err = JSON.parse(request.responseText);
               console.log(err);
            }
         });
      });
   }

   function del(column) {
      var id = $(column).parents('.card').find('input[name=id]').val();

      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $.ajax({
            type: "POST",
            url: "{{ route('column.delete') }}",
            data: { 
               id: id,
               _method: 'DELETE',
            },success: function(data) {
               reload()
            },error: function(request, status, error) {
               var err = JSON.parse(request.responseText);
               console.log(err);
            }
         });
   }

   $('#addcolumn').click(function() {
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });

         $.ajax({
            type: "POST",
            url: "{{ route('column.add') }}",
            data: { 
               name: $('input[name=name]').val(),
               project: '{{ $project }}'
            },success: function(data) {
               $('#columnmodal').modal('toggle');
               $('#errors').html('');
               reload()
            },error: function(request, status, error) {
               var err = JSON.parse(request.responseText);
               
               if (err.errors.name != 'undefined'){
                  $('#errors').html(''); 
                  $('#errors').append(err.errors.name);
               } 

               if (err.errors.project != 'undefined') 
                  $('#errors').append(err.errors.project);
               
            }
         });
      });

      function reload() {
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
      }
</script>
@endpush