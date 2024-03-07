<?php
$wallet = $connect->query("SELECT * FROM carteira WHERE Id = 1");
$walletRow = $wallet->fetch(PDO::FETCH_OBJ);
?>
<div class="slim-mainpanel">
  <div class="container">
    <?php if ($dadosgerais->tipo == 1) { ?>
      <div align="right" class="mg-b-10">
        <a href="cad_planos" class="btn btn-purple btn-sm">
          <i class="fa fa-plus mg-r-10" aria-hidden="true"></i>

          NOVO PLANO
        </a>
      </div>
    <?php } ?>

    <?php if ($_GET["cad"] == "ok") { ?>
      <div class="alert alert-solid alert-success" role="alert">
        <strong>Plano cadastrado com sucesso.</strong>
      </div>

      <meta http-equiv="refresh" content="2; URL=planos" />
    <?php } ?>

    <?php if ($_GET["edit"] == "ok") { ?>
      <div class="alert alert-solid alert-warning" role="alert">
        <strong>Plano editado com sucesso.</strong>
      </div>

      <meta http-equiv="refresh" content="2; URL=planos" />
    <?php } ?>

    <div id="planos">
      <?php
      $curl = curl_init();

      curl_setopt_array(
        $curl,
        array(
          CURLOPT_URL => 'https://api.mercadopago.com/preapproval_plan/search?status=active',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $walletRow->tokenmp . '',
            'X-Idempotency-Key: ' . $idempotency . ''
          )
        )
      );

      $response = curl_exec($curl);

      $response = json_decode($response, true);

      $index = 0;

      while (isset($response['results'][$index])) {
        $value = number_format($response['results'][$index]['auto_recurring']['transaction_amount'], 2, '.', '');

        $values = explode('.', $value);
      ?>
      <div class="plano">
        <div class="header">
          <h1>Plano</h1>

          <h2><?php echo $response['results'][$index]['reason'] ?></h2>

          <?php if ($dadosgerais->tipo == 1) { ?>
            <form action="edit_planos" method="post" class="edit">
              <input type="hidden" name="id" value="<?php echo $response['results'][$index]['id']; ?>">

              <button type="submit"><i class="fa fa-edit"></i></button>
            </form>
          <?php } ?>
        </div>

        <div class="value">
          <i>R$</i>

          <strong><?php echo $values[0]; ?></strong>

          <span>,<?php echo $values[1]; ?></span>
        </div>

        <div class="features">
          <p><i class="fa fa-check-circle"></i> Área do Cliente</p>

          <p><i class="fa fa-check-circle"></i> API WhatsApp Própria</p>

          <p><i class="fa fa-check-circle"></i> Envio de Mensagens de texto em Massa</p>

          <p><i class="fa fa-check-circle"></i> Financeiro Completo</p>

          <p><i class="fa fa-check-circle"></i> Fatura</p>

          <p><i class="fa fa-check-circle"></i> Clientes Ilimitados</p>

          <p><i class="fa fa-check-circle"></i> Faturas Ilimitadas</p>

          <p><i class="fa fa-check-circle"></i> Suporte via WhatsApp/Acesso Remoto</p>
        </div>

        <div class="bottom">
          <a href="<?php echo $response['results'][$index]['init_point'] ?>" target="_blank">CONTRATAR</a>

          <p>Pague via Pix ou Cartão de Crédito</p>

          <div class="warning">Ao finalizar o pagamento, clicar no botão para voltar ao site e assim validar sua assinatura.</div>
        </div>
      </div>
      <?php $index++; } curl_close($curl); ?>
    </div>
  </div>
</div>

<script src="../lib/jquery/js/jquery.js"></script>
<script src="../js/slim.js"></script>
</body>

</html>
