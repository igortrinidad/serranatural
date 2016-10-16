<?php

namespace serranatural\Http\Controllers;

use Illuminate\Http\Request;
use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\Cliente;
use serranatural\Models\Pratos;
use serranatural\Models\AgendaPratos;
use serranatural\Models\Promocoes;
use serranatural\Models\PontoColetado;
use serranatural\Models\Voucher;

use Mail;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('landing.home');
    }

    public function cardapio()
    {
        return view('landing.cardapio');
    }

    public function promocoes()
    {
        $promocoes = Promocoes::get();

        return view('landing.promocoes', compact('promocoes'));
    }

    public function fidelidade()
    {
        return view('landing/fidelidade');
    }

    public function cadastroCliente($email)
    {
        return view('landing.detalhesCliente', compact('email'));
    }

        public function detalhesCliente($email)
    {

        $cliente = Cliente::where('email', '=', $email)->first();

        if (!$cliente) {

            flash()->error('Email : ' . $email . ' não encontrado.');

            return redirect('/fidelidade');

        }


        $pontosAll = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $vouchers = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->get();

        $vouchersUtilizados = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 0)
                                ->get();

    return view('landing.detalhesCliente', compact(
            'cliente',
            'pontosAll',
            'vouchers',
            'vouchersUtilizados'
        ));

    }

    public function contato()
    {
        return view('landing.contato');
    }

    public function contatoForm(Request $request)
    {

        $content = '<p><strong>Mensagem:</strong> ' . $request->mensagem . '</p>';

        Mail::raw($content, function ($message) {
            $message->to('lojaserranatural@gmail.com');
            $message->from('site@serranatural.com', 'Serra Natural');
            $message->subject('Mensagem site Serra Natural');
        });

        flash()->success('Email enviado com sucesso.');

        return redirect()->back();
    }
}
