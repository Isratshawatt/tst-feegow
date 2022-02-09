<x-app-layout>
    <x-slot name="header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#">Home</a></li>
            </ol>
        </nav>
    </x-slot>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Especialidade</th>
                            <th>Especialista</th>
                            <th>Data/Hora</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consultas as $consulta)
                            <tr>
                                <td>{{ $consulta->specialty }}</td>
                                <td>{{ $consulta->professional }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $consulta->dateconsult)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <button class="btn btn-danger" data-id="{{ $consulta->id }}" id="cancelar-consulta">Cancelar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Nenhuma consulta marcada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts-js')
        {{-- Custom JS --}}
        @include('consulta.dashboard-js')
    @endpush
</x-app-layout>