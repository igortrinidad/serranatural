<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\User;
use serranatural\Models\Caixa;
use serranatural\Models\Conferencia;

class ConferenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adm.financeiro.conferencias');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $autorizaUser = User::where('id', '=', \Auth::user()->id)
                    ->where('senha_operacao', '=', $request->senha)
                    ->first();

        $autorizaConf = User::where('senha_operacao', '=', $request->senha_conferente)
                           ->whereIn('user_type', ['super_adm', 'operacao', 'admin'])
                    ->first();

        if (!$autorizaUser || !$autorizaConf || $autorizaUser->id == $autorizaConf->id) {
            return response()->json([
                'retorno' => [
                'type' => 'error',
                'message' => 'Usuário ou senha inválida.',
                'title' => 'Atenção'
                ],
            ], 404);
        }

        $conferencia = Conferencia::create([
            'caixa_id' => $request->id,
            'user_id' => $autorizaUser->id,
            'user_conf_id' => $autorizaConf->id,
            'vr_abertura' => $request->vr_abertura,
            'vendas' => $request->vendas,
            'vendas_cielo' => $request->vendas_cielo,
            'vendas_rede' => $request->vendas_rede,
            'total_retirada' => $request->total_retirada,
            'esperado_caixa' => $request->esperado_caixa,
            'vr_emCaixa' => $request->vr_emCaixa,
            'turno' => $request->turno,
            'diferenca_final' => $request->diferenca_final,
            'obs' => $request->obs,
            'dt_abertura' => $request->dt_abertura
        ]);

        
        $caixa = Caixa::where('id', '=', $request->id)->first();

        if($caixa && $conferencia) {

            $caixa->update([
                    'user_id_abertura' => $request->user_id_abertura,
                    'user_id_fechamento' => $request->user_id_fechamento,
                    'vr_abertura' => $request->vr_abertura,
                    'vendas' => $request->vendas,
                    'vendas_cielo' => $request->vendas_cielo,
                    'vendas_rede' => $request->vendas_rede,
                    'total_retirada' => $request->total_retirada,
                    'esperado_caixa' => $request->esperado_caixa,
                    'vr_emCaixa' => $request->vr_emCaixa,
                    'turno' => $request->turno,
                    'diferenca_final' => $request->diferenca_final,
                    'is_aberto' => $request->is_aberto,
                    'obs' => $request->obs,
                ]);

                return response()->json([
                'retorno' => [
                    'type' => 'success',
                    'message' => 'Conferência realizada com sucesso.',
                    'title' => 'Atenção!'
                ],
            ], 200);
        }




    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function fetchAll()
    {
        $conferencias = Conferencia::with('usuario', 'usuarioConferencia', 'caixa')->orderBy('created_at', 'DESC')->paginate(20);

        return $conferencias;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
