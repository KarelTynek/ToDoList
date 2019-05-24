function addForm(column) {
    var parent = $(column).parents('.card').find('.card-body');

    if ($(parent).children(".item").length <= 0) {
       parent.append(
       `
       <div class="item">
          <div class="form-group">
             <textarea name="desc" class="form-control"></textarea>
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