$(function(){ 
    UiCampoList.init(); 
});

var UiCampoList = function() {
    return {
        dtCampo: null,
        init: function() {
            this.dtCampo = $('#dt-campos').DataTable({
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
                      text: '<i class="fa fa-plus"></i> Agregar Campo Deportivo',
                      className:"btn btn-primary pull-right",
                      action: function ( e, dt, node, config ) {
                          UiCampoList.add();
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
                  "url": App.baseUrl + "get-list-campos",
                  "type": "POST",
                },
                "columns": [
                  {"data": "nombre", width:"60%"},
                  {"data": "ubicacion", width:"20%"},
                  {"data": "estado_nombre", width:"20%",
                    "render": function (data, type, full, meta) {
                        if(type === 'display'){
                          var badget = "";
                          switch(full.campo_estado_id){
                              case "1":
                                  badget = "badge badge-success";
                                  break;
                              case "2":
                                  badget = "badge badge-danger";
                                  break;
                          }

                          var r = "<span class='" + badget + "'>" + data + "</span>";
                          return r;
                        }else{
                            return data;
                        }
                    }
                  },
                  {"data": "campo_id", "searchable": false, width:"70",  className : "text-center",
                    "render": function (data, type, full, meta) {
                      return type === 'display' ?
                        ($("#__form_edit_campo").val() == "1" ? '<a href="' + App.baseUrl + "editar-campo/" + full.campo_id + '" class="btn btn-round btn-warning btn-icon btn-sm"><i class="fas fa-pencil-alt"></i></a> ' : "") +
                        ($("#__delete_campo").val() == "1" ? '<a href="#" onclick="UiCampoList.delete(' + full.campo_id + ')" class="btn btn-round btn-danger btn-icon btn-sm"><i class="fas fa-times"></i></a> ' : "") :
                        data;
                    },
                    "orderable": false,
                  },
                  
                ],
                pageLength: 10,
            });
        },
        add: function(){
            window.location = App.baseUrl + "nuevo-campo";
        },
        delete: function(id){
            App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
        },
        execDelete: function(id){
            $.ajax({
                url: App.baseUrl + "eliminar-campo/" + id,
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
                    UiCampoList.dtCampo.ajax.reload();
                  }
                }
            });
        }
    }
}();