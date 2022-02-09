<x-js.init-select2></x-js.init-select2> <!-- Component para inicializar select2 -->
<x-js.sweet-alert></x-js.sweet-alert> <!-- Component para utilizar o sweetAlert -->

<script type="text/javascript">
    $(function() {
        /* Inicializando select2 */
        fnInitSelect2('especialidade');
        fnInitSelect2('source-id');

        /* Atribuindo mascara ao campos */
        $('#birthdate').mask('99/99/9999');
        $('#cpf').mask('999.999.999-99');
    });

    /* Ao trocar de especialidade, carrega os especialistas */
    $("#especialidade").on("change", function() {
        let especialidadeId = $(this).val();
        let route = "{{ url('/medicos/especialidade') }}/" + especialidadeId;
        let imagemEspecialista = "{{ asset('/images/especialista.png') }}";
        $('.js-preloader').removeClass('hide'); /* Exibindo preloader */
        $(".js-especialistas").find('div').remove(); /* Removendo os "antigos" */

        /* Mensagem para informar que os especialistas estão sendo carregados */
        sendToast(
            'info',
            '<h5>Aguarde!</h5> Carregando os especialistas.',
        );

        /* Enviando a requisição */
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: route,
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                let especialistasAppend = '';
                $.each(response, function(index, especialista) {
                    /* Variáveis que precisam de tratamento (Algumas estão nullas) */
                    let tratamento = (especialista.tratamento == null) ? 'Dr. ' : especialista.tratamento;
                    let conselho = (especialista.conselho == null) ? '' : especialista.conselho;
                    let documentoConselho = (especialista.documento_conselho == null) ? '' : especialista.documento_conselho;

                    /* Acrescentando na variável os dados para fazer um append posteriormente */
                    especialistasAppend = especialistasAppend + 
                    `
                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <div class="card mb-3">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <img src="${imagemEspecialista}" class="img-fluid rounded-start" alt="Especialista">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h6 class="card-title">${tratamento} ${especialista.nome}</h6>
                                            <p>${conselho} ${documentoConselho}</p>
                                            <button type="button" class="btn btn-success js-agendar-especialista"
                                                data-especialista_nome="${tratamento} ${especialista.nome}" data-especialista_id="${especialista.profissional_id}">
                                                Agendar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $(".js-especialistas").append(especialistasAppend);
                $('.js-preloader').addClass('hide'); /* escondendo o preloader */
            },
            error: function (error) {
                sendToast(
                    'error',
                    '<h5>Ops!</h5> Não foi possível carregar os especialistas.',
                );
                $('.js-preloader').addClass('hide'); /* escondendo o preloader */
            }
        });

        
    });

    /* Ao solicitar horário exibe os campos de horários */
    $("#btn-solicitar-horario").on("click", function() {
        formContemErros = validandoForm();
        if (formContemErros == true) {
            sendToast(
                'info',
                '<h5>Atenção!</h5> Preencha o formulário para solicitar os horários do especialista.',
            );
            return;
        }
        $("#btn-agendar").removeClass('hide');
        $("#btn-solicitar-horario").addClass('hide');
        $(".js-agenda-disponivel").removeClass('hide');
    });

    /* Valida o form de agendar consulta */
    function validandoForm(etapa = null) {
        var formContemErros = false;

        if ($("#nome").val() == "") {
            formContemErros = true;
            console.log('1');
        }

        if ($("#source-id").val() == undefined) {
            formContemErros = true;
            console.log('2');
        }

        if ($("#birthdate").val() == "") {
            formContemErros = true;
            console.log('3');
        }

        if ($("#cpf").val() == "") {
            formContemErros = true;
            console.log('4');
        }

        if (etapa == 'full') {
            if ($("#date-consult").val() == undefined) {
                formContemErros = true;
                console.log('6');
            }
        }
        
        return formContemErros;
    }

    /* Ao clicar no botão agendar, confirma o agendamento no banco */
    $("#btn-agendar").on("click", function() {
        let urlRedirecionamento = "{{ route('dashboard') }}";
        formContemErros = validandoForm('full');
        if (formContemErros == true) {
            sendToast(
                'info',
                '<h5>Atenção!</h5> Preencha o formulário para confirmar o agendamento.',
            );
            return;
        }

        /* Mensagem para informar que os especialistas estão sendo carregados */
        sendToast(
            'info',
            '<h5>Aguarde!</h5> Confirmando seu agendamento.',
        );

        $("#btn-agendar").addClass('hide');
        $("#preload-modal").removeClass('hide');

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $.ajax({
            url: $('#form-agendamento').attr('action'),
            type: $('#form-agendamento').attr('method'),
            dataType: 'json',
            data: $('#form-agendamento').serialize(),
            success: function (response) {
                sendToast(
                    'success',
                    '<h5>Pronto!</h5> O seu agendamento foi confirmado.',
                );
                setTimeout(() => {
                    window.location.replace(urlRedirecionamento)
                }, 3000);
                
            },
            error: function (response) {
                sendToast(
                    'error',
                    '<h5>Ops!</h5> Algo aconteceu e não foi possível confirmar seu agendamento.',
                );
            }
        });
    });

    /* Abrindo o modal para agendar */
    $("body").on("click", ".js-agendar-especialista", function() {
        let nomeEspecialista = $(this).attr("data-especialista_nome");
        let idEspecialista = $(this).attr("data-especialista_id");

        $("#especialidade-id").val($("#especialidade").val());
        $("#especialidade-name").val($("#especialidade option:selected").text());
        
        $("#especialista-name").val(nomeEspecialista);
        $("#especialista-id").val(idEspecialista);

        /* Abrindo o modal */
        $('#modal-agendar').modal("show");
    });
   
    /* Ao fechar o modal, os dados são alterados para o valor default */
    $('#modal-agendar').on('hidden.bs.modal', function () {
        $("#btn-agendar").addClass('hide');
        $("#btn-solicitar-horario").removeClass('hide');
        $("#preload-modal").addClass('hide');
        $(".js-agenda-disponivel").addClass('hide');

        $("#especialidade-id").val("");
        $("#especialidade-name").val("");
        
        $("#especialista-name").val("");
        $("#especialista-id").val("");

        $("#source-id").val("");
        $("#source-id").select2("destroy");
        fnInitSelect2('source-id');

        $("#birthdate").val("");
        $("#cpf").val("");
        $("#dateconsult").val("");
    });

</script>
