<script src="{{ mix('/js/sweetalert2.all.min.js') }}" defer></script>

<script type="text/javascript" defer>
    /* Função responsavel pela confirmação (Sweetalert2) */
    function openConfirm(data, callback = false) {
        Swal.fire({
            title                 : (data.title) ? data.title                          : 'Confirmação',
            html                  : (data.html) ? data.html                            : 'Descrição',
            icon                  : (data.type) ? data.type                            : 'question',
            confirmButtonColor    : (data.confirmButtonColor) ? data.confirmButtonColor: 'btn-success',
            confirmButtonText     : (data.confirmButtonText) ? data.confirmButtonText  : 'Confirmar',
            showCancelButton      : (data.showCancelButton) ? false                    : true,
            cancelButtonColor     : (data.cancelButtonColor) ? data.cancelButtonColor  : 'btn-light',
            cancelButtonText      : (data.cancelButtonText) ? data.cancelButtonText    : 'Cancelar',
            footer                : (data.footer) ? data.footer                        : false,
            showCloseButton       : (data.showCloseButtom) ? data.showCloseButtom      : true,
            showConfirmButton     : (data.showConfirmButton != undefined) ? data.showConfirmButton : true,
            keydownListenerCapture: true,
        }).then((result) => {
            if (callback != false) {
                if (result.value) {
                    callback(true);
                } else {
                    callback(false);
                }
            }
        });
    }

    /* Emite um toast para informações */
    function sendToast(icon, title) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: icon,
            title: title
        })
    }
</script>