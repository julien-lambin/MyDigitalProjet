$(document).ready(function () {

    //validation etape 1
    $("#valideMail").click(function(){

        //$(this).prop("disabled",true);

        $.ajax({
            url : 'ajout_pro.php',
            type : 'POST',
            data : $("#formMailPro").serialize(),
            dataType : "json",
            success : function(statut){ // success est toujours en place, bien sûr !
               
            },
            error : function(resultat, statut, erreur){

            }
    
        });
       
    });


    //validation etape 2
    $("#validePassword").click(function(){

        //$(this).prop("disabled",true);

        $.ajax({
            url : 'ajout_pro.php',
            type : 'POST',
            data : $("#formPassword").serialize(),
            dataType : "json",
            success : function(statut){ // success est toujours en place, bien sûr !
                
            },
            error : function(resultat, statut, erreur){

            }
    
        });
       
    });


    //validation etape 3
    $("#valideAdresse").click(function(){

        //$(this).prop("disabled",true);

        $.ajax({
            url : 'ajout_pro.php',
            type : 'POST',
            data : $("#formAdresse").serialize(),
            dataType : "json",
            success : function(statut){ // success est toujours en place, bien sûr !
                
            },
            error : function(resultat, statut, erreur){

            }
    
        });
        
    });


    //validation etape 4
    $("#valideEntreprise").click(function(){

        //$(this).prop("disabled",true);
        var form = $('#formEntreprise').get(0);
        var formulaire = new FormData(form);
        $.ajax({
            url : 'ajout_pro.php',
            type : 'POST',
            data : formulaire,
            processData: false,
            contentType: false,
            enctype: 'multipart/form-data',
            dataType : "json",
            success : function(statut){ // success est toujours en place, bien sûr !
                
            },
            error : function(resultat, statut, erreur){

            }
    
        });
        
    });
    
    $('#categorie').select2();

    // $(window).on("unload", function(e) {
        
    // });
});