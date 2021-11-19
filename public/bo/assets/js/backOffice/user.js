$(document).ready(function(){

    if($('#user-list-datatable').length > 0){

        var userTableElement = '#user-list-datatable' 
        var $dataTable = $(userTableElement)
        $dataTable.dataTable({
            "pageLength": 10,
            "processing": true, //Feature control the processing indicator.
            "bServerSide": true, //Feature control DataTables' server-side processing mode.
            "deferRender": true, //Feature control DataTables' server-side processing mode.
            "order": [[ 0, "desc" ]], //Initial no order.
            "bFilter": true,
            "bpaging": true,
            oLanguage: {
                "sProcessing": "traitement...",
                "oPaginate": {
                    "sPrevious": "Précédent", // This is the link to the previous page
                    "sNext": "Suivant", // This is the link to the next page
                },
                "sSearch": "Filtrer: ",
                "sLengthMenu": "Afficher _MENU_ enregistrement(s) / page",
                "sInfo": "Voir _TOTAL_ de _PAGE_ pour _PAGES_ entrées",
                "sEmptyTable": "Aucun résultat",
                "sZeroRecords": "Aucun résultat"
            },
           ajax:{
               "url" : $dataTable.attr('ajax-url'),
               "type" : "POST",
               "data" : function( data ){
                   data.page = $dataTable.attr('page'),
                   data.lisType = $('#user-list-datatable').val();
                   columnList = new Array(),
                
                $(userTableElement+ 'thead th tr').each(function(){
                    var classLabel = $(this).attr('class');

                    if( classLabel === 'sorting_asc' || classLabel === 'sorting_desc'){
                        column = $(this).index(),
                        orderBy = classLabel.replace("sorting_", "");

                        obj = {"column": column , "orderBy": orderBy};
                        columnList.push(obj);
                    }
                });
                data.columns = columnList;
               }

           },

            "drawCallback": function( settings ) {
               /*delete annonce*/
            //    deleteUser();
                
            }
        });
    }


});