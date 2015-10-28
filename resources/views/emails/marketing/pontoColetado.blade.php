<html>
Nome cliente:{{ isset($nomeCliente) ? $nomeCliente : 'nomeCliente' }}<br>
Email:{{ isset($emailCliente) ? $emailCliente : 'email' }}<br>
Produto:{{ isset($produto) ? $produto : 'Produto adiquirido' }}<br>
Pontos Acai:{{ isset($qtdPontosAcai) ? $qtdPontosAcai : 'pontos acai' }}<br>
Pontos almoco:{{ isset($qtdPontosAlmoco) ? $qtdPontosAlmoco : 'pontos almoco' }}<br>
Vouchers:
@foreach($vouchers as $voucher)
<table>
    <tr>
        <th class="text-center">{{$voucher['id']}}</th>
        <th class="text-center">{{$voucher['produto']}}</th>
        <th class="text-center">{{$voucher['vencimento']}}</th>
        <th class="text-center">@if($voucher['data_utilizado'] <= '2015-01-01'){{$voucher['data_utilizado']}} @endif</th>
    </tr>
</table>
@endforeach
</html>