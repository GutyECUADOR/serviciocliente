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
                            ${ row.fechaVenta }
                        </td>
                        <td>
                            ${ row.rucCliente }
                        </td>

                        <td>
                            ${ row.nombreCliente }
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
                                    <li><a class="btn-xs btn_copy_data" data-codigo="68"><i class="fa fa-eye"></i> Copiar ID Factura</a></li>
           
                                </ul>
                            </div>
                        </td>
                    </tr>


                   
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
            });
    
        },
        searchFacturas: function (input) {
            $.ajax({
                url: 'facturas/getfacturas/'+input,
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
        console.log(input)
        

        if (input.length <= 0) {
            toastr.error('Indique parametros de busqueda', 'Atencion', {timeOut: 2000});
            return;
        }

        app.searchFacturas(input);

    })

    

});