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
                                    <li><a class="btn-xs btn_generarticketByID" data-codigo="${ row.idFactura  }"><i class="fa fa-eye"></i> Crear ticket a la factura</a></li>
           
                                </ul>
                            </div>
                        </td>
                    </tr>


                   
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
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


    
    $('#tbodyresults').on("click", ".btn_generarticketByID", function(event) {
        event.preventDefault();
        let ID = $(this).data('codigo');
        console.log(ID);
        $('#modal_new_ticket').modal('show');
        $('#facturaID').val(ID);
        

    })

    

});