$(function(){ 
    UiDeporteDataEntry.init(); 
});

var UiDeporteDataEntry = function() {
    return {
        init: function() {
            $("#btnNewDeporte").click(UiDeporteDataEntry.add);
            $("#btnUpdate").click(UiDeporteDataEntry.update);
        },
        add: function() {
            var data = $("#frmDeporte").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "agregar-deporte",
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
        update: function(){
          var data = $("#frmDeporte").serializeFormJSON();

          $.ajax({
              url: App.baseUrl + "actualizar-deporte",
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