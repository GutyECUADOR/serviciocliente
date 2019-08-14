<?php
?>

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
                            <?php  echo 'DataBase, '. $this->session->userdata('codedatabase'); ?>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>

                    <?php
                        if ($this->session->userdata('logged_in')) {  
                    ?>
                    <li class="">
                        <a href="#"><i class="fa fa-table"></i> <span class="nav-label">Tickets</span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url().'facturas'?>">Buscar factura</li>
                            <li><a href="<?php echo base_url().'ticket'?>">Lista de tickets</li>
                            
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
                            
                                <li>
                                    <span class="m-r-sm text-muted welcome-message">
                                        <?php 
                                         if ($this->session->userdata('logged_in')) { 
                                            echo 'Bienvenido, '. $this->session->userdata('nombreusuario') .'('. $this->session->userdata('user_role').')' ;
                                         }else {
                                            echo 'Bienvenido, invitado';
                                         }
                                        
                                        
                                        ?>
                                    </span>
                                </li>
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
                        <h2>Busqueda de Facturas</h2>
                        
                            <strong>Facturas realizadas - Winfenix</strong>
                           
                    </div>
                    <div class="col-lg-2">

                    </div>
                </div>

                <div class="wrapper wrapper-content  animated fadeInRight">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5>Lista de Items</h5>
                                <div class="ibox-tools">
                                   <!--  <a href="" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_new_ticket">Crear nuevo ticket</a> -->
                                </div>
                            
                                <!-- start modal -->
                                <div class="modal inmodal" id="modal_new_ticket" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                            <form id="registerticket" action="#" autocomplete="off">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                    <i class="fa fa-user modal-icon"></i>
                                                    <h4 class="modal-title">Nuevo Ticket</h4>
                                                    <small class="font-bold">Registe a continuación la información, sobre factura e inconveniente del producto.</small>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="col-lg-12">
                                                        <div class="ibox float-e-margins">
                                                            <div class="ibox-title">
                                                                <h5>Factura # <small id="ID_facura" class="m-l-sm"></small></h5>
                                                                <div id="div_checkticket">
                                                                    
                                                                </div>
                                                                <div class="ibox-tools">
                                                                    <a class="collapse-link">
                                                                        <i class="fa fa-chevron-up"></i>
                                                                    </a>
                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="ibox-content" style="display: block;">
                                                                
                                                                <ul class="sortable-list connectList agile-list ui-sortable" id="todo">
    
                                                                    <li class="info-element">
                                                                        <p><strong ># Documento: </strong><span id="num_factura"><span> </p>
                                                                        <p><strong >Fecha: </strong><span id="fecha_factura"><span> </p>
                                                                        <p><strong >Bodega: </strong><span id="bodega_factura"><span> </p>
                                                                        <p><strong >Vendedor: </strong><span id="vendedor_factura"><span> </p>
                                                                        <input id="bodega_factura_hidden" name="bodega_factura_hidden" type="hidden" value="">
                                                                        <p><strong >RUC:</strong><span id="ruc_factura"><span> </p>
                                                                        <p><strong >Cliente: </strong><span id="nombreCliente_factura"><span> </p>
                                                                    
                                                                    </li>
                                                                    
                                                                </ul>

                                                                
                                                                <table class="table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Codigo</th>
                                                                            <th>Producto</th>
                                                                            <th>Cantidad</th>
                                                                            <th>Precio</th>
                                                                            <th>Descuento</th>
                                                                            <th>IVA</th>
                                                                            <th>Precio Total</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="table_VENMOV">

                                                                        <!-- Render items aqui-->
                                                                   
                                                                    </tbody>
                                                                </table>
                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>

                                                        <div class="form-group">
                                                            <label>ID Factura</label> 
                                                            <input type="text" id="facturaID" name="facturaID" placeholder="992014XXX00000XXX" class="form-control" required readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Referencia (Medio a travez del cual se notifica)</label> 
                                                            
                                                            <select class="form-control m-b" id="referencia" name="referencia">
                                                                <option value='RedSocial'>Rodes Sociales Facebook, Twitter, Instagram, etc.</option>
                                                                <option value='Llamada'>Llamada telefonica</option>
                                                                <option value='VisitaLocal'>Visita a locales de KAO</option>
                                                            </select>
                                                       
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Problema</label> 
                                                            <input type="text" id="titulo" name="titulo" placeholder="Descripcion rapida del problema" class="form-control" maxlength="70" required>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Detalle del Problema</label> 
                                                            <textarea class="form-control" id="txt_problema" name="txt_problema" rows="3" placeholder="Descripcion detallada del problema" maxlength="200" required></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Procedimiento a seguir</label> 
                                                            <textarea class="form-control" id="txt_procedimiento" name="txt_procedimiento" rows="3" placeholder="Indique como se procederá a solucionar" maxlength="200" required></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Solucion</label> 
                                                            <textarea class="form-control" id="txt_solucion" name="txt_solucion" rows="3" placeholder="Dejar en blanco si no se ha dado solucion de momento." maxlength="200"></textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Autorizado por</label> 
                                                            <input type="text" class="form-control" id="txt_autorizado" name="txt_autorizado" rows="3" placeholder="Quien autoriza el proceso y solucion." maxlength="50">
                                                        </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Registrar ticket</button>
                                                </div>
                                            </form>   
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal -->

                            </div>
                            <div class="ibox-content">

                                <div class="m-b-lg">
                     
                                    <div class="input-group">
                                        <input style="width: 70% !important;" type="text" id="txtSearch" placeholder="Nombre del cliente o RUC" class="form-control">
                                        <select style="width: 30% !important;" id="selectEmpresa" class="form-control">
                                            <option value='002'>Region Sierra (KIND)</option>
                                            <option value='006'>Region Costa (SCK)</option>
                                            <option value='001'>Impor_KAO</option>
                                            <option value='008'>Modelo</option>
                                            <option value='009'>Modelo IMPKAO</option>
                                            
                                        </select>
                                        <span class="input-group-btn">
                                            <button id="btnSearch" type="button" class="btn btn-primary"> Buscar</button>
                                        </span>
                                    </div>

                                    

                                </div>

                                <div class="">
                                    <table class="table table-hover table-striped">
                                        <tbody id="tbodyresults">
                                        <thead>
                                            <tr>
                                                <th>ID Factura</th>
                                                <th>Fecha Venta</th>
                                                <th>RUC</th>
                                                <th>Cliente</th>
                                                <th>Local</th>
                                                <th>Cod Producto</th>
                                                <th>Nombre del Producto</th>
                                            </tr>
                                        </thead>
                                       
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
                        <strong>Copyright</strong> Kao Sport &copy; <?php echo date('Y')?>
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
    <script src="<?php echo base_url()?>assets/js/pages/ticketlist_searchfact.js"></script>
   
</body>

</html>
