<div class="slim-body">
  <?php
  $urlk = $_SERVER["REQUEST_URI"];

  $currentPage = basename($urlk);

  $menuItems = [
    ["name" => "Home", "path" => "./", "icon" => "ion-ios-home-outline", "activeOn" => ["master"]],
    ["name" => "Grupo/Categoria", "path" => "categorias", "icon" => "fa fa-sitemap", "activeOn" => ["categorias", "cad_categoria", "edit_categoria"]],
    ["name" => "Clientes", "path" => "clientes", "icon" => "fa fa-users", "activeOn" => ["clientes", "ver_cliente", "cad_cliente", "edit_cliente"]],
    ["name" => "Contas a Receber", "path" => "contas_receber", "icon" => "fa fa-money", "activeOn" => ["cad_contas", "contas_receber", "editar_mensalidade", "cad_contas_simulador", "ver_financeiro"]],
    ["name" => "Contas a Pagar", "path" => "contas_pagar", "icon" => "fa fa-random", "activeOn" => ["contas_pagar", "cad_pagar", "editar_pagamento", "cad_pagar_simulador"]],
    ["name" => "Extrato de Pagamento", "path" => "finalizados", "icon" => "fa fa-thumbs-up", "activeOn" => ["finalizados", "ver_financeiro_quitado"]],
    ["name" => "Notificações", "path" => "mensagens", "icon" => "fa fa-envelope", "activeOn" => ["mensagens", "edit_mensagens"]],
  ];

  if ($dadosgerais->tipo == 1) {
    $menuItems[] = ["name" => "Usuários SAAS", "path" => "usuarios", "icon" => "fa fa-user-plus", "activeOn" => ["usuarios", "cad_usuario", "edit_usuario", "painel_usuario"]];
  }

  $menuItems[] = ["name" => "Planos", "path" => "planos", "icon" => "fa fa-user-plus", "activeOn" => ["planos", "cad_planos", "edit_planos"]];

  $menuItems[] = ["name" => "Meu Perfil", "path" => "perfil", "icon" => "fa fa-user-circle-o", "activeOn" => ["perfil"]];
  $menuItems[] = ["name" => "Configurações", "path" => "configuracoes", "icon" => "fa fa-cogs", "activeOn" => ["configuracoes"]];
  $menuItems[] = ["name" => "Configurar WhatsApp", "path" => "whatsapp", "icon" => "fa fa-whatsapp", "activeOn" => ["whatsapp"]];
  $menuItems[] = ["name" => "Configurar MercadoPago", "path" => "mercadopago", "icon" => "fa fa-credit-card-alt", "activeOn" => ["mercadopago"]];
  $menuItems[] = ["name" => "Sair", "path" => "sair", "icon" => "fa fa-sign-out", "activeOn" => ["sair"]];
  ?>

  <div class="slim-sidebar">
    <?php if ($dadosgerais->tipo > 1) { ?>
      <div id="msg-assinatura" class="slim-header-center mobile">
        <div class="time">Plano expira: <?php echo $date; ?></div>
      </div>
    <?php } ?>

    <label class="sidebar-label">MENU</label>

    <ul class="nav nav-sidebar">
      <?php foreach ($menuItems as $item): ?>
      <li class="sidebar-nav-item">
        <a href="<?php echo $item["path"]; ?>" class="sidebar-nav-link <?php if (in_array($currentPage, $item["activeOn"])) { echo "active"; } ?>">
          <i class="<?php echo $item["icon"]; ?> mg-r-10" style="font-size: 16px;"></i>

          <?php echo $item["name"]; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
