$(function(){
    'use strict'

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img1').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
        if (input.files && input.files[1]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img2').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[1]);
        }
        if (input.files && input.files[2]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img3').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[2]);
        }
        if (input.files && input.files[3]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.img4').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[3]);
        }
    }
    $(document).on('change', '#check_all', function () {
        $('input:checkbox').prop('checked', $(this).prop('checked'));
        let check_box = $('.box').length;
    });
    $(document).on('change', '.box', function () {
        if ($(this).prop('checked') == false) {
            $('#check_all').prop('checked', false)
        }
        if ($('.box:checked').length == $('.box').length) {
            $('#check_all').prop('checked', true)
        }
    })

    // create ===========================
    $('.add').click(function () {
        $('#modal_add').modal('show');
    });

    
    $(document).on('click','#logout',function(){
        Swal.fire({
            title:'Vous souhaitez vous déconecter ?',
            icon:'question',
            showCancelButton: true,
            cancelButtonText:'Non',
            confirmButtonText: 'Oui , Me déconnecter'
        }).then((result)=>{
            if(result.value){
                $.ajax({
                    url:'/src/model/admin/logout/logout.php',
                    method:'POST',
                    data:{
                        log_out_admin:''
                    },
                    success:function(data){
                        if (data == 'success') {
                            Swal.fire('Bien joué','Déconnection réussi','success')
                            .then((result)=>{
                                if(result.value){
                                    window.location.href="./auth"
                                }
                            })
                        }
                    }
                })
            }
        })
    })
});