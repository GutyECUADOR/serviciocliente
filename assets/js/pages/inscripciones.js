
$(function() {

    var tablainscripciones = $('#tabla_inscripciones').DataTable({
        ajax: 'registro/getinscritos',
        columns: [  
            {"data" : "nombres"},
            {"data" : "apellidos"},
            {"data" : "cargo"},
            {"data" : "correo"},
            {"data" : "nombreinstitucion"},
            {"data" : "estado"},
            { 
                "data": null, 
                "render": function(data,type,row) { 
                    if (data["asistencia"]==1) {
                        return '<span class="badge badge-primary">Confirmado</span>';
                    }else{
                        return '<span class="badge">Inscrito</span>';
                    }
                    
                }
            },
            { 
                "data": null, 
                "render": function(data,type,row) { 
                    if (data["pago"]==1) {
                        return '<span class="badge badge-primary">Pago realizado</span>';
                    }else{
                        return '<span class="badge">Sin cancelar</span>';
                    }
                    
                }
            },
            {
                "mData": null,
                "bSortable": false,
               "mRender": function (data) { 
                 
                    return `
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle btn-sm" type="button" data-toggle="dropdown"><i class="fa fa-cog"></i>
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right">
                            <li><a class="btn-xs btn_confirm_asistencia" data-codigo="${data.id}"><i class="fa fa-thumbs-up"></i> Confirmar Asistencia</a></li>
                            <li><a class="btn-xs btn_cancel_asistencia" data-codigo="${data.id}"><i class="fa fa-thumbs-down"></i> Cancelar Asistencia</a></li>
                            <li><a class="btn-xs btn_confirm_pago" data-codigo="${data.id}"><i class="fa fa-check-square"></i> Confirmar Pago</a></li>
                            <li><a class="btn-xs btn_cancel_pago" data-codigo="${data.id}"><i class="fa fa-times-circle"></i> Cancelar Pago</a></li>
                        </ul>
                    </div>
                    `;
                }
            }
        ],
        "bPaginate": true,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "language": {
            "search": "Buscar:",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
              }
        },
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [
            {extend: 'excel', title: 'registros'},
            {extend: 'pdf', title: 'registros'}
        ]

    });

   
    let btnrefresh = $('#btn_loaddata');
    btnrefresh.click(function (event) {
        tablainscripciones.ajax.reload();

    })
    
    
    $("#tabla_inscripciones").on('click', '.btn_confirm_asistencia', function(e) {
       let codigo = $(this).data("codigo");
       console.log(codigo);

        $.ajax({
            url: 'registro/updateasistencia/1',
            method: 'GET',
            data: { id: codigo},
            
            success: function(response) {
                console.log(response);
                toastr.success('Se actualizo '+ response +' registro(s) correctamente.', 'Realizado', {timeOut: 2000})
                tablainscripciones.ajax.reload();
            },
            error: function(error) {
                console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
            },
            complete: function(data) {
               
            }

        });
       
    })

    $("#tabla_inscripciones").on('click', '.btn_cancel_asistencia', function(e) {
        let codigo = $(this).data("codigo");
        console.log(codigo);
 
         $.ajax({
             url: 'registro/updateasistencia/0',
             method: 'GET',
             data: { id: codigo},
             
             success: function(response) {
                 console.log(response);
                 toastr.success('Se actualizo '+ response +' registro(s) correctamente.', 'Realizado', {timeOut: 2000})
                 tablainscripciones.ajax.reload();
             },
             error: function(error) {
                 console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                 toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
             },
             complete: function(data) {
                
             }
 
         });
        
    })

    $("#tabla_inscripciones").on('click', '.btn_confirm_pago', function(e) {
        let codigo = $(this).data("codigo");
        console.log(codigo);
 
         $.ajax({
             url: 'registro/updatepago/1',
             method: 'GET',
             data: { id: codigo},
             
             success: function(response) {
                
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
               
                if (responseJSON.error == false) {
                    toastr.success(responseJSON.message, 'Realizado', {timeOut: 5000});
                  
                }else if (responseJSON.error == true){
                    toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                }
                
                tablainscripciones.ajax.reload();
             },
             error: function(error) {
                 console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                 toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
             },
             complete: function(data) {
                
             }
 
         });
        
    })

    $("#tabla_inscripciones").on('click', '.btn_cancel_pago', function(e) {
        let codigo = $(this).data("codigo");
        console.log(codigo);
 
         $.ajax({
             url: 'registro/updatepago/0',
             method: 'GET',
             data: { id: codigo},
             
             success: function(response) {
                console.log(response);
                let responseJSON = JSON.parse(response);
                console.log(responseJSON);
               
                if (responseJSON.error == false) {
                    toastr.success(responseJSON.message, 'Realizado', {timeOut: 5000});
                  
                }else if (responseJSON.error == true){
                    toastr.error(responseJSON.message, 'Error', {timeOut: 5000});
                }
                 tablainscripciones.ajax.reload();
             },
             error: function(error) {
                 console('No se pudo completar la operación. #' + error.status + ' ' + error.statusText, '. Intentelo mas tarde.');
                 toastr.error('No se pudo realizar.', 'Upss', {timeOut: 2000})
             },
             complete: function(data) {
                
             }
 
         });
        
    })

});