
(function ($) {
    "use strict";
    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');
    $('.validate-form').on('submit',function(e){
        e.preventDefault();
        for(var i=0; i<input.length; i++) {
            if(validate(input[i]) == false){
                showValidate(input[i]);
                return false;
            }
        }
        let email = $('#email').val();
        let pass = $('#pass').val();
        $.ajax({
            url: '/src/model/admin/auth/auth.php',
            method : 'POST',
            dataType:'json',
            data: 
            { 
                submit_admin_login : '',
                email : email ,
                password : pass
                
            },
            beforeSend:function () {
                $('.loader').show();
            },
            success:function(data){
            
                if(data.success == 'success')
                {
                    function succes(text) {
                        let error = '<div class="alert text-center alert-success" role="alert">';
                        error += '<strong> ' + text + ' </strong>';
                        error += '</div >';
                        return error
                    }

                    let reponse = succes('connexion réussi');
                    $('#reponse').html(reponse);
                    $('.loader').hide();
                    Swal.fire({
                        title:'Bien joué',
                        text:'Connexion réussi',
                        icon:'success',
                        confirmButtonText:'Poursuivre'
                    }).then((result)=>{
                        if(result.value){
                            window.location.href='./'
                        }
                    });

                }else{
                    function error(data) {
                        let error = '<div class="alert text-center" role="alert">';
                        error += '<strong> ' + data + ' </strong>';
                        error += '</div >';
                        return error
                    }
                    let reponse = error(data.error);
                    $('#reponse').html(reponse);
                    Swal.fire('Oups !',reponse,'warning');
                    $('.loader').hide();
                }
            }
        })
    });


    $('.validate-form .input100').each(function(){
        $(this).focus(function(){
           hideValidate(this);
        });
    });

    function validate (input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }
    
    

})(jQuery);