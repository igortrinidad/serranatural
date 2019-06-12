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
                              <p style="text-align: center; "><span style="font-weight: bold; font-size: 18px;">Contas a pagar</span></p>
@foreach($pagamentos as $pagamento)
  <p style="line-height: 1;"><span style="font-weight: bold;">Descrição:</span></p>
  <p style="line-height: 1;">{{$pagamento['descricao']}}</p>
  <p style="line-height: 1;"></p>
  <p style="line-height: 1;"><span style="font-weight: bold;">Vencimento:</span></p>
  <p style="line-height: 1;">{{$pagamento['vencimento']}}</p>
  <p style="line-height: 1;"></p>
  <p style="line-height: 1;"><span style="font-weight: bold;">Valor:</span></p>
  <p style="line-height: 1;">{{$pagamento['valor']}}</p>
  <p style="line-height: 1;"></p>
  <p style="line-height: 1;"><span style="font-weight: bold;">Linha digitavel:</span></p>
  <p style="line-height: 1;"><span style="font-size: 12px;">{{$pagamento['linha_digitavel']}}</span></p>
  <p style="line-height: 1;"></p>
  <hr>
  <p style="line-height: 1;"><span style="font-size: 12px;">
  </span></p>
@endforeach
<div><br></div>
<p style="line-height: 1;"><br></p>
<table border="0" cellpadding="0" cellspacing="0">
<tbody>
<tr>
                                      <td colspan="2" height="15"></td>
                                    </tr>
</tbody>
                            </table>
                          <p></p>
</td>
                          <td width="40"></td>
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
            <td align="center" style="font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#575757" width="420">                      © 2016 Serra Natural</td>
          </tr>
          <tr>
            <td height="20" style="font-size:0px;line-height:0px">&nbsp;</td>
          </tr>
          <tr>
            <td align="center"><p><img src="http://www.admin.serranatural.com/img/logo.png" style="width: 25%;"><br></p>
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