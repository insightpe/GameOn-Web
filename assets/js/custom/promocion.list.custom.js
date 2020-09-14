$(function(){ 
    UiPromocionList.init(); 
});

var UiPromocionList = function() {
    return {
        dtRole: null,
        init: function() {
            this.dtRole = $('#dt-promociones').DataTable({
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
                      text: '<i class="fa fa-plus"></i> Agregar Promocion',
                      className:"btn btn-primary pull-right",
                      action: function ( e, dt, node, config ) {
                          UiPromocionList.add();
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
                  "url": App.baseUrl + "get-list-promociones",
                  "type": "POST",
                },
                "columns": [
                  {"data": "titulo", width:"35%"},
                  {"data": "subtitulo", width:"29%"},
                  {"data": "imagen", "searchable": false, width:"10%", 
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        "<a target='_blank' href='" + App.baseUrl + "/assets/img/promociones_img/" + full.imagen + "'>Ver Imágen</a>" :
                        data;
                    },
                    "orderable": false,
                  },
                  {"data": "url", "searchable": false, width:"16%", 
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        "<a href='" + full.url + "' target='_blank'>" + full.url + "</a>" :
                        data;
                    },
                    "orderable": false,
                  },
                  {"data": "activado", width:"10%"},
                  {"data": "promocion_id", "searchable": false, width:"70",  className : "text-center",
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        ($("#__form_edit_promocion").val() == "1" ? '<a href="' + App.baseUrl + "editar-promocion/" + full.promocion_id + '" class="btn btn-round btn-warning btn-icon btn-sm"><i class="fas fa-pencil-alt"></i></a> ' : "") +
                        ($("#__delete_promocion").val() == "1" ? '<a href="#" onclick="UiPromocionList.delete(' + full.promocion_id + ')" class="btn btn-round btn-danger btn-icon btn-sm"><i class="fas fa-times"></i></a> ' : "") :
                        data;
                    },
                    "orderable": false,
                  },
                  
                ],
                pageLength: 10,
            });
        },
        add: function(){
            window.location = App.baseUrl + "nuevo-promocion";
        },
        delete: function(id){
            App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
        },
        execDelete: function(id){
            $.ajax({
                url: App.baseUrl + "eliminar-promocion/" + id,
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
                    UiPromocionList.dtRole.ajax.reload();
                  }
                }
            });
        }
    }
}();