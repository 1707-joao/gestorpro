<?php
require_once "topo.php";

$idins = $dadosgerais->tokenapi;

$stmt = $connect->query("SELECT id FROM conexoes WHERE id_usuario = '" . $cod_id . "' AND conn = '1'");
$rowCount = $stmt->rowCount();

if($rowCount > 0) {
  echo "<meta http-equiv=\"refresh\" content=\"0;URL=./\">";
  
  exit;
} else {
  $connections = $connect->query("SELECT apikey FROM conexoes WHERE id_usuario = '" . $cod_id . "'");
  $connectionsRow	= $connections->fetch(PDO::FETCH_OBJ);
  
  if ($connectionsRow->apikey) {
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
      CURLOPT_URL => $urlapi.'/instance/connectionState/AbC123'. $idins,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'apikey: '. $connectionsRow->apikey .''
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    
    $res = json_decode($response, true);
    
    $conexaoo = $res['instance']['state'];
    
    if($conexaoo == 'open') {
      $connect->query("UPDATE conexoes SET conn = '1' WHERE id_usuario = '" . $cod_id . "'");
      
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=./whatsapp\">";
      
      exit;
    }
  }
}
?>
  <div class="slim-mainpanel">
    <div class="container">
      <?php if(isset($_GET["sucesso"])) { ?>
        <div class="alert alert-solid alert-success" role="alert">
          <strong>Sucesso!!!</strong>
        </div>
        
        <meta http-equiv="refresh" content="1;URL=./usuarios" />
      <?php } ?>
      
      <div class="section-wrapper">
        <label class="section-title">Efetue a leitura do QRCode</label>
        
        <div class="row">
          <div class="col-md">
            <div class="card card-body">
              <?php
              $stm = $connect->query("SELECT qrcode, conn FROM conexoes WHERE id_usuario = '". $cod_id ."'");
              $rowCount = $stm->rowCount();
              
              if($rowCount > 0) {
                $row = $stm->fetch();
              ?>
                <center>
                  <?php if($row["qrcode"] == "") { ?>
                    Aguarde gerando o QRCODE...
                  <?php } else { ?>
                    <img src="<?php print $row["qrcode"]; ?>" alt="" style="width: 150;">
                  <?php } ?> 
                </center>
              <?php } else { ?>  
                <center>
                  Conectado com Sucesso... Redirecionando
                  <meta http-equiv="refresh" content="1;URL=./">
                </center>
              <?php  }  ?>
            </div>
          </div>
          
          <div class="col-md mg-t-20 mg-md-t-0">
            <div class="card card-body bg-primary tx-white bd-0">
              <div class="card-text" align="center">Aguardando Conexão em <span id="contador">5</span></div>
            </div>
            
            <br/>
            
            <h4>Use o WhatsApp no Sistema</h4>
            
            <p>1. Abra o WhatsApp no seu celular.</p>
            
            <p>2. Toque em <strong>Mais opções</strong> ou <strong>Configurações</strong> e selecione <strong>Aparelhos Conectados</strong>.</p>

            <p>3. Toque em <strong>Conectar Aparelho</strong>.</p>

            <p>4. Aponte seu celular para esta tela e efetue a leitura do QRCode.</p>
            
            <form action="classes/gera_qr.php" method="post">
              <input type="hidden" name="token_api" value="<?php print $dadosgerais->tokenapi;?>">
              
              <input type="hidden" name="celular" value="<?php print $dadosgerais->celular; ?>">
              
              <div align="center"><button type="submit" class="btn btn-dark" name="cart">Novo QRCode</button></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <script src="../lib/jquery/js/jquery.js"></script>
  <script>
    var divContador = document.getElementById("contador");
    
    var tempoTotal = 5;
    
    var intervalo = setInterval(function() {
      tempoTotal--;
      
      divContador.innerHTML = tempoTotal;
      
      if (tempoTotal == 0) {
        clearInterval(intervalo);
        
        location.reload();
      }
    }, 1000);
  </script>
  
  <script src="../js/slim.js"></script>
</body>
</html>
