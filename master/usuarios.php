<?php
require_once "topo.php";
?>
<div class="slim-mainpanel">
  <div class="container">
    <div align="right" class="mg-b-10"><a href="cad_usuario" class="btn btn-purple btn-sm"><i class="fa fa-plus mg-r-10"
          aria-hidden="true"></i>NOVO USUÁRIO</a></div>

    <?php if (isset($_GET["sucesso"])) { ?>
      <div class="alert alert-solid alert-success" role="alert">
        <strong>Sucesso!!!</strong>
      </div>
      <meta http-equiv="refresh" content="1;URL=./usuarios" />
    <?php } ?>

    <div class="section-wrapper">
      <label class="section-title"><i class="fa fa-check-square-o" aria-hidden="true"></i> Lista </label>
      <hr>
      <div class="table-wrapper">
        <table id="datatable1" class="table display responsive nowrap" width="100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Nome</th>
              <th>Celular</th>
              <th>Painel Usuário</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <?php
            $clientes = $connect->query("SELECT * FROM carteira WHERE tipo != '1' AND idm ='" . $cod_id . "' ORDER BY nome ASC");
            while ($dadosclientes = $clientes->fetch(PDO::FETCH_OBJ)) {
              ?>
              <tr>
                <td>
                  <?php print $dadosclientes->Id; ?>
                </td>
                <td>
                  <?php print $dadosclientes->nome; ?>
                </td>
                <td>
                  <?php print $dadosclientes->celular; ?>
                </td>


                <td align="center">
                  <form action="painel_usuario" method="POST">
                    <input type="hidden" name="ver" value="ok" />
                    <input type="hidden" name="idcli" value="<?php print $dadosclientes->Id; ?>" />
                    <input type="hidden" name="idmas" value="<?php print $cod_id; ?>" />
                    <button type="submit" class="btn btn-info btn-sm"><i class="icon fa fa-search"></i></button>
                  </form>
                </td>

                <td align="center">
                  <form action="edit_usuario" method="post">
                    <input type="hidden" name="edicli" value="<?php print $dadosclientes->Id; ?>" />
                    <button type="submit" class="btn btn-warning btn-sm"><i class="icon fa fa-pencil-square"></i></button>
                  </form>
                </td>

                <td align="center">
                  <form action="classes/funcionario_exe.php" method="post">
                    <input type="hidden" name="delcob" value="<?php print $dadosclientes->Id; ?>" />
                    <button type="submit" class="btn btn-danger btn-sm" onclick='return pergunta();'><i
                        class="icon fa fa-times"></i></button>
                  </form>
                </td>
              </tr>
            <?php } ?>

          </tbody>
        </table>
      </div>
    </div>

  </div><!-- container -->
</div><!-- slim-mainpanel -->
<script src="../lib/jquery/js/jquery.js"></script>

<script src="../lib/datatables/js/jquery.dataTables.js"></script>
<script src="../lib/datatables-responsive/js/dataTables.responsive.js"></script>
<script src="../lib/select2/js/select2.min.js"></script>

<script>
  $(function () {
    'use strict';

    $('#datatable1').DataTable({
      responsive: true,
      language: {
        searchPlaceholder: 'Buscar...',
        sSearch: '',
        lengthMenu: '_MENU_ ítens',
      }
    });

    $('#datatable2').DataTable({
      bLengthChange: false,
      searching: false,
      responsive: true
    });

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

  });
</script>
<script>

  function pergunta() {
    // retorna true se confirmado, ou false se cancelado
    return confirm('Tem certeza que deseja excluir este usuário?');
  }

</script>
<script src="../js/slim.js"></script>
</body>

</html>