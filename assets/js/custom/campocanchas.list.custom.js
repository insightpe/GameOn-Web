$(function(){ 
    UiCampoCanchasList.init(); 
});

var UiCampoCanchasList = function() {
    return {
        dtCampoCanchas: null,
        init: function() {
          $("#btnBuscar").click(UiCampoCanchasList.buscar);
          $("#btnLimpiar").click(UiCampoCanchasList.limpiar);
          this.loadDataTable();
        },
        loadDataTable: function(){
          this.dtCampoCanchas = $('#dt-campocanchas').DataTable({
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
                  text: '<i class="fa fa-plus"></i> Agregar Cancha',
                  className:"btn btn-primary pull-right",
                  action: function ( e, dt, node, config ) {
                      UiCampoCanchasList.add();
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
              "url": App.baseUrl + "get-list-campocanchas?campo_id=" + $("#campo_id").val() + "&deporte_id=" + $("#deporte_id").val(),
              "type": "POST",
            },
            "columns": [
              {"data": "campo_nombre", width:"35%"},
              {"data": "nombre", width:"35%"},
              {"data": "deporte_nombre", width:"20%"},
              {"data": "campo_estado_nombre", width:"10%"},
              {"data": "campo_cancha_id", "searchable": false, width:"70",  className : "text-center",
                "render": function (data, type, full, meta) {
                  return type === 'display' ?
                    ($("#__form_edit_campocanchas").val() == "1" ? '<a href="' + App.baseUrl + "editar-campocancha/" + full.campo_cancha_id + '" class="btn btn-round btn-warning btn-icon btn-sm"><i class="fas fa-pencil-alt"></i></a> ' : "") +
                    ($("#__delete_campocanchas").val() == "1" ? '<a href="#" onclick="UiCampoCanchasList.delete(' + full.campo_cancha_id + ')" class="btn btn-round btn-danger btn-icon btn-sm"><i class="fas fa-times"></i></a> ' : "") :
                    data;
                },
                "orderable": false,
              },
            ],
            pageLength: 10,
          });
        },
        buscar: function(){
          UiCampoCanchasList.dtCampoCanchas.ajax.url(App.baseUrl + "get-list-campocanchas?campo_id=" + $("#campo_id").val() + "&deporte_id=" + $("#deporte_id").val()).load();
        },
        limpiar: function(){
          $("#campo_id").val("");
          $("#deporte_id").val("");
          UiCampoCanchasList.buscar();
        },
        add: function(){
            window.location = App.baseUrl + "nuevo-campocancha";
        },
        delete: function(id){
            App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
        },
        execDelete: function(id){
            $.ajax({
                url: App.baseUrl + "eliminar-campocancha/" + id,
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
                    UiCampoCanchasList.dtCampoCanchas.ajax.reload();
                  }
                }
            });
        }
    }
}();