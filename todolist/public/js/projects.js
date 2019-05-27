function addForm(column) {
   var parent = $(column).parents('.card').find('.main');

   if ($(parent).children(".item").length <= 0) {
      parent.prepend(
         `
      <div class="item">
         <div class="item border shadow-sm mb-2 p-2">
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
      }, success: function (data) {
         reload()
      }, error: function (request, status, error) {
         console.log(request.responseText);
      }
   });
}

function edit(column) {
   var id = $(column).parents('.card').find('input[name=id]').val();
   var target = $(column).parents('.card').find('.cardname');
   var name = $(column).parents('.card').find('.cardname').html();

   if ($(target).find('input').length) return;

   target.html(`<input id="${id}" type="text" value="${name}" class="form-control" />`);

   $(target).focusout(function () {
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
         }, success: function (data) {
            reload()
         }, error: function (request, status, error) {
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
      }, success: function (data) {
         reload()
      }, error: function (request, status, error) {
         var err = JSON.parse(request.responseText);
         console.log(err);
      }
   });
}

$('#addcolumn').click(function () {
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
      }, success: function (data) {
         $('#columnmodal').modal('toggle');
         $('#errors').html('');
         reload()
      }, error: function (request, status, error) {
         var err = JSON.parse(request.responseText);

         if (err.errors.name != 'undefined') {
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
   }).done(function (data) {
      $('#columnscontainer').html(data.view);
   }).fail(function (request, status, error) {
      console.log(request.responseText);
   });
}