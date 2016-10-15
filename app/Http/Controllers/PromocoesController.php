<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use serranatural\Models\Pratos;
use serranatural\Models\Voto;
use serranatural\Models\Cliente;
use serranatural\Models\Preferencias;
use serranatural\Models\Promocoes;

class PromocoesController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth', ['except' => [],]);
    }


    public function listPromo()
    {
        $promocoes = Promocoes::get();

        return view('adm.promocoes.list', compact('promocoes'));
    }

    public function create()
    {
        return view('adm.promocoes.create');
    }

    public function edit($id)
    {
        $promocao = Promocoes::find($id);

        return view('adm.promocoes.edit', compact('promocao'));
    }

    public function store(Request $request)
    {
        $promo = Promocoes::create($request->all());

        if ($request->file('foto')) {

            $this->gravaArquivo($request->file('foto'), 'PROMO_', $promo);
        }

        flash()->success('Promoção gravada com sucesso.');

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $promocao = Promocoes::find($request->id);

        $promocao->titulo = $request->titulo;
        $promocao->inicio = $request->inicio;
        $promocao->fim = $request->fim;
        $promocao->descricao = $request->descricao;
        $promocao->regulamento = $request->regulamento;
        $promocao->save();

        if ($request->file('foto')) {

            $this->gravaArquivo($request->file('foto'), 'PROMO_', $promo);
        }

        flash()->success('Promoção gravada com sucesso.');

        return redirect()->back();
    }

    public function alteraStatus($id)
    {
        $promocao = Promocoes::find($id);

        $promocao->is_ativo = !$promocao->is_ativo;

        $promocao->save();

        flash()->success('Promoção gravada com sucesso.');

        return redirect()->back();
    }

    public function gravaArquivo($arquivo, $prefixo, $objeto)
    {
        $ext = $arquivo->getClientOriginalExtension();
        $nomeArquivo = $prefixo . '_ID_' . $objeto->id . '.' . $ext;
        $arquivo->move(public_path().'/uploads/promocoes/', $nomeArquivo);
        $objeto->foto = $nomeArquivo;
        $objeto->save();
    }
}
