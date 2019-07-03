$(function() {

    app = {
        showResults: function (arrayData) {
        
            $('#tbodyresults').html('');
           
            arrayData.forEach(row => {
                
                let rowHTML = `
                    <tr>
                        <td>
                            ${ row.idFactura  }
                        </td>
                  
                        <td>
                            ${ row.fechaVenta.slice(0,10) }
                        </td>
                        <td>
                            ${ row.rucCliente }
                        </td>

                        <td>
                            ${ row.nombreCliente }
                        </td>
                        <td>
                            ${ row.nombreBodega }
                         </td>
                        <td>
                            ${ row.codProducto }
                        </td>
                       
                        <td>
                            ${ row.nombreProducto }
                        
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right">
                                    <li><a class="btn-xs btn_generarticketByID" data-codigo="${ row.idFactura  }"><i class="fa fa-ticket"></i> Crear ticket a la factura</a></li>
           
                                </ul>
                            </div>
                        </td>
                    </tr>


                   
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
            });
    
        },
        showFactura: function (facturaData, movimientos) {
        
            $('#ID_facura').html(facturaData.ID);
            $('#num_factura').html(facturaData.NUMERO);
            $('#fecha_factura').html(facturaData.FECHA);
            $('#bodega_factura_hidden').val(facturaData.codBodega);
            $('#vendedor_factura').html('('+facturaData.codVendedor +') '+ facturaData.nombreVendedor);
            $('#bodega_factura').html(facturaData.nombreBodega);
            $('#ruc_factura').html(facturaData.RUCCliente);
            $('#nombreCliente_factura').html(facturaData.nombreCliente);
            $('#div_checkticket').html(app.checkExistTicket(facturaData.ticket));


            $('#table_VENMOV').html('');
           
            movimientos.forEach(row => {
                
                let rowHTML = `
                    <tr>
                        <td>
                            ${ row.CODIGO  }
                        </td>
                        <td>
                            ${ row.Nombre }
                        </td>
                        <td>
                            ${ row.CANTIDAD }
                        </td>
                        <td>
                            ${ row.PRECIO}
                        </td>
                        <td>
                            ${ row.DESCU }
                         </td>
                        <td>
                         ${ row.IVA }
                        </td>
                        <td>
                            ${ row.PRECIOTOT }
                        </td>
                       
                    </tr>                   
                        `;
    
                $('#table_VENMOV').append(rowHTML);
    
            });
    
          
        },
        searchFacturas: function (search, dbcode) {
            $.ajax({
                url: 'facturas/getfacturas',
                method: 'GET',
                data: {search: search, dbcode: dbcode},
               
                success: function(response) {
                    console.log(response);
                    let responseJSON = JSON.parse(response);
                    console.log(responseJSON);
                   
                    if (!responseJSON.ERROR) {
                        toastr.success('Busqueda finalizada', 'Realizado', {timeOut: 2000});
                        app.showResults(responseJSON.data);
                    }else{
                        toastr.error('No se pudo completar la busqueda', 'Error', {timeOut: 2000});
                    }

                    
                },
                error: function(error) {
                    alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                },
                complete: function(data) {
                    
                }
    
            });
        },
        searchFacturaByID: function (ID, dbcode) {
            $.ajax({
                url: 'facturas/getfactura',
                method: 'GET',
                data: {ID: ID, dbcode: dbcode},
               
                success: function(response) {
                    console.log(response);
                    let responseJSON = JSON.parse(response);
                    console.log(responseJSON);
                    if (!responseJSON.ERROR) {
                        app.showFactura(responseJSON.documento, responseJSON.movimientos);
                    }else{
                        console.log('No se pudo cargar la informacion de factura');
                    }
                    
                },
                error: function(error) {
                    alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                },
                complete: function(data) {
                    
                }
    
            });
        },
        checkExistTicket: function (ticketCODE) {
            if (ticketCODE) {
                return  `<span class="label label-warning">Atencion, se ha detectado que ya existe un ticket a esta factura: <strong>${ ticketCODE }</strong></span> `;
            }else if( ticketCODE == null){
                return '';
            }
        }
    }

    // ON Ready
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "yyyy-mm-dd",
        language: "es",
        todayHighlight: true
    });

    // Events and Actions
   
    let btnBuscar = $('#btnSearch');
    btnBuscar.click(function (event) {
        event.preventDefault();

        let input = $('#txtSearch').val();
        let dbcode = $('#selectEmpresa').val();
        console.log(input)
        

        if (input.length <= 0) {
            toastr.error('Indique parametros de busqueda', 'Atencion', {timeOut: 2000});
            return;
        }

        app.searchFacturas(input, dbcode);

    })

    let registerForm = $('#registerticket');
    registerForm.submit(function (event) {
        event.preventDefault();

        let bodega = $('#bodega_factura_hidden').val();
        let empresa = $('#selectEmpresa').val();

        let data = registerForm.serializeArray();
        data.push({name: 'bodega', value:bodega});
        data.push({name: 'empresa', value:empresa});

        $.ajax({
            url: 'ticket/register',
            method: 'POST',
            data: data,

            success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
                console.log(data);
               
                if (responseJSON.error == false) {
                    toastr.success(responseJSON.message + 'ID de registro: ' + responseJSON.nuevo_id, 'Realizado', {timeOut: 5000});
                    registerForm.trigger("reset");
                }else if (responseJSON.error == true){
                    toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                }
                
               
               
            },
            error: function(error) {
                alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
            },
            complete: function(data) {
                $('#modal_new_ticket').modal('hide');
            }

            });

    })


    let txt_facturaID = $('#facturaID');
    txt_facturaID.change(function (event) {
        event.preventDefault();

        let ID = $(this).val();
        let dbcode = $('#selectEmpresa').val();
        
        if (ID.length <= 0) {
            toastr.warning('El codigo de la factura no puede ser nulo', 'Atencion', {timeOut: 2000});
            return;
        }

        app.searchFacturaByID(ID, dbcode);

    })


    
    $('#tbodyresults').on("click", ".btn_generarticketByID", function(event) {
        event.preventDefault();
        let ID = $(this).data('codigo');
        let dbcode = $('#selectEmpresa').val();
        console.log(ID);
        $('#modal_new_ticket').modal('show');
        $('#facturaID').val(ID);
        app.searchFacturaByID(ID, dbcode);

    })

    

});