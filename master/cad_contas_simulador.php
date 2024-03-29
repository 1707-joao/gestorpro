<?php require_once "topo.php"; ?>
  <?php
  $cliente = $_POST['cliente'];
  $fpagamento = '30';
  $parcelas = $_POST['parcelas'];

  $valor = $_POST['valor'];
  $valor = str_replace(".", "", $valor);
  $valor = str_replace(",", ".", $valor);

  $valorparcela = $valor;

  $datap = date('d/m/Y', strtotime($_POST["datap"]));

  $vencimento_primeira_parcela = explode('/', $datap);

  $dia = $vencimento_primeira_parcela[0];
  $mes = $vencimento_primeira_parcela[1];
  $ano = $vencimento_primeira_parcela[2];
  ?>

  <div class="slim-mainpanel">
    <div class="container">
      <div align="right" class="mg-b-10">
        <a href="cad_contas" class="btn btn-purple btn-sm">VOLTAR</a>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-info">
            <div class="card-body" align="justify">
              <label class="section-title">
                <i class="fa fa-check-square-o" aria-hidden="true"></i>
                
                Demonstrativo de Cobranças
              </label>

              <hr>

              <div class="row">
                <div class="col-md-12" align="center">
                  <div class="form-group">
                    <?php $buscacli = $connect->query("SELECT * FROM clientes WHERE Id='$cliente'"); $buscaclix = $buscacli->fetch(PDO::FETCH_OBJ); ?>

                    <h4>
                      <span style="color: #FF9966;"></span>
                      
                      <?= $buscaclix->nome; ?>
                    </h4>
                  </div>
                </div>
              </div>

              <hr style="margin-top: -5px;">

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Valor Total</label>

                    <div class="styled-select">
                      <input type="text" class="form-control" value="<?php print number_format($valor * $parcelas, 2, ',', '.'); ?>" disabled>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Forma de Pagamento</label>

                    <?php if ($fpagamento == 30) { ?>
                      <input type="text" name="valor" class="form-control" value="Mensal" disabled>
                    <?php } ?>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Quantidade de Mensalidades</label>

                    <div class="styled-select">
                      <input type="number" name="parcelas" class="form-control" value="<?php print $parcelas; ?>" disabled>
                    </div>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label>Primeira Mensalidade</label>

                    <div class="styled-select">
                      <input type="text" class="form-control" value="<?php print $datap; ?>" disabled>
                    </div>
                  </div>
                </div>
              </div>

              <hr />

              <div class="row">
                <?php
                for ($parcela = 0; $parcela < $parcelas; $parcela++) {
                  $data = new DateTime();

                  $data->setDate($ano, $mes, $dia);

                  $data->modify('+' . $parcela . ' month');
              
                  if ($data->format('d') != $dia) {
                    $data->modify('first day of next month');
                  }
              
                  $qwerr = $data->format('d/m/Y');              
                ?>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Valor da Mensalidade</label>
                    
                    <input type="text" class="form-control" value="R$: <?php print number_format($valorparcela, 2, ',', '.'); ?>" disabled>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Data de Pagamento</label>
                    
                    <div class="styled-select">
                      <input type="text" class="form-control" value="<?php print $qwerr; ?>" disabled>
                    </div>
                  </div>
                </div>

                <?php } ?>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div align="center">
                    <a href="cad_contas" class="btn btn-primary">
                      <i class="fa fa-arrow-left"></i>
                      
                      Voltar
                    </a>
                  </div>
                </div>

                <div class="col-md-6">
                  <form action="classes/simulador_exe.php" method="post">
                    <input type="hidden" name="idcliente" value="<?php print $cliente; ?>">

                    <input type="hidden" name="formapagamento" value="<?php print $fpagamento; ?>">

                    <input type="hidden" name="parcelas" value="<?php print $parcelas; ?>">

                    <input type="hidden" name="dataparcela" value="<?php print $datap; ?>">

                    <input type="hidden" name="dataparcelax" value="<?php print $_POST["datap"]; ?>">

                    <input type="hidden" name="idpedido" value="<?php print $better_token = md5(uniqid(rand(), true)); ?>">

                    <input type="hidden" name="vparcela" value="<?php print $valorparcela; ?>">

                    <div align="center">
                      <button type="submit" class="btn btn-success" name="cart">
                        Cadastrar
                        
                        <i class="fa fa-arrow-right"></i>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="../lib/jquery/js/jquery.js"></script>

  <script src="../lib/jquery.cookie/js/jquery.cookie.js"></script>

  <script src="../lib/jquery.maskedinput/js/jquery.maskedinput.js"></script>

  <script src="../lib/select2/js/select2.full.min.js"></script>

  <script src="../js/slim.js"></script>
</body>
</html>