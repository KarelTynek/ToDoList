@foreach ($columns->chunk(4) as $chunk)
<div class="row">
   @foreach ($chunk as $item)
   <div class="col-md-3 mb-3">
      <div class="card shadow-sm column">
         <div class="card-header">
            <div class="row">
               <div class="col-9">
                  <span class="cardname">{{ $item->name }}</span>
               </div>

               <div class="float-right">
                  <a onclick="addForm(this)" href="#"><i class="fas fa-plus mr-1"></i></a>
                  <a onclick="edit(this)" href="#"><i class="fas fa-pen mr-1"></i></a>
                  <i class="fas fa-trash-alt"></i>
               </div>
            </div>

         </div>
         <div class="main card-body column-text scrollbar-card">
            <input type="hidden" name="id" value="{{ $item->id_column }}" />
            @foreach ($rows as $row)
            @if ($row->fk_column == $item->id_column)
            <div class="card mb-2 bg-light">
               <div class="card-body">
                  {{ $row->description }}
               </div>
            </div>
            @endif
            @endforeach
         </div>
      </div>
   </div>
   @endforeach
</div>
@endforeach