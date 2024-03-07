<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once "topo.php";

$wallet = $connect->query("SELECT * FROM carteira WHERE Id = 1");
$walletRow = $wallet->fetch(PDO::FETCH_OBJ);

$curl = curl_init();

curl_setopt_array(
  $curl,
  array(
    CURLOPT_URL => 'https://api.mercadopago.com/preapproval_plan/'.$_POST['id'],
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

$type = base64_encode($response['reason']);
?>
  <div class="slim-mainpanel">
    <div class="container">
      <div align="right" class="mg-b-10">
        <a href="planos" class="btn btn-purple btn-sm">VOLTAR</a>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-body" align="justify">
              <label class="section-title">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>

                EDIÇÃO DE PLANOS
              </label>

              <hr>

              <form action="classes/planos_exe.php" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tipo de Plano</label>

                      <select class="form-control" name="type">
                        <option value="">Selecione</option>

                        <option value="TWVuc2Fs" <?php if ($type == "TWVuc2Fs") { echo "selected"; } ?>>Mensal</option>

                        <option value="VHJpbWVzdHJhbA==" <?php if ($type == "VHJpbWVzdHJhbA==") { echo "selected"; } ?>>Trimestral</option>

                        <option value="U2VtZXN0cmFs" <?php if ($type == "U2VtZXN0cmFs") { echo "selected"; } ?>>Semestral</option>

                        <option value="QW51YWw=" <?php if ($type == "QW51YWw=") { echo "selected"; } ?>>Anual</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Valor do Plano (R$)</label>

                      <input type="text" name="value" class="money form-control" value="<?php echo number_format($response['auto_recurring']['transaction_amount'], 2, ',', ''); ?>" required>
                    </div>
                  </div>
                </div>

                <hr />

                <div class="row">
                  <div class="col-md-12">
                    <div align="center">
                      <button type="submit" class="btn btn-primary">Editar <i class="fa fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="edit_planos" value="ok">

                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">

                <input type="hidden" name="base_url" value="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']; ?>">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../lib/jquery/js/jquery.js"></script>
  <script src="../js/moeda.js"></script>
  <script>
    function upperCaseF(a) {
      setTimeout(function () {
        a.value = a.value.toUpperCase();
      }, 1);
    }

    $('.money').mask('#.##0,00', { reverse: true });
  </script>
  <script src="../js/slim.js"></script>
</body>
</html>
