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
use DateTime;
use DB;

use Carbon\Carbon;

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

        $pratoDeHoje = AgendaPratos::with('pratos')->where('dataStamp', '=', date('Y-m-d'))
                                    ->first();

        $date = new DateTime();
        $date->modify('+1 day');

        $pratoDeAmanha = AgendaPratos::with('pratos')->where('dataStamp', '=', $date->format('Y-m-d'))
                                    ->first();

        return view('landing.cardapio', compact('pratoDeHoje', 'pratoDeAmanha'));
    }

    public function promocoes()
    {
        $promocoes = Promocoes::orderBy('created_at', 'DESC')
                    ->get();

        return view('landing.promocoes', compact('promocoes'));
    }

    public function fidelidade()
    {
        $now = Carbon::now();

        $start = $now->startOfMonth()->toDateTimeString();

        $end = $now->endOfMonth()->toDateTimeString();

        $podiums = PontoColetado::join('clientes', 'pontos_coletados.cliente_id', '=', 'clientes.id')
            ->whereBetween('pontos_coletados.created_at', [$start, $end])
            ->select('pontos_coletados.id', 'clientes.nome', 'pontos_coletados.cliente_id', DB::raw('count(DISTINCT pontos_coletados.id) as total'))
            ->groupBy('pontos_coletados.cliente_id')
            ->orderBy('total', 'DESC')
            ->orderBy('clientes.nome', 'ASC')
            ->withTrashed()
            ->get();

        if ($podiums->count() >= 3) {
            $p1 = $podiums[0];
            $p2 = $podiums[1];
            $p3 = $podiums[2];
        } else {
            $p1 = null;
            $p2 = null;
            $p3 = null;
        }

        return view('landing/fidelidade', compact('p1', 'p2', 'p3', 'start', 'end', 'podiums'));
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
                                ->where('vencimento', '>=', date('Y-m-d'))
                                ->get();

        $pontosProgress = PontoColetado::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('vencimento', '>=', date('Y-m-d'))
                                ->groupBy('produto')
                                ->select('produto', DB::raw('count(*) as total'))
                                ->get();

        foreach($pontosProgress as $pontos){
            $pontos->percentual = number_format(100 / 15 * $pontos->total, 0);
            $pontos->faltam = 15 - $pontos->total;
        }

        $vouchers = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 1)
                                ->where('vencimento', '>=', date('Y-m-d'))
                                ->get();

        $vouchersUtilizados = Voucher::where('cliente_id', '=', $cliente->id)
                                ->where('is_valido', '=', 0)
                                ->where('vencimento', '>=', date('Y-m-d'))
                                ->get();

    return view('landing.detalhesCliente', compact(
            'cliente',
            'pontosAll',
            'pontosProgress',
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

        $emailMsg = 
            '<p><strong>Nome:</strong> ' . $request->nome . '</p>'.
            '<p><strong>Email: </strong>' . $request->email . '</p>'.
            '<p><strong>Telefone: </strong>' . $request->telefone . '</p>'.
            '<p><strong>Mensagem</strong>: ' . $request->mensagem . '</p>';

        Mail::send(array('html' => 'emails.marketing.blank'), array('msg' => $emailMsg), function ($message) use ($request) {
            $message->to('lojaserranatural@gmail.com');
            $message->from($request->email, $request->nome);
            $message->subject('Mensagem site Serra Natural: ' . $request->nome);
        });

        flash()->success('Email enviado com sucesso.');

        return redirect()->back();
    }
}
