$(function() {

    var inscritosList = [];

    $('.input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "yyyy-mm-dd",
        language: "es",
        todayHighlight: true
    });

    let registerForm = $('#btnSearch');
    registerForm.click(function (event) {
        let input = $('#txtSearch').val();
        event.preventDefault();

        if (input.length <= 0) {
            toastr.error('Indique parametros de busqueda', 'Atencion', {timeOut: 2000});
            return;
        }

        $.ajax({
            url: 'getinscrito/'+input,
            method: 'GET',
           
            success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
               
                toastr.success('Busqueda finalizada', 'Realizado', {timeOut: 2000});
                inscritosList = responseJSON;
                app.displayData();
            },
            error: function(error) {
                alert('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
            },
            complete: function(data) {
                
            }

        });

    })

    app = {
        displayData: function () {
        
            let rows = inscritosList;
            console.log(rows);
    
            $('#tbodyresults').html('');
           
            rows.forEach(row => {
                
                let rowHTML = `
                    <div class="col-lg-3 animated fadeIn">
                        <div class="contact-box center-version">
                            <a>
                                <h3 class="m-b-xs"><strong>${ row.nombres +' '+ row.apellidos }</strong></h3>

                                <div class="font-bold">${ row.cargo ? row.cargo  + '<br>' : '' }</div>
                                <address class="m-t-md">
                                  
                                    <i class="fa fa-envelope"></i> ${ row.correo ? row.correo  + '<br>' : '' }
                                    ${ row.telefono ?  ' <i class="fa fa-phone"></i> ' + row.telefono  + '<br>' : '' }
                                    ${ row.celular ? ' <i class="fa fa-phone"></i> ' + row.celular  + '<br>' : '' }
                                </address>

                            </a>
                            <div class="contact-box-footer">
                            <strong>${ row.nombreinstitucion ? row.nombreinstitucion + '</strong><br>' : '' }
                            ${ row.ruc ? row.ruc + '<br>' : ''  }
                            ${ row.contactoconta ? row.contactoconta  + '<br>' : ''  }
                            ${ row.emailconta ? row.emailconta  + '<br>' : ''  }
                            ${ row.formapago ? row.formapago  + '<br>' : ''  }
                            ${ row.observaciones ? row.observaciones  + '<br>' : ''  }
                            
                                <div class="m-t-xs btn-group">
                                   
                                    <a href="mailto:${ row.correo }" class="btn btn-xs btn-white"><i class="fa fa-envelope"></i> Email</a>
                                </div>
                            </div>

                        </div>
                    </div>
                        `;
    
                $('#tbodyresults').append(rowHTML);
    
            });
    
        }
    }
});