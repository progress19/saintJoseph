
$(document).ready(function() {

/* delete register */

$('.delReg').click(function() {
    if (confirm('Está seguro de eliminar el registro ?')) {
        return true;
    }
        return false;
}); 

$("#reset_pwd").click(function (e) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
        }
    })

    $.ajax({
        type: "get",
        url: '../reset-pwd',
        data: {
            id: $("#userID").val(), // This could be a hidden field whit the value of user id
            new_password: $("#newPassword").val()
        },
        success: function(data){
            //$('#').html(data);
            //alert(data);
            $("#modal_reset").modal('hide');
            toast('Contraseña modificada!');
        }
    });

});


$('#new_pwd').click(function() {

    var current_pwd = $("#current_pwd").val();
    $.ajax({
        url: '../admin/check-pwd',
        type: 'get',
        data: {current_pwd: current_pwd},
        success:function(resp) {
           
           if (resp=='false') {
           
            $('#chkPwd').html('<font color="red">La áctual contraseña es incorrecta.</font>');
           
           } else if (resp=='true') {

            $('#chkPwd').html('<font color="green">La áctual contraseña es correcta.</font>');
           
           }

        },error:function(){
            alert('Error');
        }
    });
    
});

});


$("#frmPwdAdmin").validate({
    event: "blur",
    rules: {
        'current_pwd': "required",
        'new_pwd': "required",
        'confirm_pwd': {
            equalTo: "#new_pwd"
         },

    },
    messages: {
        'current_pwd': "Por favor ingrese contraseña actual",
        'new_pwd': "Ingrese nueva contraseña",
        'confirm_pwd': "Las contraseñas no coinciden."},
    debug: true,errorElement: "label",

    submitHandler: function(form){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })
        
        $.ajax({

            url:"../admin/update-pwd",
            method: "post",
            data: $('#frmPwdAdmin').serialize(),
            success: function(data){
                
            if (data='1') {var text = 'Contraseña actualizada correctamente!'}
            if (data='0') {var text = 'La contraseña actual es incorrecta.'}

             window.location.href = "../admin/dashboard";
                
            }
        });
    }
});


/* Actividad add_actividad */

$("#add_actividad").validate({
    event: "blur",
    rules: {
        'nombre': "required",
        'precio_a': "required",
        'imagen': "required",
        },
    messages: {
        'nombre': "Por favor ingresá un nombre.",
        'precio_a': "Por favor ingresá un valor.",
        'imagen': "Por favor ingresá una imagen.",
},
    debug: true,errorElement: "label",

    submitHandler: function(form){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })

        $('#add_actividad')[0].submit();

    }
});

/* Actividad edit_actividad */

$("#edit_paquete").validate({
    event: "blur",
    rules: {
        'nombre': "required",
        'precio': "required",
           },
    messages: {
        'nombre': "Por favor ingrese nombre.",
        'precio': "Por favor ingrese un valor.",
},
    debug: true,errorElement: "label",

    submitHandler: function(form){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })

        $('#edit_paquete')[0].submit();

    }
});



/* Usuarios add_usuario */

$("#add_usuario").validate({
    event: "blur",
    rules: {
        'name': "required",
        'email': "required",
        'password': "required",
                 },
    messages: {
        'name': "Por favor ingrese nombre.",
        'email': "Por favor ingrese un valor.",
        'password': "Por favor ingrese un valor.",
},
    debug: true,errorElement: "label",

    submitHandler: function(form){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })

        $('#add_usuario')[0].submit();

    }
});

/* Usuarios edit_usuario */

$("#edit_usuario").validate({
    event: "blur",
    rules: {
        'name': "required",
        'email': "required",
        'password': "required",
           },
    messages: {
        'name': "Por favor ingrese nombre.",
        'email': "Por favor ingrese un valor.",
        'password': "Por favor ingrese un valor.",
},
    debug: true,errorElement: "label",

    submitHandler: function(form){
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        })

        $('#edit_usuario')[0].submit();

    }
});
