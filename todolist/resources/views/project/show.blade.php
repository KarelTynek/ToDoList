@extends('layouts.app')

@section('content')
<div class="container-fluid mt-3">
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
                  <i class="fas fa-share-alt"></i>
               </button>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#share">Sdílet</a>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#sharelist">Seznam</a>
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
<script>
   function addForm(column) {
   var parent = $(column).parents('.card').find('.main');

   if ($(parent).children(".item").length <= 0) {
      parent.prepend(
      `
      <div class="item">
         <div class="item border rounded shadow-sm mb-2 p-2">
            <div class="form-group">
               <textarea name="desc" class="form-control" placeholder="Text poznámky"></textarea>
            </div>
            <div class="row">
               <div class="col-md-6 mt-2">
                  <button onclick="remRow(this)" type="button" class="btn btn-secondary w-100">Zrušit</button>
               </div>
               <div class="col-md-6 mt-2">
                  <button onclick="addRow(this)" type="button" class="btn btn-success w-100">Přidat</button>
               </div>   
            </div>
         </div>
      </div>
      `
   )
   }

}

function remRow(column) {
   $(column).parents(".item").remove();
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
         var err = JSON.parse(request.responseText);
         console.log(request.responseText);
         $("#err").html("");
         $("#err").append(`<div class="alert alert-danger alert-dismissible fade show">Vyplňtě poznámky
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>`);
      }
   });  
}

function edit(column) {
   var id = $(column).parents('.card').find('input[name=id]').val();
   var target = $(column).parents('.card').find('.cardname');
   var name = $(column).parents('.card').find('.cardname').html();

   if ($(target).find('input').length) return;

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
            $('#err').append(err);
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
            $('#err').append(err);
         }
      });
}

function editRow(row){
   var id = $(row).siblings().last().val();
   var target = $(row).closest('.card').find('.rowDesc');
   var description = $(row).closest('.card').find('.rowDesc').html();

   description = description.trim();

   console.log(description);

   if ($(target).find('textarea').length) return;

   target.html(`<textarea class="form-control" id="${id}" rows="3">${description}</textarea>`);

   $(target).focusout(function() {
      target.html($(`#${id}`).val());

      $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      $.ajax({
         type: "POST",
         url: "{{ route('row.edit') }}",
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

function delRow(row) {
   var id = $(row).siblings().last().val();
   console.log(id);

   $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      $.ajax({
         type: "POST",
         url: "{{ route('row.delete') }}",
         data: { 
            id: id,
            _method: 'DELETE',
         },success: function(data) {
            reload()
         },error: function(request, status, error) {
            var err = JSON.parse(request.responseText);
            console.log(err);
            $('#err').append(err);
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
         var err = JSON.parse(request.responseText);
         console.log(request.responseText);
         $('#err').append(err);
      });
   }
</script>
@endpush