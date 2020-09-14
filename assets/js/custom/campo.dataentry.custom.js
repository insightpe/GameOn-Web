$(function(){ 
    UiCampoDataEntry.init(); 
});

var UiCampoDataEntry = function() {
    return {
        posDefecto: null,
        map: null,
        markerCampo: null,
        autocomplete: null,
        place: null,
        dtCampoFotos: null,
        firstLoad:true,
        typeSave:null,
        init: function() {
          $("#btnNewCampo").click(UiCampoDataEntry.add);
          $("#btnUpdate").click(UiCampoDataEntry.update);
          $("#btnGrabarImagen").click(UiCampoDataEntry.saveImagen);
          $("#campo_departamentos").change(UiCampoDataEntry.onChangeDepartamentos);
          $("#campo_provincias").change(UiCampoDataEntry.onChangePronvincias);
          google.maps.event.addDomListener(window, 'load', UiCampoDataEntry.loadMap);
          this.loadDataTable();
          
        },
        onChangeDepartamentos: function(){
          var data = {
            departamento_id: $("#campo_departamentos").val()
          }
          $.ajax({
            url: App.baseUrl + "get-by-pronvincias",
            type:'POST',
            dataType: "json",
            data: data,
            success: function(data) {
              $("#campo_provincias").empty();
              var isFirst=true;
              $("#campo_provincias").append(
                $("<option selected value=''>").text("Seleccione uno...")
              );
              data.forEach(row => {
                $("#campo_provincias").append(
                  $("<option value='" + row.id + "'>").text(row.name)
                );
              });
            }
          });
        },

        onChangePronvincias: function(){
          var data = {
            provincia_id: $("#campo_provincias").val()
          }
          $.ajax({
            url: App.baseUrl + "get-by-distritos",
            type:'POST',
            dataType: "json",
            data: data,
            success: function(data) {
              $("#campo_distritos").empty();
              var isFirst=true;
              $("#campo_distritos").append(
                $("<option selected value=''>").text("Seleccione uno...")
              );
              data.forEach(row => {
                $("#campo_distritos").append(
                  $("<option  value='" + row.id + "'>").text(row.name)
                );
              });
            }
          });
        },

        saveImagen: function(){
          var data = new FormData();
          var arr_frmPromocion = $("#frmCampoImagen").serializeArray();

          for(var xI=0;xI<arr_frmPromocion.length;xI++){
            data.append(arr_frmPromocion[xI].name, arr_frmPromocion[xI].value);
          }

          $.each($('#userfile')[0].files, function(i, file) {
            data.append('userfile', file);
          });

          var t = App.baseUrl + ($("#campo_imagenes_id").val() == "0" ? "agregar-campoimagen" : "actualizar-campoimagen");
          $.ajax({
              url: App.baseUrl + ($("#campo_imagenes_id").val() == "0" ? "agregar-campoimagen" : "actualizar-campoimagen"),
              type:'POST',
              method: 'POST',
              dataType: "json",
              data: data,
              cache: false,
              contentType: false,
              processData: false,
              success: function(data) {
                  console.log(data);
                if(!$.isEmptyObject(data.error)){
                  Swal.fire({
                      title: "Error",
                      html: data.error,
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-success",
                      type: "error"
                  });
                }else{
                  UiCampoDataEntry.dtCampoFotos.ajax.url(App.baseUrl + "get-list-detallefotos?campo_id=" + $("#campo_id").val()).load();
                  $('#myModal').modal('hide');
                }
              }
          });
        },
        execDeleteImagen: function(id){
          $.ajax({
            url: App.baseUrl + "eliminar-campoimagen/" + id,
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
                UiCampoDataEntry.dtCampoFotos.ajax.url(App.baseUrl + "get-list-detallefotos?campo_id=" + $("#campo_id").val()).load();
              }
            }
          });
        },
        eliminarImagen: function(id){
          App.confirm("Estás seguro?", "Vas a eliminar un registro!", "warning", "Si, eliminar!", UiCampoDataEntry.execDeleteImagen, id);
          
        },
        loadDataTable: function (){
          this.dtCampoFotos = $('#dt-campo-fotos').DataTable({
            buttons: [  
                {
                  text: '<i class="fa fa-plus"></i> Agregar Foto',
                  className:"btn btn-primary pull-right",
                  action: function ( e, dt, node, config ) {
                    if($("#campo_id").val()=="0"){
                      UiCampoDataEntry.typeSave = 1;
                      UiCampoDataEntry.add();
                    }else{
                      $('#accion').val('agregar');
                      $('#myModal').modal('show');
                      $("#previewFile").removeClass("fileinput-new");
                      $("#previewFile").removeClass("fileinput-exists");
                      $("#id_campo").val($("#campo_id").val());
                      $("#previewFile").addClass("fileinput-new");
                      if($("#imgImagenEdit").length > 0){
                        $("#imgImagenEdit").attr("src", "");
                      }else{
                        $("#divThuExists").append($("<img id='imgImagenEdit' src=''>"));
                      }
                      $("#campo_imagenes_id").val(0);
                      $("#url").val("");
                      $("#activado").prop("checked", false);
                      $("#userfile").val("");
                    }   
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
            processing: false,
            serverSide: false,
            ajax: {
              url: App.baseUrl + "get-list-detallefotos?campo_id=" + $("#campo_id").val(),
              type: "POST",
            },
            //scrollX: true,
            //autoWidth: false,
            "columns": [
              
 
              {"data": "defecto", width:"20%",  className : "text-center",
                "render": function (data, type, full, meta) {
                  return type === 'display' ?
                    full.defecto == "1" ? "Sí": "No":
                    data;
                },
                "orderable": false,
              },

              {"data": "imagen", width:"15%",
                "render": function (data, type, full, meta) {
                  return type === 'display' ?
                    "<a href='" + App.baseUrl + "assets/img/campos_img/" + full.imagen + "' target='_blank'>Ver Imagen</a>":
                    data;
                },
                "orderable": false,
              },
              {"data": "external_url", width:"55%",
                "render": function (data, type, full, meta) {
                  return type === 'display' ?
                    "<a href='" + full.external_url + "' target='_blank'>" + full.external_url + "</a>":
                    data;
                },
                "orderable": false,
              },   
              {"data": "campo_imagenes_id", "searchable": false, width:"10%",  className : "text-center",
                "render": function (data, type, full, meta) {
                  return type === 'display' ?
                      '<a row-id="' + full.campo_imagenes_id + '"'+
                      ' class="btn btn-round btn-warning btn-icon btn-sm" data-toggle="tooltip" title="Editar" onclick="UiCampoDataEntry.editarImagen(' + full.campo_imagenes_id + ')"><i class="fas fa-pencil-alt"></i></a> '  + 
                      '<a row-id="' + full.campo_imagenes_id + '"'+ 
                      ' class="btn btn-round btn-danger btn-icon btn-sm" data-toggle="tooltip" title="Eliminar" onclick="UiCampoDataEntry.eliminarImagen('+full.campo_imagenes_id + ');"><i class="fas fa-times"></i></a> ' :
                    data;
                },
                "orderable": false,
              },
              
            ],
            pageLength: 10,
            lengthMenu: [[10, 20, 50], [10, 20, 50]]
        });
        },
        editarImagen: function(campo_imagenes_id){
          $.ajax({
            url: App.baseUrl + "editar-campoimagen/" + campo_imagenes_id,
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
                $('#myModal').modal('show');
                $("#previewFile").removeClass("fileinput-new");
                $("#previewFile").removeClass("fileinput-exists");
                $("#id_campo").val($("#campo_id").val());
                $("#previewFile").addClass(data.imagen == "" ? "fileinput-new" : "fileinput-exists");
                if($("#imgImagenEdit").length > 0){
                  $("#imgImagenEdit").attr("src", App.baseUrl + "assets/img/campos_img/" + data.imagen);
                }else{
                  $("#divThuExists").append($("<img id='imgImagenEdit' src='" + App.baseUrl + "assets/img/campos_img/" + data.imagen + "'>"));
                }
                
                $("#campo_imagenes_id").val(campo_imagenes_id);
                $("#url").val(data.external_url);
                $("#activado").prop("checked", data.defecto == 1);
              }
            }
          }); 
        },
        loadMap: function(){
          UiCampoDataEntry.posDefecto = { lat: 12.1281536, lng: -76.0002564 };
          UiCampoDataEntry.map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: UiCampoDataEntry.posDefecto
          });

          google.maps.event.addListener(UiCampoDataEntry.map, 'click', function(event) {
            UiCampoDataEntry.markerCampo.setPosition(event.latLng);

            var geocoder = new google.maps.Geocoder;

            geocoder.geocode({'location': event.latLng}, function(results, status) {
              if (status !== 'OK') {
                window.alert('Geocoder failed due to: ' + status);
                return;
              }

              $("#ubicacion").val(results[0].address_components.find(ac => ac.types.includes("locality")).long_name);
        
            });
          });

          var input = document.getElementById('pac-input');

          UiCampoDataEntry.autocomplete = new google.maps.places.Autocomplete(input);

          UiCampoDataEntry.autocomplete.bindTo('bounds', UiCampoDataEntry.map);

          // Specify just the place data fields that you need.
          UiCampoDataEntry.autocomplete.setFields(['place_id', 'geometry', 'name', 'formatted_address']);

          UiCampoDataEntry.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

          var geocoder = new google.maps.Geocoder;

          if($("#campo_id").val() == "0"){
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(UiCampoDataEntry.showPosition);
            }else{
              UiCampoDataEntry.showPosition(null);
            }
          }else{
            var pos = {
              coords: {
                latitude: Number($("#lat").val()),
                longitude: Number($("#lng").val())
              }
            }
            UiCampoDataEntry.showPosition(pos);
          }

          UiCampoDataEntry.autocomplete.addListener('place_changed', function() {
    
            UiCampoDataEntry.place  = UiCampoDataEntry.autocomplete.getPlace();
        
            if (!UiCampoDataEntry.place.place_id) {
              return;
            }
            geocoder.geocode({'placeId': UiCampoDataEntry.place.place_id}, function(results, status) {
              if (status !== 'OK') {
                window.alert('Geocoder failed due to: ' + status);
                return;
              }

              $("#ubicacion").val(results[0].address_components[1].long_name);
        
              UiCampoDataEntry.map.setZoom(15);
              UiCampoDataEntry.map.setCenter(results[0].geometry.location);
        
              // Set the position of the marker using the place ID and location.
              UiCampoDataEntry.markerCampo.setPosition(results[0].geometry.location);
              /*UiCampoDataEntry.markerCampo.setPlace(
                  {placeId: UiCampoDataEntry.place.place_id, location: results[0].geometry.location});
        */
              UiCampoDataEntry.markerCampo.setVisible(true);
            });
          });
        },

        showPosition: function(position){
          if(position === null){
            UiCampoDataEntry.addMarker(UiCampoDataEntry.posDefecto, UiCampoDataEntry.map);
          }else{
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            UiCampoDataEntry.map.setCenter(pos);
            UiCampoDataEntry.addMarker(pos, UiCampoDataEntry.map);
          }
          if(UiCampoDataEntry.firstLoad && $("#campo_id").val() != "0"){ 
            UiCampoDataEntry.firstLoad = false;
            return; 
          }
          var geocoder = new google.maps.Geocoder;

          geocoder.geocode({'location': pos}, function(results, status) {
            if (status !== 'OK') {
              window.alert('Geocoder failed due to: ' + status);
              return;
            }

            $("#ubicacion").val(results[0].address_components.find(ac => ac.types.includes("locality")).long_name);
      
          });
          
        },

        addMarker: function(location, map) {
          UiCampoDataEntry.markerCampo = new google.maps.Marker({
            position: location,
            map:  map,
            draggable:true,
          });

          google.maps.event.addListener(UiCampoDataEntry.markerCampo, 'dragend', function(event){
            var geocoder = new google.maps.Geocoder;

            geocoder.geocode({'location': event.latLng}, function(results, status) {
              if (status !== 'OK') {
                window.alert('Geocoder failed due to: ' + status);
                return;
              }

              $("#ubicacion").val(results[0].address_components.find(ac => ac.types.includes("locality")).long_name);
        
            });
          });
        },

        add: function() {
          $("#lat").val(UiCampoDataEntry.markerCampo.position.lat());
          $("#lng").val(UiCampoDataEntry.markerCampo.position.lng());

          var data = $("#frmCampo").serializeFormJSON();
          
          $.ajax({
              url: App.baseUrl + ($("#campo_id").val() == "0" ? "agregar-campo" : "actualizar-campo"),
              type:'POST',
              dataType: "json",
              data: data,
              success: function(data) {
                  console.log(data);
                if(!$.isEmptyObject(data.error)){
                  Swal.fire({
                      title: "Error",
                      html: data.error,
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-success",
                      type: "error"
                  });
                }else{
                  debugger;
                  if(UiCampoDataEntry.typeSave == "1"){
                    $("#campo_id").val(data.id);
                    $('#accion').val('agregar');
                    $('#myModal').modal('show');
                    $("#previewFile").removeClass("fileinput-new");
                    $("#previewFile").removeClass("fileinput-exists");
                    $("#id_campo").val($("#campo_id").val());
                    $("#previewFile").addClass("fileinput-new");
                    if($("#imgImagenEdit").length > 0){
                      $("#imgImagenEdit").attr("src", "");
                    }else{
                      $("#divThuExists").append($("<img id='imgImagenEdit' src=''>"));
                    }
                    $("#campo_imagenes_id").val(0);
                    $("#url").val("");
                    $("#activado").prop("checked", false);
                    $("#userfile").val("");
                    UiCampoDataEntry.typeSave = 0;
                  }else{
                    window.location = data.redirect;
                  }
                }
              }
          });
        },
        update: function(){
          var data = $("#frmCampo").serializeFormJSON();

          $.ajax({
              url: App.baseUrl + "actualizar-campo",
              type:'POST',
              dataType: "json",
              data: data,
              success: function(data) {
                  console.log(data);
                if(!$.isEmptyObject(data.error)){
                  Swal.fire({
                      title: "Error",
                      html: data.error,
                      buttonsStyling: false,
                      confirmButtonClass: "btn btn-success",
                      type: "error"
                  });
                }else{
                  window.location = data.redirect;
                }
              }
          });
        },
    }
}();