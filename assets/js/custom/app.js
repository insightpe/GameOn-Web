$(function(){ 
    App.init(); 
});

var App = function() {
    return {
        baseUrl: "",
        init: function() {
            this.baseUrl = $("#baseUrl").val();
            this.datatables();
            $.fn.serializeFormJSON = function () {
                var o = {};
                var a = this.serializeArray();
                $.each(a, function () {
                    if (o[this.name]) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });
                return o;
            };
        },

        datatables: function(){
            $.extend(true, $.fn.dataTable.defaults, {
                "dom": "<'row'<'col-12'B>><'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-5 hidden-xs'i><'col-sm-7 col-xs-12 clearfix'p>>",
                "sPaginationType": "full_numbers",
                "oLanguage": {
                    "sProcessing": "Procesando...",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sSearch": "_INPUT_",
                    "sSearchPlaceholder": "Buscar Registros",
                    "sInfo": "Mostrando <strong>_START_</strong>-<strong>_END_</strong> de <strong>_TOTAL_</strong> registros",
                    "oPaginate": {
                        "sPrevious": "",
                        "sNext": "",
                        "sFirst": "Inicio",
                        "sLast": "Fin",
                    }
                }
            });
            $.extend($.fn.dataTableExt.oStdClasses, {
                "sWrapper": "dataTables_wrapper",
                "sFilterInput": "form-control",
                "sLengthSelect": "form-control"
            });
        },

        confirm: function(title, text, type, confirmButtonText, callback, args) {
            Swal.fire({
              title: title,
              text: text,
              type: type,
              showCancelButton: true,
              confirmButtonColor: "#007AFF",
              confirmButtonText: confirmButtonText,
              cancelButtonText: "Cancelar",
              closeOnConfirm: false,
              closeOnCancel: true
            }).then(function (result){
                if (result.value) {
                    callback(args);
                }
            });
          },

        checkFullPageBackgroundImage: function(){
            $page = $('.full-page');
            image_src = $page.data('image');
    
            if(image_src !== undefined){
                image_container = '<div class="full-page-background" style="background-image: url(' + image_src + ') "/>';
                $page.append(image_container);
            }
        },

        initDashboardPageCharts: function(){
    
          
        },

        initVectorMap: function(){
             var mapData = {
                    "AU": 760,
                    "BR": 550,
                    "CA": 120,
                    "DE": 1300,
                    "FR": 540,
                    "GB": 690,
                    "GE": 200,
                    "IN": 200,
                    "RO": 600,
                    "RU": 300,
                    "US": 2920,
                };
    
                $('#worldMap').vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: "transparent",
                    zoomOnScroll: false,
                    regionStyle: {
                        initial: {
                            fill: '#e4e4e4',
                            "fill-opacity": 0.9,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 0
                        }
                    },
    
                    series: {
                        regions: [{
                            values: mapData,
                            scale: ["#AAAAAA","#444444"],
                            normalizeFunction: 'polynomial'
                        }]
                    },
                });
        },
        showNotification: function(message, from = "top", align = "center", color = "danger"){
            //color = 'primary';
    
            $.notify({
                icon: "now-ui-icons ui-1_bell-53",
                message: message
    
            },{
                type: color,
                timer: 1000,
                placement: {
                    from: from,
                    align: align
                }
            });
        }
    }
}();