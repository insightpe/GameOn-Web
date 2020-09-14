$(function(){ 
    UiPromocionDataEntry.init(); 
});

var UiPromocionDataEntry = function() {
    return {
        init: function() {
            $("#btnNewPromocion").click(UiPromocionDataEntry.add);
            $("#btnUpdate").click(UiPromocionDataEntry.update);
        },
        add: function() {
          var data = new FormData();
          var arr_frmPromocion = $("#frmPromocion").serializeArray();

          for(var xI=0;xI<arr_frmPromocion.length;xI++){
            data.append(arr_frmPromocion[xI].name, arr_frmPromocion[xI].value);
          }

          $.each($('#userfile')[0].files, function(i, file) {
            data.append('userfile', file);
          });

          $.ajax({
            url: App.baseUrl + "agregar-promocion",
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
                window.location = data.redirect;
              }
            }
          });
        },
        update: function(){
          var data = new FormData();
          var arr_frmPromocion = $("#frmPromocion").serializeArray();

          for(var xI=0;xI<arr_frmPromocion.length;xI++){
            data.append(arr_frmPromocion[xI].name, arr_frmPromocion[xI].value);
          }

          $.each($('#userfile')[0].files, function(i, file) {
            data.append('userfile', file);
          });

          $.ajax({
            url: App.baseUrl + "actualizar-promocion",
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
                window.location = data.redirect;
              }
            }
          });
        },
    }
}();