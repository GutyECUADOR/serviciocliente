$(function() {

    app = {
        showResults: function (arrayData) {
        
            $('#tbodyresults').html('');
           
            arrayData.forEach(row => {
                
                let rowHTML = `
                    <tr>
                        <td>
                            ${ app.getStatus(row.estado, row.solucion)  }
                        </td>
                        <td>
                            ${ row.codigo }
                        </td>
                        <td class="issue-info">
                            <a>
                                 ${ row.titulo }
                            </a>

                            <small>
                                ${ row.problema }
                            </small>
                        </td>
                        <td>
                            ${ row.nombreCliente }
                        </td>
                        <td>
                            ${ row.nombreBodega }
                        </td>
                        <td>
                            ${ row.fecha }
                           
                        </td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i>
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu pull-right">
                                <li><a class="btn-xs btn_edit_ticket" data-codigo="${ row.codigo }"><i class="fa fa-check"></i> Ver detalle</a></li>
                                    <li><a class="btn-xs btn_finalizar_ticket" data-codigo="${ row.codigo }"><i class="fa fa-thumbs-up"></i> Finalizar</a></li>
                                  
                                </ul>
                            </div>
                        </td>
                    </tr>


                   
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
            });
    
        },
        getStatus: function(statuscode, solucion){
            if (statuscode==1 && solucion.length >1) {
                return `<span class="label label-primary">Finalizado & Solucionado</span>`;
            }else if(statuscode==0 && solucion.length >1){
                return `<span class="label label-success">Solventado en local</span>`;
            } else if(statuscode==1 && solucion.length <= 0){
                return `<span class="label label-danger">Sin solucion</span>`;
            }else{
                return `<span class="label label-warning">Pendiente</span>`;
            }
            
        },
        searchTickets: function (input) {
            $.ajax({
                url: 'ticket/gettickets/'+input,
                method: 'GET',
               
                success: function(response) {
                    console.log(response);
                    let responseJSON = JSON.parse(response);
                    console.log(responseJSON);
                   
                    toastr.success('Busqueda finalizada', 'Realizado', {timeOut: 2000});
                    app.showResults(responseJSON.data);
                },
                error: function(error) {
                    alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                },
                complete: function(data) {
                    
                }
    
            });
        },
        searchTicketByID: function (codigo) {
    
            $.ajax({
                url: 'ticket/getticket/'+codigo,
                method: 'GET',
                data: {codigo: codigo},
               
                success: function(response) {
                    console.log(response);
                    let responseJSON = JSON.parse(response);
                    console.log(responseJSON);
                    if (!responseJSON.ERROR) {
                        app.showTicket(responseJSON.data);
                    }else{
                        console.log('No se pudo cargar la informacion del ticket, cierre la ventana y reintente');
                    }
                    
                },
                error: function(error) {
                    alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                },
                complete: function(data) {
                    
                }
    
            });
        },
        showTicket: function (ticketData) {
        
            $('#ticket_titulo').html(ticketData.facturaID);
            $('#ticket_codigo').html(ticketData.codigo);
            $('#ticket_problema').html(ticketData.problema);
            $('#txt_procedimiento').val(ticketData.procedimiento);
            $('#txt_solucion').val(ticketData.solucion);
            $('#txt_autorizado').val(ticketData.autorizado);

            $('#ID_facura').html(ticketData.ID);
            $('#num_factura').html(ticketData.NUMERO);
            $('#fecha_factura').html(ticketData.FECHA);
            $('#bodega_factura_hidden').val(ticketData.codBodega);
            $('#vendedor_factura').html('('+ticketData.codVendedor +') '+ ticketData.nombreVendedor);
            $('#bodega_factura').html(ticketData.nombreBodega);
            $('#ruc_factura').html(ticketData.RUCCliente);
            $('#nombreCliente_factura').html(ticketData.nombreCliente);
           
        },
        sendNotificacion: function(email) {
            $.ajax({
                url: 'ticket/sendEmailCliente',
                method: 'GET',
                data: { email: email},
                
                success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                    console.log(responseJSON);
                    if (responseJSON.error == false) {
                        toastr.info('Correo enviado.', 'Realizado', {timeOut: 5000});
                    
                    }else if (responseJSON.error == true){
                        toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                    }

                
                },
                error: function(error) {
                    console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                    toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
                },
                complete: function(data) {
                }

            });
        }
    }

    // ON Ready
    let input = $('#txtSearch').val();
    app.searchTickets(input);

    // Events and Actions
    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "yyyy-mm-dd",
        language: "es",
        todayHighlight: true
    });

    $('#tbodyresults').on("click", ".btn_edit_ticket", function(event) {
        event.preventDefault();
        let codigo = $(this).data('codigo');
        console.log(codigo);
        app.searchTicketByID(codigo.trim());
        $('#ticket_select_hidden').val(codigo);
        $('#modal_add_solucion').modal('show');
        
    })

    
    let btnBuscar = $('#btnSearch');
    btnBuscar.click(function (event) {
        event.preventDefault();

        let input = $('#txtSearch').val();
        console.log(input)
        
        app.searchTickets(input);

    })


    $("#tabla_tickets").on('click', '.btn_finalizar_ticket', function(e) {
        let codigo = $(this).data("codigo");
        console.log(codigo);
 
        if (confirm("Confirme finalizar el ticket, esto enviara una notificacion al cliente.")) {
            $.ajax({
                url: 'ticket/chengestatusticket/1',
                method: 'GET',
                data: { id: codigo},
                
                success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                    if (responseJSON.error == false) {
                        toastr.success(responseJSON.message, 'Realizado', {timeOut: 3000});
                        let emailtest = 'gutiecuador@gmail.com';
                        app.sendNotificacion(emailtest);
                    
                    }else if (responseJSON.error == true){
                        toastr.error(responseJSON.message, 'Error', {timeOut: 3000});
                    }

                
                },
                error: function(error) {
                    console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                    toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
                },
                complete: function(data) {
                    let input = $('#txtSearch').val();
                    app.searchTickets(input);
                }

            });
        }

        
    });
    
    let updateForm = $('#updateticket');
    updateForm.submit(function (event) {
        event.preventDefault();

        let ticketSeleccionado = $('#ticket_select_hidden').val();

        let input = $('#txtSearch').val();
        let data = updateForm.serializeArray();
        data.push({name: 'ticket', value:ticketSeleccionado});

        $.ajax({
            url: 'ticket/update',
            method: 'POST',
            data: data,

            success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
                console.log(data);
               
                if (responseJSON.error == false) {
                    toastr.success(responseJSON.message, 'Realizado', {timeOut: 3000});
                    let input = $('#txtSearch').val();
                    app.searchTickets(input);
                    updateForm.trigger("reset");
                    
                }else if (responseJSON.error == true){
                    toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                }
                
               
               
            },
            error: function(error) {
                alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
            },
            complete: function(data) {
                $('#modal_add_solucion').modal('hide');
            }

            });

    });



});