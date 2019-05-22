@extends('layouts.app')

@section('content')
<div class="container-fluid">
   <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Launch demo modal
   </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
               <form>
                     <div class="form-group">
                       <label for="exampleInputEmail1">Název</label>
                       <input type="text" class="form-control" placeholder="Zadejte název">
                     </div>
                   </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Zavřít</button>
            <button type="button" class="btn btn-primary">Přidat</button>
         </div>
      </div>
   </div>
</div>
@endsection