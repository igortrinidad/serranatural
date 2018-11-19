<table bgcolor="#eeeeee" border="0" cellpadding="0" cellspacing="0" style="width:100%!important;background:#eeeeee;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px" width="100%">
  <tbody>
    <tr>
      <td>            <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
          <tr>
            <td height="25" style="font-size:0px;line-height:0px">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">                  <table border="0" cellpadding="0" cellspacing="0">
              <tbody>
                <tr>
                  <td bgcolor="#eeeeee" width="25"><img style="display:block" alt="" height="25" src="https://ci5.googleusercontent.com/proxy/KIRNlJ3oar5-3aJmNdW6S2Ui9ZyByUaG5ZZJFR-7ocRQfj-82E-fEs1LAYKUki1DEh30L5jv0w=s0-d-e1-ft#http://placehold.it/25x25/eee/eee" width="25" class="CToWUd"></td>
                  <td>                        <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                      <tr>
                        <td bgcolor="#eeeeee" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#eeeeee" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                      </tr>
                      <tr>
                        <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                      </tr>
                      <tr>
                        <td bgcolor="#e9e9e9" style="font-size:0px;line-height:0px" width="1">&nbsp;</td>
                        <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                        <td align="left" bgcolor="#ffffff" width="400">                              <table border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td colspan="3" height="30"></td>
                            </tr>
                            <tr>
                              <td width="40"></td>
                              <td width="320">
                                <table border="0" cellpadding="0" cellspacing="0">
                                <tbody>
                                  <tr>
                                    <td colspan="2" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:22px;color:#575757;font-weight:bold">
                                      Fechamento de caixa:
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="5" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>

                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      {{ $caixa->dt_abertura }}
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      {{ $caixa->dt_fechamento }}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td bgcolor="#575757" colspan="2" height="2" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="26"></td>
                                  </tr>

                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Total de vendas
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{ $caixa->vendas }}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>

                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Resp. abertura
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      {{ $caixa->usuarioAbertura->name }}
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>

                                  
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Resp. fechamento
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      {{ $caixa->usuarioFechamento->name }}
                                    </td>
                                  </tr>


                                  <!-- caixa novo -->
                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Valor abertura
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{$caixa->payments['register_init_value'] }}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Valor fechamento
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{$caixa->payments['register_end_value'] }}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Venda total dinheiro (aprox)
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{$caixa->payments['total_money'] }}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Venda total cartão
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{$caixa->payments['total_cards'] }}
                                    </td>
                                  </tr>


                                  <hr>
                                  
                                  @foreach($caixa->payments['items'] as $item)
                                  <tr>
                                    <td colspan="2" height="15" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      {{$item['label']}}
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                      R$ {{$item['value'] }}
                                    </td>
                                  </tr>
                                    <!-- Taxas -->
                                    @if(isset($item['tax']))
                                    <tr>
                                      <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                        Taxa aproximada
                                      </td>
                                      <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="120">
                                        R$ {{ ($item['value'] * $item['tax']) / 100 }}
                                      </td>
                                    </tr>
                                    @endif

                                  @endforeach

                                  <hr>

                                  <!-- caixa novo -->

                                <tr>
                                  <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;font-weight:bold" width="200">    Diferença final
                                  </td>
                                  <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;font-weight:bold" valign="bottom" width="120">
                                    {{$caixa->diferenca_final}}
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2" height="27"></td>
                                </tr>
                                <tr>
                                  <td bgcolor="#575757" colspan="2" height="2" style="font-size:0px;line-height:0px">&nbsp;</td>
                                </tr>

                                @if($caixa->retiradas)
                                  <tr>
                                    <td colspan="2" height="27"></td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;font-weight:bold" width="200">
                                      Retiradas
                                    </td>
                                  </tr>

                                  @foreach($caixa->retiradas  as $retirada)

                                  <tr>
                                    <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;font-weight:bold" width="200">    Usuario
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" valign="bottom" width="120">
                                      {{$retirada->usuario->name}}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" width="200">    {{$retirada->tipo}}
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" valign="bottom" width="120">
                                      {{$retirada->valor}}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" width="200">    Descrição
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" valign="bottom" width="120">
                                      {{$retirada->descricao}}
                                    </td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="27"></td>
                                  </tr>

                                  @endforeach

                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" width="200">
                                      Total retirada
                                    </td>
                                    <td align="right" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757" valign="bottom" width="120">
                                      R$ {{$caixa->total_retirada }}
                                    </td>
                                  </tr>

                                @endif

                                  <tr>
                                    <td colspan="2" height="27"></td>
                                  </tr>
                                  <tr>
                                    <td bgcolor="#575757" colspan="2" height="2" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>

                                  <tr>
                                    <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;font-weight:bold" width="200">
                                      Observações
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="2" height="12" style="font-size:0px;line-height:0px">&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px;color:#575757;" valign="bottom" width="120">
                                      {{$caixa->obs}}
                                    </td>
                                  </tr>
                                
                              </tbody>
                            </table>
                          </td>
                          <td width="40"></td>
                        </tr>
                        <tr>
                          <td colspan="3" height="60"></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                  <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e9e9e9" style="font-size:0px;line-height:0px" width="1">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e1e1e1" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                </tr>
                <tr>
                  <td bgcolor="#eeeeee" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#e9e9e9" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                  <td bgcolor="#eeeeee" height="1" style="font-size:0px;line-height:0px">&nbsp;</td>
                </tr>
              </tbody>
            </table>
          </td>
          <td bgcolor="#eeeeee" width="25"><img style="display:block" alt="" height="25" src="https://ci5.googleusercontent.com/proxy/KIRNlJ3oar5-3aJmNdW6S2Ui9ZyByUaG5ZZJFR-7ocRQfj-82E-fEs1LAYKUki1DEh30L5jv0w=s0-d-e1-ft#http://placehold.it/25x25/eee/eee" width="25" class="CToWUd"></td>
        </tr>
      </tbody>
    </table>
  </td>
</tr>
</tbody>
</table>
<table align="center" bgcolor="#eeeeee" border="0" cellpadding="0" cellspacing="0" style="font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:21px" width="100%">
  <tbody>
    <tr>
      <td width="6%"></td>
      <td align="center">                <table align="center" border="0" cellpadding="0" cellspacing="0">
        <tbody>
          <tr>
            <td height="20"></td>
          </tr>
          <tr>
            <td align="center" style="font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#575757" width="420">                      © 2015 Serra Natural</td>
          </tr>
          <tr>
            <td height="20" style="font-size:0px;line-height:0px">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><p><img src="https://serranatural.com/img/logo.png" style="width: 25%;"><br></p>
            </td>
          </tr>
          <tr>
            <td height="50" style="font-size:0px;line-height:0px">&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </td>
    <td width="6%"></td>
  </tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>