<x-app-layout>
    <!-- Breadcrumbs -->
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">{{ __('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Agendar</li>
            </ol>
        </nav>
    </x-slot>
    <!-- END Breadcrumbs -->

    <!-- Conteúdo -->
    <div class="container">
        <!-- Lista de especialidades -->
        <div class="row">
            <div class="col-sm-12">
                <label for="especialidade" class="form-label">Selecione a especialidade</label>
                <select id="especialidade" class="form-select">
                    <option value="" selected disabled>Selecione</option>
                    @foreach ($especialidades as $especialidade)
                        <option value="{{ $especialidade->especialidade_id }}">{{ $especialidade->nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- END Lista de especialidades -->
        
        <div class="row" style="padding-top: 2%">
            <!-- preloader -->
            <x-preloader></x-preloader>
            <!-- END preloader -->
        </div>

        <!-- Especialistas -->
        <div class="row js-especialistas"></div>
        <!-- END Especialistas -->

    </div>
    <!-- END Conteúdo -->

    <!-- Modal de marcar consulta -->
    <div class="modal fade" id="modal-agendar" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-agendamento" method="POST" action="{{ route('agendar.consulta.medicos') }}" class="row g-3">
                        <input type="hidden" name="specialty_id" id="especialidade-id">
                        <input type="hidden" name="specialty" id="especialidade-name">
                        <input type="hidden" name="professional_id" id="especialista-id">
                        <input type="hidden" name="professional" id="especialista-name">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="name" class="form-control" id="nome" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="source-id" class="form-label">Como conheceu?</label>
                            <select id="source-id" name="source_id" class="form-select">
                                <option value="" selected disabled>Selecione</option>
                                @foreach($origens as $origem)
                                    <option value="{{ $origem->origem_id }}">{{ $origem->nome_origem }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="birthdate" class="form-label">Data de Nascimento</label>
                            <input type="text" name="birthdate" class="form-control" id="birthdate" placeholder="{{ \Carbon\Carbon::now()->subYears(22)->format('d/m/Y') }}">
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" name="cpf" class="form-control" id="cpf" placeholder="999.999.999-99">
                        </div>
                        <div class="col-sm-12 js-agenda-disponivel hide">
                            <hr>
                            <label for="date-consult" class="form-label">Agenda disponível do especialista</label>
                            <select id="date-consult" name="dateconsult" class="form-select">
                                <option value="" selected disabled>Selecione</option>
                                @foreach($horarios as $horario)
                                    <option value="{{ $horario }}">{{ $horario }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-solicitar-horario">Solicitar Horários</button>
                    <button type="button" class="btn btn-success hide" id="btn-agendar">Agendar</button>
                    <div class="spinner-border hide" id="preload-modal" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal de marcar consulta -->

    @push('scripts-css')
        <link rel="stylesheet" href="{{ mix('/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ mix('/css/select2-bootstrap.min.css') }}">
    @endpush
    @push('scripts-js')
        <script src="{{ mix('/js/select2.min.js') }}" type="text/javascript" defer></script>
        <script src="{{ mix('/js/jquery.mask.min.js') }}" type="text/javascript" defer></script>

        {{-- Custom JS --}}
        @include('consulta.agendar-js')
    @endpush
</x-app-layout>