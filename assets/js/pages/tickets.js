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
                            <a href="#">
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
                                <li><a class="btn-xs btn_add_solucion" data-codigo="${ row.codigo }"><i class="fa fa-check"></i> Ver detalle</a></li>
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
        }
    }


    // ON Ready
    app.searchTickets('');

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

    let registerForm = $('#registerticket');
    registerForm.submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'ticket/register',
            method: 'POST',
            data: registerForm.serialize(),

            success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
                console.log(registerForm.serialize());
               
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
                
            }

            });

    })


    let btnBuscar = $('#btnSearch');
    btnBuscar.click(function (event) {
        event.preventDefault();

        let input = $('#txtSearch').val();
        console.log(input)
        

        if (input.length <= 0) {
            toastr.error('Indique parametros de busqueda', 'Atencion', {timeOut: 2000});
            return;
        }

        app.searchTickets(input);

    })

    $('#tbodyresults').on("click", ".btn_add_solucion", function(event) {
        event.preventDefault();
        let ID = $(this).data('codigo');
        let dbcode = $('#selectEmpresa').val();
        console.log(ID);
        $('#modal_add_solucion').modal('show');
       /*  $('#facturaID').val(ID);
        app.searchFacturaByID(ID, dbcode); */

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
                        toastr.success(responseJSON.message, 'Realizado', {timeOut: 5000});
                    
                    }else if (responseJSON.error == true){
                        toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                    }

                
                },
                error: function(error) {
                    console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                    toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
                },
                complete: function(data) {
                app.searchTickets('');
                }

            });
        }

        
     })
    

});