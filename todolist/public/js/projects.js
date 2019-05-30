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
      url: "http://localhost:8000/row/add",
      data: {
         desc: text,
         id: id
      }, success: function (data) {
         reload()
      }, error: function (request, status, error) {
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

   $(target).focusout(function () {
      target.html($(`#${id}`).val());

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      $.ajax({
         type: "POST",
         url: "http://localhost:8000/column/rename",
         data: {
            id: id,
            title: target.html()
         }, success: function (data) {
            reload()
         }, error: function (request, status, error) {
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
      url: "http://localhost:8000/column/delete",
      data: {
         id: id,
         _method: 'DELETE',
      }, success: function (data) {
         reload()
      }, error: function (request, status, error) {
         var err = JSON.parse(request.responseText);
         console.log(err);
         $('#err').append(err);
      }
   });
}

function editRow(row) {
   var id = $(row).siblings().last().val();
   var target = $(row).closest('.card').find('.rowDesc');
   var description = $(row).closest('.card').find('.rowDesc').html();

   description = description.trim();

   console.log(description);

   if ($(target).find('textarea').length) return;

   target.html(`<textarea class="form-control" id="${id}" rows="3">${description}</textarea>`);

   $(target).focusout(function () {
      target.html($(`#${id}`).val());

      $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
      });

      $.ajax({
         type: "POST",
         url: "http://localhost:8000/row/edit",
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
      url: "http://localhost:8000/row/delete",
      data: {
         id: id,
         _method: 'DELETE',
      }, success: function (data) {
         reload()
      }, error: function (request, status, error) {
         var err = JSON.parse(request.responseText);
         console.log(err);
         $('#err').append(err);
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
      url: "http://localhost:8000/column/add",
      data: {
         name: $('input[name=name]').val(),
         project: $('.container-fluid').data('project')
      }, success: function (data) {
         $('#columnmodal').modal('toggle');
         $('#errors').html('');
         reload()
      }, error: function (request, status, error) {
         var err = JSON.parse(request.responseText);
         console.log(err);

         /*if (err.errors.name != 'undefined') {
            $('#errors').html('');
            $('#errors').append(err.errors.name);
         }

         if (err.errors.project != 'undefined')
            $('#errors').append(err.errors.project);
         */
      }
   });
});

function reload() {
   $.ajax({
      url: 'http://localhost:8000/column/reload',
      data: {
         id: $('.container-fluid').data('project')
      }
   }).done(function (data) {
      $('#columnscontainer').html(data.view);
   }).fail(function (request, status, error) {
      var err = JSON.parse(request.responseText);
      console.log(request.responseText);
      $('#err').append(err);
   });
}