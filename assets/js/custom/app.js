$(function(){ 
    App.init(); 
});

var App = function() {
    return {
        role_campo_id:9,
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

            $.blockUI.defaults.baseZ = 9000;
            $.blockUI.defaults.css.backgroundColor = "transparent";
            $.blockUI.defaults.css.border = "0px";
            $.blockUI.defaults.message = '  <img class="responsive-img" src="' + this.baseUrl + 'assets/img/loading.gif" width="128px" />';
            $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
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
        },
        initFullCalendar: function(){
            $calendar = $('#fullCalendar');
    
            today = new Date();
            y = today.getFullYear();
            m = today.getMonth();
            d = today.getDate();
    
            $calendar.fullCalendar({
                locale: 'es',
                viewRender: function(view, element) {
                    // We make sure that we activate the perfect scrollbar when the view isn't on Month
                    if (view.name != 'month'){
              
                        var ps1 = new PerfectScrollbar('.fc-scroller');
                    }
                },
                header: {
                    left: 'title',
                    center: 'month,agendaWeek,agendaDay',
                    right: 'prev,next,today'
                },
                defaultDate: today,
                selectable: true,
                selectHelper: true,
                views: {
                    month: { // name of view
                        titleFormat: 'MMMM YYYY'
                        // other view-specific options here
                    },
                    week: {
                        titleFormat: " MMMM D YYYY"
                    },
                    day: {
                        titleFormat: 'D MMM, YYYY'
                    }
                },
    
                select: function(start, end) {
    
                    // on select we show the Sweet Alert modal with an input
                    Swal.fire({
                    title: 'Create an Event',
                    html: '<div class="form-group">' +
                    '<input class="form-control" placeholder="Event Title" id="input-field">' +
                    '</div>',
                    showCancelButton: true,
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false
            }).then((result) => {
                var eventData;
                event_title = $('#input-field').val();
    
                if (event_title) {
                          eventData = {
                              title: event_title,
                              start: start,
                              end: end
                          };
                          $calendar.fullCalendar('renderEvent', eventData, true); // stick? = true
                      }
                    $calendar.fullCalendar('unselect');
            });
                },
                editable: true,
                eventLimit: true, // allow "more" link when too many events
    
    
                // color classes: [ event-blue | event-azure | event-green | event-orange | event-red ]
                events: [
                    {
                        title: 'All Day Event',
                        start: new Date(y, m, 1),
                        className: 'event-default'
                    },
                    {
                        title: 'Meeting',
                        start: new Date(y, m, d-1, 10, 30),
                        allDay: false,
                        className: 'event-green'
                    },
                    {
                        title: 'Lunch',
                        start: new Date(y, m, d+7, 12, 0),
                        end: new Date(y, m, d+7, 14, 0),
                        allDay: false,
                        className: 'event-red'
                    },
                    {
                        title: 'Nud-pro Launch',
                        start: new Date(y, m, d-2, 12, 0),
                        allDay: true,
                        className: 'event-azure'
                    },
                    {
                        title: 'Birthday Party',
                        start: new Date(y, m, d+1, 19, 0),
                        end: new Date(y, m, d+1, 22, 30),
                        allDay: false,
                        className: 'event-azure'
                    },
                    {
                        title: 'Click for Creative Tim',
                        start: new Date(y, m, 21),
                        end: new Date(y, m, 22),
                        url: 'http://www.creative-tim.com/',
                        className: 'event-orange'
                    },
                    {
                        title: 'Click for Google',
                        start: new Date(y, m, 21),
                        end: new Date(y, m, 22),
                        url: 'http://www.creative-tim.com/',
                        className: 'event-orange'
                    }
                ]
            });
        },
    }
}();