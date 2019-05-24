@foreach ($columns->chunk(4) as $chunk)
<div class="row">
   @foreach ($chunk as $item)
   <div class="col-md-3 mb-3 d-flex">
      <div class="card shadow-sm w-100">
         <div class="card-header">
            {{ $item->name }}
            <div class="float-right">
               <a onclick="addForm(this)" href="#"><i class="fas fa-plus mr-1"></i></a>
               <i class="fas fa-pen mr-1"></i>
               <i class="fas fa-trash-alt"></i>
            </div>
         </div>
         <div class="card-body">
            <input type="hidden" name="id" value="{{ $item->id_column }}" />
            @foreach ($rows as $row)
               @if ($row->fk_column == $item->id_column)
                  {{ $row->description }}
               @endif
            @endforeach
         </div>
      </div>
   </div>
   @endforeach
</div>
@endforeach