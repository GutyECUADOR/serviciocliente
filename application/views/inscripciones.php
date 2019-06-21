<?php defined('BASEPATH') OR exit('No direct script access allowed');

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aso. Bancos | Inscripciones</title>

    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Plugins style -->
    <link href="<?php echo base_url()?>assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                               
                                <img src="http://asobanca.org.ec/sites/default/files/asobanca.png" height="25px" alt="logo">
                                </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->session->userdata('username')?></strong>
                                </span> <span class="text-muted text-xs block">Aso. Bancos</span> </span> </a>
                            
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    
                    <li class="">
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Inscripciones</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url().'registro/nuevo'?>">Nuevo registro</li>
                            <li><a href="<?php echo base_url().'registro'?>">Lista de inscritos</li>
                            <li><a href="<?php echo base_url().'registro/detalle'?>">Detalle inscritos</li>
                           
                        </ul>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
           
        </div>
            <ul class="nav navbar-top-links navbar-right">
              
                <li>
                    <a href="<?php echo base_url().'login/logout'?>">
                        <i class="fa fa-sign-out"></i> Cerrar Sesion
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Inscripciones</h2>
                    
                </div>
                <div class="col-lg-2">

                </div>
        </div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lista de inscritos</h5>
                        <div class="ibox-tools">
                            
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a id='btn_loaddata' href="#">Actualizar datos</a>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table id="tabla_inscripciones" class="table table-striped table-bordered table-hover" >
                    <thead>
                    <tr>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Cargo</th>
                        <th>Correo</th>
                        <th>Institucion</th>
                        <th>Estado</th>
                        <th>Asistencia</th>
                        <th>Pago</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        
                    
                    </tbody>
                    </table>
                    </div>

                    </div>
                </div>
            </div>
            </div>
           
        </div>

        <div class="footer">
                <div class="pull-right">
                   
                </div>
                <div>
                    <strong>Copyright</strong> AsoBancos &copy; 2019
                </div>
        </div>

        </div>
    </div>


    <!-- Mainly scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  

    <script src="<?php echo base_url()?>assets/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url()?>assets/js/inspinia.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/pace/pace.min.js"></script>
    
    <!-- Toastr script -->
    <script src="<?php echo base_url()?>assets/js/plugins/toastr/toastr.min.js"></script>

    <!-- Page-Level Scripts -->
    <script src="<?php echo base_url()?>assets/js/pages/inscripciones.js"></script>


</body>

</html>
