<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kao Sport | Tickets </title>

    <link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Plugins style -->
    <link href="<?php echo base_url()?>assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/plugins/datapicker/datepicker3.css" rel="stylesheet">

    <link href="<?php echo base_url()?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url()?>assets/css/style.css" rel="stylesheet">

    <link href="<?php echo base_url()?>assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> 
                            <span>
                                <img src="http://kaosportcenter.com/img/logoKAOdark.png" height="25px" alt="logo">
                            </span>
                            
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>

                    <?php
                        if ($this->session->userdata('logged_in')) {  
                    ?>
                    <li class="">
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Inscripciones</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url().'registro/nuevo'?>">Nuevo registro</li>
                            <li><a href="<?php echo base_url().'registro'?>">Lista de inscritos</li>
                            <li><a href="<?php echo base_url().'registro/detalle'?>">Detalle inscritos</li>
                            
                        </ul>
                    </li>
                    <?php
                        } // Cierre de if
                    ?>
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
                            
                                <?php
                                    if (!$this->session->userdata('logged_in')) {  
                                ?>
                                    <li>
                                        <a href="<?php echo base_url().'login'?>">
                                            <i class="fa fa-sign-out"></i> Acceder
                                        </a>
                                    </li>
                                    <?php
                                        }else { // 
                                           
                                         
                                    ?>
                                    <li>
                                        <a href="<?php echo base_url().'login/logout'?>">
                                            <i class="fa fa-sign-out"></i> Cerrar Sesion
                                        </a>
                                    </li>
                                    <?php
                                        } // Cierre de if
                                    ?>
                            </ul>

                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-10">
                        <h2>Tickets - Servicio al cliente</h2>
                        
                            <strong>Lista de incidencias en los locales de KAO Sport</strong>
                           
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>

                <div class="wrapper wrapper-content  animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Lista de tickets</h5>
                                <div class="ibox-tools">
                                    <a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_new_ticket">Crear nuevo ticket</a>
                                </div>

                                <!-- start modal -->
                                <div class="modal inmodal" id="modal_new_ticket" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content animated fadeIn">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                <i class="fa fa-user modal-icon"></i>
                                                <h4 class="modal-title">Nuevo Ticket</h4>
                                                <small class="font-bold">Registe a continuación la información, sobre factura e inconveniente del producto.</small>
                                            </div>
                                            <div class="modal-body">

                                                    <div class="form-group">
                                                        <label>Empresa</label> 
                                                        <select class="form-control m-b" name="account">
                                                            <option>Kindred</option>
                                                            <option>Comercializadora Kinsman</option>
                                                        </select>
                                                    </div>
                                              
                                                    <div class="form-group">
                                                        <label>ID Factura</label> 
                                                        <input type="text" placeholder="Codigo de Factura" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Titulo</label> 
                                                        <input type="text" placeholder="Descripcion rapida del problema" class="form-control">
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Descripcion del inconveniente y acuerdo</label> 
                                                        <textarea class="form-control" name="textarea" rows="5" placeholder="Descripcion detallada del problema"></textarea>
                                                    </div>


                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                                <button type="button" class="btn btn-primary">Registrar ticket</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal -->

                            </div>
                            <div class="ibox-content">

                                <div class="m-b-lg">

                                    <div class="input-group">
                                        <input type="text" placeholder="Nombre del cliente o # de ticket..." class=" form-control">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary"> Buscar</button>
                                        </span>
                                    </div>
                                    <div class="m-t-md">

                                        
                                        <strong>0 tickers pendientes.</strong>



                                    </div>

                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover issue-tracker">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <span class="label label-primary">Solucionado</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-23
                                                </a>

                                                <small>
                                                    This is issue with the coresponding note
                                                </small>
                                            </td>
                                            <td>
                                                Adrian Novak
                                            </td>
                                            <td>
                                                12.02.2015 10:00 am
                                            </td>
                                            <td>
                                                <span class="pie">0.52,1.041</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <div class="dropdown">
                                                    <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i>
                                                    <span class="caret"></span></button>
                                                    <ul class="dropdown-menu pull-right">
                                                        <li><a class="btn-xs btn_confirm_asistencia" data-codigo="68"><i class="fa fa-eye"></i> Ver detalle</a></li>
                                                        <li><a class="btn-xs btn_confirm_asistencia" data-codigo="68"><i class="fa fa-thumbs-up"></i> Solucionado</a></li>
                                                        <li><a class="btn-xs btn_cancel_asistencia" data-codigo="68"><i class="fa fa-thumbs-down"></i> Sin solucion</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-primary">Solucionado</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-17
                                                </a>

                                                <small>
                                                    Desktop publishing packages and web page editors now use Lorem Ipsum as their default model text
                                                </small>
                                            </td>
                                            <td>
                                                Anna Smith
                                            </td>
                                            <td>
                                                10.02.2015 05:32 am
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Rag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-primary">Solucionado</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-12
                                                </a>

                                                <small>
                                                    It is a long established fact that a reader will be
                                                </small>
                                            </td>
                                            <td>
                                                Anthony Jackson
                                            </td>
                                            <td>
                                                02.03.2015 06:02 am
                                            </td>
                                            <td>
                                                <span class="pie">1,2</span>
                                                1d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-primary">Solucionado</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-11
                                                </a>

                                                <small>
                                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                                                </small>
                                            </td>
                                            <td>
                                                Monica Proven
                                            </td>
                                            <td>
                                                01.10.2015 11:02 pm
                                            </td>
                                            <td>
                                                <span class="pie">4,2</span>
                                                3d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Rag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-07
                                                </a>

                                                <small>
                                                    Always free from repetition, injected humour, or non-characteristic words etc.
                                                </small>
                                            </td>
                                            <td>
                                                Alex Ferguson
                                            </td>
                                            <td>
                                                28.11.2015 05:10 pm
                                            </td>
                                            <td>
                                                <span class="pie">1,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-07
                                                </a>

                                                <small>
                                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit am
                                                </small>
                                            </td>
                                            <td>
                                                Mark Conor
                                            </td>
                                            <td>
                                                18.09.2015 06:20 pm
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                3d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-06
                                                </a>

                                                <small>
                                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit am
                                                </small>
                                            </td>
                                            <td>
                                                Carol Jackson
                                            </td>
                                            <td>
                                                11.03.2015 07:30 pm
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-05
                                                </a>

                                                <small>
                                                    Content here, content here', making it look like readable English. Many desktop
                                                </small>
                                            </td>
                                            <td>
                                                Carol Jackson
                                            </td>
                                            <td>
                                                05.04.2015 08:40 pm
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-04
                                                </a>

                                                <small>
                                                    Virginia, looked up one of the more obscure Latin words, consectetur
                                                </small>
                                            </td>
                                            <td>
                                                Monica Smith
                                            </td>
                                            <td>
                                                10.06.2014 08:10 pm
                                            </td>
                                            <td>
                                                <span class="pie">5,7</span>
                                                4d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Cag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-warning">Pendiente</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-03
                                                </a>

                                                <small>
                                                    Injected humour, or randomised words which don't l
                                                </small>
                                            </td>
                                            <td>
                                                Anna Johnson
                                            </td>
                                            <td>
                                                13.05.2014 09:20 pm
                                            </td>
                                            <td>
                                                <span class="pie">2,7</span>
                                                3d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Cag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-44
                                                </a>

                                                <small>
                                                    This is issue with the coresponding note
                                                </small>
                                            </td>
                                            <td>
                                                Adrian Novak
                                            </td>
                                            <td>
                                                12.02.2015 10:00 am
                                            </td>
                                            <td>
                                                <span class="pie">0.52,1.041</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Rag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-41
                                                </a>

                                                <small>
                                                    Desktop publishing packages and web page editors now use Lorem Ipsum as their default model text
                                                </small>
                                            </td>
                                            <td>
                                                Anna Smith
                                            </td>
                                            <td>
                                                10.02.2015 05:32 am
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Rag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-34
                                                </a>

                                                <small>
                                                    It is a long established fact that a reader will be
                                                </small>
                                            </td>
                                            <td>
                                                Anthony Jackson
                                            </td>
                                            <td>
                                                02.03.2015 06:02 am
                                            </td>
                                            <td>
                                                <span class="pie">1,2</span>
                                                1d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-46
                                                </a>

                                                <small>
                                                    There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                                                </small>
                                            </td>
                                            <td>
                                                Monica Proven
                                            </td>
                                            <td>
                                                01.10.2015 11:02 pm
                                            </td>
                                            <td>
                                                <span class="pie">4,2</span>
                                                3d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Rag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-51
                                                </a>

                                                <small>
                                                    Always free from repetition, injected humour, or non-characteristic words etc.
                                                </small>
                                            </td>
                                            <td>
                                                Alex Ferguson
                                            </td>
                                            <td>
                                                28.11.2015 05:10 pm
                                            </td>
                                            <td>
                                                <span class="pie">1,2</span>
                                                2d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="label label-danger">Sin solucion</span>
                                            </td>
                                            <td class="issue-info">
                                                <a href="#">
                                                    ISSUE-52
                                                </a>

                                                <small>
                                                    Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit am
                                                </small>
                                            </td>
                                            <td>
                                                Mark Conor
                                            </td>
                                            <td>
                                                18.09.2015 06:20 pm
                                            </td>
                                            <td>
                                                <span class="pie">3,2</span>
                                                3d
                                            </td>
                                            <td class="text-right">
                                                <button class="btn btn-white btn-xs"> Tag</button>
                                                <button class="btn btn-white btn-xs"> Mag</button>
                                                <button class="btn btn-white btn-xs"> Dag</button>
                                            </td>
                                        </tr>
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
                        <strong>Copyright</strong> Asobanca &copy; 2019
                    </div>
                </div>
            </div>

        

    </div>


    <!-- Mainly scripts -->
    <script src="<?php echo base_url()?>assets/js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url()?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

  
    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url()?>assets/js/inspinia.js"></script>
    <script src="<?php echo base_url()?>assets/js/plugins/pace/pace.min.js"></script>

    <!-- Toastr script -->
    <script src="<?php echo base_url()?>assets/js/plugins/toastr/toastr.min.js"></script>

    <!-- Data picker -->
   <script src="<?php echo base_url()?>assets/js/plugins/datapicker/bootstrap-datepicker.js"></script>

    <!-- Page-Level Scripts -->
    <script src="<?php echo base_url()?>assets/js/pages/registerform.js"></script>
   
</body>

</html>
