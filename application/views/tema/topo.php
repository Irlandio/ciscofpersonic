
<!DOCTYPE html>
<html lang="en">
<head>
<title>CiScoFiP</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-style.css" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/matrix-media.css" />
<link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/fullcalendar.css" /> 

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery-1.10.2.min.js"></script>

</head>
<body>

<!--Header-part-->
<div id="header">
  <h1><a href="">CISCOFIP</a></h1>
</div>
<!--close-Header-part--> 

<!--top-Header-menu-->
<div id="user-nav" class="navbar navbar-inverse">
  <ul class="nav">
   
    <li class=""><a title="" href="<?php echo site_url();?>/mapos/minhaConta"><i class="icon icon-star"></i> <span class="text">Minha Conta</span></a></li>
    <li class=""><a title="" href="<?php echo site_url();?>/mine"><i class="icon icon-eye-open"></i> <span class="text">Área do Cliente</span></a></li>
    <li class="pull-right"><a href="https://" target="_blank"><i class="icon icon-asterisk"></i> <span class="text">Versão: <?php echo $this->config->item('app_version'); ?></span></a></li>
    <li class=""><a title="" href="<?php echo site_url();?>/mapos/sair"><i class="icon icon-share-alt"></i> <span class="text">Sair do Sistema</span></a></li>
    
  </ul>

</div>

<!--start-top-serch-->
<div id="search">
  <form action="<?php echo base_url()?>index.php/mapos/pesquisar">
    <input type="text" name="termo" placeholder="Pesquisar..."/>
    <button type="submit"  class="tip-bottom" title="Pesquisar"><i class="icon-search icon-white"></i></button>
    
  </form>
</div>
<!--close-top-serch--> 

<!--sidebar-menu-->

<div id="sidebar"> <a href="#" class="visible-phone"><i class="icon icon-list"></i> Menu</a>
  <ul>


    <li class="<?php if(isset($menuPainel)){echo 'active';};?>"><a href="<?php echo base_url()?>"><i class="icon icon-home"></i> <span>Home</span></a></li>
    
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vVenda')){ ?>
        <li class="<?php if(isset($menuVendas)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/vendas"><i class="icon icon-folder-open"></i> <span>Lançamentos</span></a></li>
    <?php } ?>
      
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vCliente')){ ?>
     <li class="<?php if(isset($menuClientes)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/clientes"><i class="icon icon-group"></i> <span>Fornecedores</span></a></li>
    <?php } ?>
    
<!--
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vProduto')){ ?>
      <li class="<?php if(isset($menuProdutos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/produtos"><i class="icon icon-group"></i> <span>Presentes Especiais</span></a></li>
    <?php } ?>
-->
    
<!--
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vServico')){ ?>
        <li class="<?php if(isset($menuServicos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/servicos"><i class="icon icon-wrench"></i> <span>Serviços</span></a></li>
    <?php } ?>
-->

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vOs')){ ?>
        <li class="<?php if(isset($menuOs)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/os"><i class="icon icon-tags"></i> <span>Ordens de Serviço</span></a></li>
    <?php } ?>

    
<!--
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vArquivo')){ ?>
        <li class="<?php if(isset($menuArquivos)){echo 'active';};?>"><a href="<?php echo base_url()?>index.php/arquivos"><i class="icon icon-hdd"></i> <span>Arquivos</span></a></li>
    <?php } ?>
-->

<!--
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'vLancamento')){ ?>
        <li class="submenu <?php if(isset($menuFinanceiro)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-money"></i> <span>Cheques</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
        <li><a href="<?php echo base_url()?>index.php/financeiro/lancamentos?periodo=todos&situacao=pendente">Conciliação Bancária</a></li>
          </ul>
        </li>
    <?php } ?>
-->

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rCliente') || $this->permission->checkPermission($this->session->userdata('permissao'),'rProduto') || $this->permission->checkPermission($this->session->userdata('permissao'),'rServico') || $this->permission->checkPermission($this->session->userdata('permissao'),'rOs') || $this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro') || $this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
        
        <li class="submenu <?php if(isset($menuRelatorios)){echo 'active open';};?>" >
          <a href="#"><i class="icon icon-list-alt"></i> <span>Relatórios</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>

            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rFinanceiro')){ ?>
                <li><a href="<?php echo base_url()?>index.php/relatorios/financeiro">Analiticos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rVenda')){ ?>
             <li><a href="<?php echo base_url()?>index.php/relatorios/vendas">Sinteticos</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'rOs')){ ?>
                 <li><a href="<?php echo base_url()?>index.php/relatorios/os">Administrativos</a></li>
            <?php } ?>
            
            
          </ul>
        </li>

    <?php } ?>

    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')  || $this->permission->checkPermission($this->session->userdata('permissao'),'eProduto') || $this->permission->checkPermission($this->session->userdata('permissao'),'eServico') ){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Administrativo</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eCliente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/clientes">Beneficiários</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eProduto')){ ?>
                <li><a href="<?php echo base_url()?>index.php/produtos">Abastecimento</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eServico')){ ?>
                <li><a href="<?php echo base_url()?>index.php/servicos">Códigos</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')  || $this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente') || $this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao') || $this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
        <li class="submenu <?php if(isset($menuConfiguracoes)){echo 'active open';};?>">
          <a href="#"><i class="icon icon-cog"></i> <span>Configurações</span> <span class="label"><i class="icon-chevron-down"></i></span></a>
          <ul>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cUsuario')){ ?>
                <li><a href="<?php echo base_url()?>index.php/usuarios">Usuários</a></li>
            <?php } ?><!--
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cEmitente')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/emitente">Emitente</a></li>
            <?php } ?>-->
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cPermissao')){ ?>
                <li><a href="<?php echo base_url()?>index.php/permissoes">Permissões</a></li>
            <?php } ?>
            <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'cBackup')){ ?>
                <li><a href="<?php echo base_url()?>index.php/mapos/backup">Backup</a></li>
            <?php } ?>
 
          </ul>
        </li>
    <?php } ?>
    
    
  </ul>
</div>
<div id="content">
    <?php 
    $segmento1 = $this->uri->segment(1);
   // echo $segmento;
    switch ($segmento1) {
        case "os": $seg ="Solicitação"; break;
        case 'vendas': $seg ='Lançamento'; break;               
        case 'clientes': $seg ='Beneficiário'; break;              
        case 'produtos': $seg ='Abastecimento'; break;               
        case 'servicos': $seg ='Servicos'; break;                   
        case 'mapos': $seg ='CiscoFiP'; break; 
            default: $seg = $segmento1;
    }
    ?>
  <div id="content-header">
    <div id="breadcrumb"> <a href="<?php echo base_url()?>" title="Dashboard" class="tip-bottom"><i class="icon-home"></i> Home</a> <?php if($seg != null){?><a href="<?php echo base_url().'index.php/'.$segmento1?>" class="tip-bottom" title="<?php echo ucfirst($seg);?>"><?php echo ucfirst($seg);?></a> <?php if($this->uri->segment(2) != null){?><a href="<?php echo base_url().'index.php/'.$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3) ?>" class="current tip-bottom" title="<?php echo ucfirst($this->uri->segment(2)); ?>"><?php echo ucfirst($this->uri->segment(2));} ?></a> <?php }?></div>
  </div>
  <div class="container-fluid">
    <div class="row-fluid">
      <div class="span12">
          <?php if($this->session->flashdata('error') != null){?>
                            <div class="alert alert-danger">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('error');?>
                           </div>
                      <?php }?>

                      <?php if($this->session->flashdata('success') != null){?>
                            <div class="alert alert-success">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <?php echo $this->session->flashdata('success');?>
                           </div>
                      <?php }?>
                          
                      <?php if(isset($view)){echo $this->load->view($view, null, true);}?>


      </div>
    </div>
  </div>
</div>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12"> <a href="https://" target="_blank"><?php echo date('Y'); ?> &copy; CISCOF-  Irlândio Oliveira </a></div>
</div>
<!--end-Footer-part-->


<script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script> 
<script src="<?php echo base_url();?>assets/js/matrix.js"></script> 


</body>
</html>







