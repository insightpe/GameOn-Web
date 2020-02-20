$(function(){ 
    UiRoleList.init(); 
});

var UiRoleList = function() {
    return {
        dtRole: null,
        init: function() {
            this.dtRole = $('#dt-roles').DataTable({
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
                      text: '<i class="fa fa-plus"></i> Agregar Rol',
                      className:"btn btn-primary pull-right",
                      action: function ( e, dt, node, config ) {
                          UiRoleList.add();
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
                  "url": App.baseUrl + "get-list-roles",
                  "type": "POST",
                },
                "columns": [
                  {"data": "role", width:"100%"},
                  {"data": "role_id", "searchable": false, width:"70",  className : "text-center",
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        ($("#__role_permissions").val() == "1" ? '<a href="' + App.baseUrl + "permisos-rol/" + full.role_id + '" class="btn btn-round btn-info btn-icon btn-sm"><i class="fas fa-cog"></i></a> ' : "") + 
                        ($("#__form_edit_role").val() == "1" ? '<a href="' + App.baseUrl + "editar-rol/" + full.role_id + '" class="btn btn-round btn-warning btn-icon btn-sm"><i class="fas fa-pencil-alt"></i></a> ' : "") +
                        ($("#__delete_role").val() == "1" ? '<a href="#" onclick="UiRoleList.delete(' + full.role_id + ')" class="btn btn-round btn-danger btn-icon btn-sm"><i class="fas fa-times"></i></a> ' : "") :
                        data;
                    },
                    "orderable": false,
                  },
                  
                ],
                pageLength: 10,
            });
        },
        add: function(){
            window.location = App.baseUrl + "nuevo-rol";
        },
        delete: function(id){
            App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
        },
        execDelete: function(id){
            $.ajax({
                url: App.baseUrl + "eliminar-rol/" + id,
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
                    UiRoleList.dtRole.ajax.reload();
                  }
                }
            });
        }
    }
}();