$(function(){ 
    UiCampoCanchasDataEntry.init(); 
});

var UiCampoCanchasDataEntry = function() {
    return {
        dia:1,
        hora:0,
        init: function() {
            $("#btnNewCampoCancha").click(UiCampoCanchasDataEntry.add);
            $("#btnUpdate").click(UiCampoCanchasDataEntry.update);
            this.registerEventForActivateHourPrice();
            $("#campo_id").select2();
            if($("#id").val() != "0"){
              this.setValoresDiasHoras()
            }
        },
        setValoresDiasHoras: function(){
          $(".tblHorario th[scope='row']").each(function( index, value ) {
            $(this).parent().find("td input[type='checkbox']").each(function( indexDH, valueDH ) {
              var diahora = diahoras.find(dh => dh.dia == UiCampoCanchasDataEntry.dia && dh.hora == UiCampoCanchasDataEntry.hora);
              if(diahora != null){
                $(this).prop("checked", true);
                $(this).parent().parent().parent().parent().find("input[type='number']").val(diahora.precio);
                $(this).parent().parent().parent().parent().find("input[type='number']").prop("readonly", false);
              }
              UiCampoCanchasDataEntry.hora++;
            });
            UiCampoCanchasDataEntry.dia++;
            UiCampoCanchasDataEntry.hora=0;
          });
        },
        registerEventForActivateHourPrice: function(){
          $(".tblHorario th[scope='row']").each(function( index, value ) {
            $(this).parent().find("td input[type='checkbox']").click(function(){
              $(this).parent().parent().parent().parent().find("input[type='number']").prop("readonly", !$(this).prop("checked"));
              if(!$(this).prop("checked")){
                $(this).parent().parent().parent().parent().find("input[type='number']").val("");
              }
            });
          });
        },
        add: function() {
            var data = $("#frmCampoCancha").serializeFormJSON();
            $.each($("input[name='txthourday']"), function(i, el) {
              data["txthourday_"+(i+1)] = $(el).val();
            });

            $.ajax({
                url: App.baseUrl + "agregar-campocancha",
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
          var data = $("#frmCampoCancha").serializeFormJSON();
          $.each($("input[name='txthourday']"), function(i, el) {
            data["txthourday_"+(i+1)] = $(el).val();
          });

          $.ajax({
              url: App.baseUrl + "actualizar-campocancha",
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