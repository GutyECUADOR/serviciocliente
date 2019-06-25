$(function() {

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
                    toastr.success(responseJSON.message, 'Realizado', {timeOut: 5000});
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

    })

    app = {
        showResults: function (arrayData) {
        
            $('#tbodyresults').html('');
           
            arrayData.forEach(row => {
                
                let rowHTML = `
                    <tr>
                        <td>
                            ${ app.getStatus(row.estado)  }
                        </td>
                        <td class="issue-info">
                            <a href="#">
                                ${ row.codigo } - ${ row.titulo }
                            </a>

                            <small>
                                ${ row.descripcion }
                            </small>
                        </td>
                        <td>
                            ${ row.nombreCliente }
                        </td>
                        <td>
                            ${ 'Kindred' }
                        </td>
                        <td>
                            ${ row.nombreBodega }
                        </td>
                        <td>
                            <span class="pie"> ${ row.fecha }</span>
                           
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


                   
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
            });
    
        },
        getStatus: function(statuscode){
            if (statuscode==1) {
                return `<span class="label label-primary">Solucionado</span>`;
            }else{
                return `<span class="label label-warning">Pendiente</span>`;
            }
            
        }
    }

});