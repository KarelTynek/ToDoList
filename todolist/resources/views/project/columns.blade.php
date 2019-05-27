@foreach ($columns->chunk(4) as $chunk)
<div class="row">
   @foreach ($chunk as $item)
   <div class="col-md-3 mb-3">
      <div class="card shadow-sm column">
         <div class="card-header">
            <div class="row">
               <div class="col-7">
                  <span class="cardname">{{ $item->name }}</span>
               </div>
               <div class="col-5">
                  <div class="float-right">
                     <a onclick="addForm(this)" href="#"><i class="fas fa-plus mr-1"></i></a>
                     <a onclick="edit(this)" href="#"><i class="fas fa-pen mr-1"></i></a>
                     <a onclick="del(this)" href="#"><i class="fas fa-trash-alt"></i></a>
                  </div>
               </div>
            </div>
         </div>
         <div class="main card-body column-text scrollbar-card">
            <input type="hidden" name="id" value="{{ $item->id_column }}" />
            @foreach ($rows as $row)
            @if ($row->fk_column == $item->id_column)
            <div class="card mb-2 bg-light" id="test">
               <div class="card-header">
                  <div class="float-right">
                     <a onclick="editRow(this)" href="#" class="text-secondary"><i class="fas fa-edit mr-1"></i></a>
                     <a onclick="delRow(this)" href="#" class="text-secondary"><i class="fas fa-trash-alt"></i></a>
                     <input type="hidden" name="idrow" value="{{ $row->id_row }}" />
                  </div>
               </div>
               <div class="card-body">
                  <span class="rowDesc">
                        {{ $row->description }}
                  </span>
                  
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