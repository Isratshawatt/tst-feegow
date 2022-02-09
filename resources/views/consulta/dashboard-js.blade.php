<x-js.sweet-alert></x-js.sweet-alert> <!-- Component para utilizar o sweetAlert -->

<script type="text/javascript">
    $("#cancelar-consulta").on("click", function() {
        let agendamentoId = $(this).attr('data-id');
        openConfirm({
                title: 'Atenção!',
                type: 'question',
                html: 'Tem certeza que deseja cancelar esse agendamento?',
            }, function (response) {
                if (response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('cancelar.agendamento') }}",
                        type: 'POST',
                        data: {"agendamentoId": agendamentoId},
                        dataType: 'json',
                        success: function (response) {
                            sendToast(
                                'success',
                                '<h5>Pronto!</h5> O seu agendamento foi removido.',
                            );
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        },
                        error: function (error) {
                            sendToast(
                                'error',
                                '<h5>Ops!</h5> Não foi possível remover o agendamento.',
                            );
                        }
                    });
                }
            }
        );
    });
</script>