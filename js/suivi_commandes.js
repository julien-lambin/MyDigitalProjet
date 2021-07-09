$(document).ready(function () {

    $(".nouvelleEtape").click(function(){
        
        $(this).prop("disabled",true);

        var numCommande = $(this).attr("data-numCommande");
        var etatActuel = $(this).attr("data-etat");

        $.ajax({
           url : './modifEtatCmd.php',
           type : 'POST',
           data : { 
                numCommande : numCommande, 
                etatActuel : etatActuel 
            },
            success : function(statut){ // success est toujours en place, bien sûr !
                location.reload();
            },
            error : function(jqXHR, textStatus, errorThrown){
                alert(jqXHR+" "+textStatus+" "+errorThrown);
            }
        });
    });


        $(".uploadImage").change(function(){
            
            //$(this).prop("disabled",true);
            var form = $(this).closest(".formUploadImage").get(0);
            var formulaire = new FormData(form);

            $.ajax({
                url : './uploadFileSuiviCommande.php',
                type : 'POST',
                data : formulaire,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                dataType : "json",
                success : function(statut){ // success est toujours en place, bien sûr !
                    $('.formUploadImage').trigger("reset");
                },
                error : function(resultat, statut, erreur){
    
                }
        
            });
            
        });


        $(".uploadDevis").change(function(){
            
            //$(this).prop("disabled",true);
            var form = $(this).closest(".formUploadDevis").get(0);
            var formulaire = new FormData(form);
        
            $.ajax({
                url : './uploadFileSuiviCommande.php',
                type : 'POST',
                data : formulaire,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                dataType : "json",
                success : function(statut){ // success est toujours en place, bien sûr !
                    $('.formUploadDevis').trigger("reset");
                },
                error : function(resultat, statut, erreur){
    
                }
        
            });
            
        });


        $(".uploadFacture").change(function(){
            
            //$(this).prop("disabled",true);
            var form = $(this).closest(".formUploadFacture").get(0);
            var formulaire = new FormData(form);
        
            $.ajax({
                url : './uploadFileSuiviCommande.php',
                type : 'POST',
                data : formulaire,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                dataType : "json",
                success : function(statut){ // success est toujours en place, bien sûr !
                    $('.formUploadFacture').trigger("reset");
                },
                error : function(resultat, statut, erreur){
    
                }
        
            });
            
        });
    

});