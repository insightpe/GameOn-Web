$(function () {
  UiCanchaReservadaList.init();
});

var UiCanchaReservadaList = function () {
  return {
    calendar: null,
    init: function () {
      $("#campo_id").change(UiCanchaReservadaList.changeCampo);
      $("#deporte_id").change(UiCanchaReservadaList.changeDeporte);
      $("#campo_cancha_id").change(UiCanchaReservadaList.changeCancha);
      this.initFullCalendar();
    },
    changeDeporte: function () {
      var data = {
        campo_id: $("#campo_id").val(),
        deporte_id: $("#deporte_id").val(),
      }

      $.ajax({
        url: App.baseUrl + "get-list-canchas",
        type:'POST',
        dataType: "json",
        data: data,
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
            $("#campo_cancha_id").empty();
            var isFirst=true;
            data.forEach(row => {
              $("#campo_cancha_id").append(
                $("<option  " + (isFirst ? "selected" : "") + " value='" + row.campo_cancha_id + "'>").text(row.nombre)
              );
              isFirst=false;
            });

            UiCanchaReservadaList.calendar.fullCalendar( 'refetchEvents' );
          }
        }
      });
    },
    changeCancha: function () {
      UiCanchaReservadaList.calendar.fullCalendar( 'refetchEvents' );
    },
    changeCampo: function () {
      var data = {
        campo_id: $("#campo_id").val()
      }

      $.ajax({
        url: App.baseUrl + "canchareservada-get-list-deportes",
        type:'POST',
        dataType: "json",
        data: data,
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
            $("#deporte_id").empty();
            var isFirst=true;
            data.forEach(row => {
              $("#deporte_id").append(
                $("<option  " + (isFirst ? "selected" : "") + " value='" + row.deporte_id + "'>").text(row.nombre)
              );
              isFirst=false;
            });
            UiCanchaReservadaList.changeDeporte();
            //UiCanchaReservadaList.calendar.fullCalendar( 'refetchEvents' );
          }
        }
      });
    },
    initFullCalendar: function () {
      UiCanchaReservadaList.calendar = $('#fullCalendar');

      today = new Date();
      y = today.getFullYear();
      m = today.getMonth();
      d = today.getDate();

      UiCanchaReservadaList.calendar.fullCalendar({
        defaultView: "agendaWeek",
        locale: 'es',
        viewRender: function (view, element) {
          // We make sure that we activate the perfect scrollbar when the view isn't on Month
          if (view.name != 'month') {

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
        eventClick: function(calEvent, jsEvent, view) {
          Swal.fire({
            title: 'Ver Reserva',
            html: '<div class="form-group">' +
            '<b>Centro Deportivo: </b> ' + calEvent.allData.campo_nombre +
            '</div>' +
            '<div class="form-group">' +
            '<b>Cancha: </b> ' + calEvent.allData.cancha_nombre +
            '</div>' +
            '<div class="form-group">' +
            '<b>Reservador por: </b> ' + calEvent.allData.nombre + (calEvent.allData.nombre == null ? "" : " " + calEvent.allData.nombre)  +
            '</div>' +
            '<div class="form-group">' +
            '<b>Desde: </b> ' + calEvent.allData.fecha_desde +
            '</div>' +
            '<div class="form-group">' +
            '<b>Hasta: </b> ' + calEvent.allData.fecha_hasta +
            '</div>' +
            '<div class="form-group">' +
            '<b>Precio: </b> ' + calEvent.allData.precio +
            '</div>'
            ,
            showCancelButton: false,
            confirmButtonClass: 'btn btn-success',
            buttonsStyling: false
          }).then((result) => {
            UiCanchaReservadaList.calendar.fullCalendar('unselect');
          });
        },
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: function(start, end, timezone, callback) {
         
          $.ajax({
            url: App.baseUrl + "get-list-canchareservada",
            type:'POST',
            dataType: "json",
            data: {
              campo_id: $("#campo_id").val(),
              campo_cancha_id: $("#campo_cancha_id").val(),
              deporte_id: $("#deporte_id").val(),
              start: start.toJSON(),
              end: end.toJSON()
            },
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
                var events = [];
                data.forEach(item => {
                  events.push({
                    title: item.nombre + (item.apellido == null ? "" : + " " + item.apellido) + " - " + item.cancha_nombre,
                    start: item.fecha_desde,
                    end: item.fecha_hasta,
                    allDay: false,
                    allData: item
                  });
                });
                callback(events);
              }
            }
          });
        },
      });
    },
    add: function () {
      window.location = App.baseUrl + "nuevo-campo";
    },
    delete: function (id) {
      App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", this.execDelete, id);
    },
    execDelete: function (id) {
      $.ajax({
        url: App.baseUrl + "eliminar-campo/" + id,
        type: 'GET',
        dataType: "json",
        data: {},
        success: function (data) {
          if (!$.isEmptyObject(data.error)) {
            Swal.fire({
              title: "Error",
              html: data.error,
              buttonsStyling: false,
              confirmButtonClass: "btn btn-success",
              type: "error"
            });
          } else {
            UiCanchaReservadaList.dtCampo.ajax.reload();
          }
        }
      });
    }
  }
}();