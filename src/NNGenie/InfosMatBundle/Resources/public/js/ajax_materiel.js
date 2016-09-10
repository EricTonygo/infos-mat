$('#materiel_genre').change(function (){
    var genre = $('#materiel_genre option:selected').val();
    if(genre !== ""){
        var idgenre = parseInt(genre);
        $.ajax({
            type: 'post',
            url: Routing.generate('nn_genie_infos_mat_types_genre', {id: idgenre}),
            dataType: 'json',
            beforeSend: function(xhr) {
                
            },
            success: function(data, textStatus, jqXHR) {
                var child = '<option value = "" selected > Selectionner un type</option>';
                var mydata = data.donnees;
                if(mydata.length > 0){
                    for(var i=0; i < data.length; i++){
                        child += '<option value= "'+data[i].id+"'>"+data[i].nombt+"</option>";
                    }
                }
                $('#materiel_type').html(child);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                var child = '<option value = "" selected > Selectionner un type</option>';
                $('#materiel_type').html(child);
            }
        });
    }
});

