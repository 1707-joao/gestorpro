<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

require_once "topo.php";
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

                CADASTRO DE PLANOS
              </label>

              <hr>

              <form action="classes/planos_exe.php" method="post">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tipo de Plano</label>

                      <select class="form-control" name="type">
                        <option value="">Selecione</option>

                        <option value="TWVuc2Fs">Mensal</option>

                        <option value="VHJpbWVzdHJhbA==">Trimestral</option>

                        <option value="U2VtZXN0cmFs">Semestral</option>

                        <option value="QW51YWw=">Anual</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Valor do Plano (R$)</label>

                      <input type="text" name="value" class="money form-control" required>
                    </div>
                  </div>
                </div>

                <hr />

                <div class="row">
                  <div class="col-md-12">
                    <div align="center">
                      <button type="submit" class="btn btn-primary">Cadastrar <i class="fa fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>

                <input type="hidden" name="cad_planos" value="ok">

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
