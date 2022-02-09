<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ConsultaController extends Controller
{
    /* token da API */
    protected $token;

    public function __construct()
    {
        $this->token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJmZWVnb3ciLCJhdWQiOiJwdWJsaWNhcGkiLCJpYXQiOjE2NDQyNDAzODQsImxpY2Vuc2VJRCI6IjEwNSJ9._v3HJr5GUYAc14WW6HDxM5BlxAl-1KJeaqq2OfG67sM';
    }
    /**
     * Carrega o painel de controle de consulta
     *
     * @return void
     */
    public function dashboard()
    {
        $consultas = [];
        if (!Cache::has('ch-minhas-consultas')) {
            $consultas = Consulta::buscarConsultasCliente();
            /* Nesse caso, podemos deixar o cache com valor alto porque sempre que fazer uma nova consulta ou cancelar o cache será apagado */
            Cache::put('ch-minhas-consultas', $consultas, 9999999999999999999);
        } else {
            $consultas = Cache::get('ch-minhas-consultas');
        }
        return view('consulta.dashboard', compact('consultas'));
    }

    /**
     * Carrega a view para agendar uma consulta através da especialidade selecionada
     *
     * @return void
     */
    public function agendarConsulta()
    {
        $especialidades = self::buscaEspecialidades($this->token);
        $origens        = self::buscaOrigens($this->token);
        $horarios       = self::buscarHorariosDisponiveis(); /* Horarios somente fictício para o cliente preencher */
        return view('consulta.agendar', compact('especialidades', 'origens', 'horarios'));
    }

    /**
     * Busca as especialidades
     *
     * @param string $token = token da API para buscar os dados
     * @return object
     */
    protected static function buscaEspecialidades($token)
    {
        $especialidades = [];
        try {
            /* Vamos guardar cache para que caso o usuário atualize a tela não tenha que recarregar novamente durante o intervalo de 1 minuto */
            if (!Cache::has('ch-especialidades')) {
                $response = Http::withHeaders([
                    'x-access-token' => $token,
                ])->get('https://api.feegow.com/v1/api/specialties/list');
                if ($response->successful()) {
                    $especialidades = json_decode($response->body())->content ?? [];
                }
                Cache::put('ch-especialidades', $especialidades, 60);
            } else {
                $especialidades = Cache::get('ch-especialidades');
            }
        } catch (\Throwable $th) {}

        return $especialidades;

    }

    /**
     * Busca as origens para serem listadas para o usuário selecionar como ele conheceu o serviço
     *
     * @param string $token = token da API
     * @return object
     */
    protected static function buscaOrigens($token)
    {
        $origens = [];
        try {
            /* Vamos guardar cache para que caso o usuário atualize a tela não tenha que recarregar novamente durante o intervalo de 5 minutos */
            if (!Cache::has('ch-origens')) {
                $response = Http::withHeaders([
                    'x-access-token' => $token,
                ])->get('https://api.feegow.com/v1/api/patient/list-sources');
                if ($response->successful()) {
                    $origens = json_decode($response->body())->content ?? [];
                }
                Cache::put('ch-origens', $origens, 300);
            } else {
                $origens = Cache::get('ch-origens');
            }
        } catch (\Throwable $th) {}

        return $origens;

    }

    /**
     * Busca os horarios fictícios disponiveis para um consulta
     *
     * @return array
     */
    protected static function buscarHorariosDisponiveis()
    {
        $datas = [];

        /* Gerando 5 datas futuras fictícias com base na de hoje */
        for ($i = 0; $i < 5; $i++) {
            $datas[] = Carbon::now()->addDays($i)->addMinutes($i)->format('Y-m-d H:i');
        }

        return $datas;
    }

    /**
     * Consulta os médicos por especialidade
     *
     * @param integer $especialidadeId = Id da especialidade
     * @return JSON
     */
    public function consultarMedicosPorEspecialidade($especialidadeId)
    {
        try {
            $especialistas = [];
            /* Vamos guardar cache para que caso o usuário atualize a tela não tenha que recarregar novamente durante o intervalo de 1 minuto */
            if (!Cache::has('ch-especialistas-' . $especialidadeId)) {
                $response = Http::withHeaders([
                    'x-access-token' => $this->token,
                ])->get('https://api.feegow.com/v1/api/professional/list', [
                    "ativo"            => true,
                    "especialidade_id" => $especialidadeId,
                ]);
                if ($response->successful()) {
                    $especialistas = json_decode($response->body())->content ?? [];
                }
                Cache::put('ch-especialistas-' . $especialidadeId, $especialistas, 60);
            } else {
                $especialistas = Cache::get('ch-especialistas-' . $especialidadeId);
            }
            return response()->json($especialistas);
        } catch (\Throwable $th) {
            return response('error', 500);
        }
    }

    /**
     * Agenda a consulta com o especialista e grava no banco
     *
     * @param Request $request
     * @return void
     */
    public function agendarConsultaMedico(Request $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['cliente_id'] = auth()->user()->id;
            $data['birthdate']  = Carbon::createFromFormat('d/m/Y', $data['birthdate'])->format('Y-m-d');
            $data['cpf']        = str_replace(['.', '-'], '', $data['cpf']);

            /* Gerando o registro no banco */
            Consulta::create($data);
            if (Cache::has('ch-minhas-consultas')) {
                Cache::forget('ch-minhas-consultas');
            }
            DB::commit();
            return response()->json('success');
        } catch (\Throwable $th) {
            DB::rollback();
            return response('error', 500);
        }
    }

    /**
     * Deleta o agendamento da consulta
     *
     * @param Request $request
     * @return JSON
     */
    public function cancelarConsulta(Request $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            Consulta::find($data["agendamentoId"])->delete();
            DB::commit();
            if (Cache::has('ch-minhas-consultas')) {
                Cache::forget('ch-minhas-consultas');
            }
            return response()->json('success');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json('error', 500);
        }
    }
}
