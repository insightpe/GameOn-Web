$(function(){ 
    UiPermissionList.init(); 
});

var UiPermissionList = function() {
    return {
      dtPermision: null,
        init: function() {
            $("#btnAddPermission").click(UiPermissionList.add);

            this.dtPermision = $('#dt-permissions').DataTable({
                responsive: true,
                buttons: [
                    {extend:'copyHtml5', 
                    text: "Copiar",
                      className:"btn btn-effect-ripple btn-default toggle-bordered enable-tooltip",
                      init: function(api, node, config) {
                          $(node).removeClass('dt-button')
                      }
                    },
                    {extend:'csvHtml5', 
                      className:"btn btn-effect-ripple btn-default toggle-bordered enable-tooltip",
                      init: function(api, node, config) {
                          $(node).removeClass('dt-button')
                      }
                    },
                    {extend:'excelHtml5', 
                      className:"btn btn-effect-ripple btn-default toggle-bordered enable-tooltip",
                      init: function(api, node, config) {
                          $(node).removeClass('dt-button')
                      }
                    },
                    {extend:'pdfHtml5', 
                      className:"btn btn-effect-ripple btn-default toggle-bordered enable-tooltip",
                      init: function(api, node, config) {
                          $(node).removeClass('dt-button')
                      }
                    },
                    {
                      text: '<i class="fa fa-plus"></i> Agregar Permiso',
                      className:"btn btn-primary pull-right",
                      action: function ( e, dt, node, config ) {
                          UiPermissionList.add();
                      },
                      init: function(api, node, config) {
                          $(node).removeClass('dt-button');
                          setTimeout(function(){
                            $(node).parent().parent().append($(node));
                          }, 100);
                      },
                    }
                ],
                columnDefs: [
                  { targets: 'no-sort', orderable: false }
                ],
                processing: true,
                serverSide: true,
                ajax: {
                  "url": App.baseUrl + "get-list-permissions",
                  "type": "POST",
                },
                "columns": [
                  {"data": "title", width:"70%"},
                  {"data": "name", width:"30%"},
                  {"data": "id_permission", "searchable": false, width:"70",  className : "text-center",
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        ($("#__form_edit_permission").val() == "1" ? '<a href="' + App.baseUrl + "editar-permisos/" + full.id_permission + '" class="btn btn-round btn-warning btn-icon btn-sm"><i class="fas fa-pencil-alt"></i></a> ' : "") +
                        ($("#__delete_permission").val() == "1" ? '<a href="#" onclick="UiPermissionList.delete(' + full.id_permission + ')" class="btn btn-round btn-danger btn-icon btn-sm"><i class="fas fa-times"></i></a> ' : "") :
                        data;
                    },
                    "orderable": false,
                  },
                  
                ],
                pageLength: 10,
            });
        },
        add: function(){
            window.location = App.baseUrl + "nuevo-permiso";
        },
        delete: function(id){
            App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
        },
        execDelete: function(id){
            $.ajax({
                url: App.baseUrl + "eliminar-permisos/" + id,
                type:'GET',
                dataType: "json",
                data: {},
                success: function(data) {
                  if(!$.isEmptyObject(data.error)){
                    Swal.fire({
                        title: "Error",
                        html: data.error,
                        buttonsStyling: false,
                        confirmButtonClass: "btn btn-success",
                        type: "error"
                    });
                  }else{
                    UiPermissionList.dtPermision.ajax.reload();
                  }
                }
            });
        }
    }
}();