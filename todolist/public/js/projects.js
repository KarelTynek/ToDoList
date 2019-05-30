// SLOUPCE

// Přídání sloupce
$('#addcolumn').click(function () { 
   let data = {
      name: $('input[name=name]').val(),
      project: $('.container-fluid').data('project')
   }

   sendPost("http://localhost:8000/column/add", data);
   $('#columnmodal').modal('toggle');
   $('#errors').html('');
});

function delColumn(column) {
   let data =  {
      id: $(column).parents('.card').find('input[name=id]').val()
   }

   sendDelete("http://localhost:8000/column/delete", data);
}

function editColumn(column) {
   let id = $(column).parents('.card').find('input[name=id]').val();
   let element = $(column).parents('.card').find('.cardname');

   if ($(element).find('input').length) return;

   element.html(`<input id="${id}" type="text" value="${element.html()}" class="form-control" />`);

   $(element).focusout(function () {
      element.html($(`#${id}`).val());

      let data = {
         id: id,
         name: element.html()
      }

      sendPost("http://localhost:8000/column/rename", data);
   });
}

// POZNÁMKY
function addForm(column) {
   var parent = $(column).parents('.card').find('.main');

   if ($(parent).children(".item").length <= 0) {
      parent.prepend(
         `
         <div class="item border rounded shadow-sm mb-2 p-2">
            <div class="form-group">
               <textarea name="desc" class="form-control" placeholder="Text poznámky"></textarea>
            </div>
            <div class="row">
               <div class="col-md-6 mt-2">
                  <button onclick="remForm(this)" type="button" class="btn btn-secondary w-100">Zrušit</button>
               </div>
               <div class="col-md-6 mt-2">
                  <button onclick="addRow(this)" type="button" class="btn btn-success w-100">Přidat</button>
               </div>   
            </div>
            <div class="row">
               <div class="col-md-12 mt-2">
                  <select name="priority" class="custom-select custom-select-sm">
                        <option selected disabled>Priorita</option>
                        <option value="1">Nejvyšší</option>
                        <option value="2">Střední</option>
                        <option value="3">Nejmenší</option>
                  </select>
               </div>
            </div>
         </div>
      `
      )
   }
}

function remForm(column) {
   $(column).parents(".item").remove();
}

function addRow(column) {
   let data = {
      desc: $(column).parents('.card-body').find('textarea[name=desc]').val(),
      id: $(column).parents('.card-body').find('input[name=id]').val(),
      priority: $(column).parents('.card-body').find('select[name=priority]').val()
   };

   sendPost("http://localhost:8000/row/add", data);
}

function delRow(row) {
   let data = {
      id: $(row).siblings().last().val()
   }

   sendDelete("http://localhost:8000/row/delete", data);
}

function editRow(row) {
   if (($(row).closest('.card').children('.card-body').find('textarea')).length > 0 ) return;

   let id = $(row).siblings().last().val();
   let element = $(row).closest('.card').children('.card-body').find('.rowdesc');
   let priority = $(row).closest('.card').data('priority');

   let originalText = $(row).closest('.card').children('.card-body').find('.rowdesc').html();
   originalText = originalText.trim();

   $(row).closest('.card').children('.card-body').find('.rowdesc').html(`
      <textarea class="form-control" id="${id}" rows="3">${originalText}</textarea>
      <div class="row">
         <div class="col-md-12 mt-2">
            <select name="priority" class="custom-select custom-select-sm">
               <option value="1" ${ (priority == 1) ? 'selected' : null }>Nejvyšší</option>
               <option value="2" ${ (priority == 2) ? 'selected' : null }>Střední</option>
               <option value="3" ${ (priority == 3) ? 'selected' : null }>Nejmenší</option>
            </select>
         </div>
      </div>
   `);

   $(element).focusout(function () {
      let data = {
         id: id,
         desc: $(row).closest('.card').children('.card-body').find('textarea').val(),
         priority: $(row).closest('.card').children('.card-body').find('select[name=priority]').val()
      }

      sendPost('http://localhost:8000/row/edit', data);
   });

   $(row).closest('.card').children('.card-body').find('select[name=priority]').change(function() {
      let data = {
         id: id,
         desc: $(row).closest('.card').children('.card-body').find('textarea').val(),
         priority: $(row).closest('.card').children('.card-body').find('select[name=priority]').val()
      }

      sendPost('http://localhost:8000/row/edit', data);
   })
}

// AJAX REQUESTY

function sendPost(url, data) {
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $.ajax({
      type: "POST",
      url: url,
      data: {
         data: data
      }
   }).done(function (data) {
      reload()
   }).fail(function (request, status, error) {
      console.log(request);
      console.log(status);
      console.log(eror)
   });
}

function sendDelete(url, data) {
   $.ajaxSetup({
      headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
   });

   $.ajax({
      type: "POST",
      url: url,
      data: {
         data: data,
         _method: 'DELETE'
      }
   }).done(function (data) {
      reload();
   }).fail(function (request, status, error) {

   });
}

function reload() {
   $.ajax({
      url: 'http://localhost:8000/column/reload',
      data: {
         id: $('.container-fluid').data('project')
      }
   }).done(function (data) {
      $('#columnscontainer').html(data.view);
   }).fail(function (request, status, error) {

   });
}