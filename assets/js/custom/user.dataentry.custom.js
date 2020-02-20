$(function(){ 
    UiUserDataEntry.init(); 
});

var UiUserDataEntry = function() {
    return {
        init: function() {
            $("#btnNewUser").click(UiUserDataEntry.add);
            $("#update_user").click(UiUserDataEntry.update);
            $("#change_pass").click(UiUserDataEntry.changePass);
            $("#btnUpdateProfile").click(UiUserDataEntry.updateProfile);
            $("#btnUpdateSecurity").click(UiUserDataEntry.updateSecurity);
        },
        add: function() {
            /*var data = {
                user_name: $("#user_name").val(),
                user_email:  $("#user_email").val(),
                user_pass:  $("#user_pass").val(),
                user_confirm_pass:  $("#user_confirm_pass").val(),
                user_role:  $("#user_role").val(),
                user_status:  $("#user_status").val(),
            };*/
            var data = $("#frmUser").serializeFormJSON();
            $.ajax({
                url: App.baseUrl + "agregar-usuario",
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
            /*var data = {
                user_name: $("#user_name").val(),
                user_role:  $("#user_role").val(),
                user_status:  $("#user_status").val(),
            };*/
            var data = $("#frmUser").serializeFormJSON();

            $.ajax({
                url: App.baseUrl + "actualizar-usuario",
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
        changePass: function(){
            /*var data = {
                user_pass: $("#user_pass").val(),
                user_confirm_pass:  $("#user_confirm_pass").val(),
                id:  $("#id").val(),
            };*/
            var data = $("#frmUpdatePass").serializeFormJSON();
            $.ajax({
                url: App.baseUrl + "actualizar-pass",
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
        updateProfile: function(){
          var data = new FormData();
          var arr_frmUpdateProfile = $("#frmUpdateProfile").serializeArray();

          for(var xI=0;xI<arr_frmUpdateProfile.length;xI++){
            data.append(arr_frmUpdateProfile[xI].name, arr_frmUpdateProfile[xI].value);
          }

          $.each($('#userfile')[0].files, function(i, file) {
            data.append('userfile', file);
          });

          $.ajax({
              url: App.baseUrl + "actualizar-perfil",
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
                  Swal.fire({
                    title: "Satisfactorio",
                    html: "La datos fueron actualizados.",
                    buttonsStyling: false,
                    confirmButtonClass: "btn btn-success",
                    type: "success"
                  }).then(function(result){
                    window.location = data.redirect;
                  });
                }
              }
          });
        },
        updateSecurity: function(){
          /*var data = {
            user_old_pass: $("#user_pass").val(),
            user_pass:  $("#user_new_pass").val(),
            user_confirm_pass:  $("#user_confirm_new_pass").val(),
          };*/
          var data = $("#frmUpdatePassProfile").serializeFormJSON();

          $.ajax({
              url: App.baseUrl + "actualizar-pass-perfil",
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
                  Swal.fire({
                    title: "Satisfactorio",
                    html: "La datos fueron actualizados.",
                    buttonsStyling: false,
                    confirmButtonClass: "btn btn-success",
                    type: "success"
                  }).then(function(result){
                    window.location = data.redirect;
                  });
                }
              }
          });
        }
    }
}();