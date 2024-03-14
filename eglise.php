
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de caisse d'une église</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
     <!--Datatables -->
    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <!-- Font awesome (pour les icônes) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
   <!--POUR LA TABLE "eglise" -->
   
  
    <div class="container">
        <a class="btn btn-outline-info" role="button" href="eglise.php">LISTE DES EGLISES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="btn btn-outline-info" role="button" href="entree.php">LISTE DES ENTREES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <a class="btn btn-outline-info"  role="button"href="sortie.php">LISTE DES SORTIES DANS LA DATABASE</a>
        <div class="row">
            <div class="col-lg-12">
                <br>
                
                <h4 class="text-center text-danger font-weight-normal my-3">LISTE DES EGLISES REPERTORIEES DANS LA BASE DE DONNEES</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <!--h4 class="mt-2 text-primary">Toutes les données</h4-->
            </div>
            <div class="col-lg-6">
                <br>
                <br>
               <button type="button" class="btn btn-outline-primary m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-church fa-lg" ></i>&nbsp;&nbsp; Ajouter</button>
               <a href="chart.php" class="btn btn-outline-success m-1 float-right"><i class="bi bi-bar-chart-line-fill"></i>&nbsp;&nbsp; Aperçu graphique</a> 
            </div>
        </div>
        
           
            <br>
            

        <div class="row center">
            <div class="col-lg-12">
                <div class="table-responsive" id="showUser">
                         <!-- la table "eglise" s'affichera ici -->   
                </div>
            </div>
        </div>
    </div>

    <!-- The add new user Modal -->
        <div class="modal fade" id="addModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Ajouter une nouvelle église</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body px-4">
                    <form action="" method="post" id="form-data">
                        <div class="form-group">
                            <label> Nom de l'église</label>
                            <input type="text" name="designeglise" class="form-control" placeholder="Nom de l'église" required>
                        </div>
                        <div class="form-group">
                            <input type="button" name="inserteglise" id="inserteglise" value="Ajouter" class="btn btn-outline-success btn-block" >
                        </div>
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>
    <!-- The add new user Modal -->
  


    <!-- The edit  user Modal -->
        <div class="modal fade" id="editModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Edit User</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body px-4">
                    <form action="" method="post" id="edit-form-data">
                            <input type="hidden" name="ideglise" id="ideglise">
                        <div class="form-group">
                            <label> Nom de l'église</label>
                            <input type="text" name="designeglise" class="form-control" id="designeglise" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="updateeglise" id="updateeglise" value="Enregistrer les modifications" class="btn btn-outline-success btn-block">
                        </div>
                    </form>
                    </div>
                    
                </div>
            </div>
        </div>
    <!-- The edit user Modal -->


<!--FIN DE LA TABLE "eglise" -->

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>



<!--Datatables -->
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.0/datatables.min.js"></script>

<!--Sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
        $(document).ready(function() 
        {
            showAll();

            function showAll() {
                $.ajax({
                    url: "actions.php",
                    type: "POST",
                    data: {
                        action: "view"
                    },
                    success: function(response) {
                        // Affichage de la réponse dans la table
                        $("#showUser").html(response);
                        // Activation de DataTables pour la table générée
                        $('#showUser table').DataTable({
                            order: [0, 'desc'],
                            "lengthChange": false,
                                "info": false,
                                "searching": false
                        });
                    }
                });
            }
         
            $("#inserteglise").click(function(e) 
            {
                if ($("#form-data")[0].checkValidity()) 
                {
                    e.preventDefault();
                    $.ajax
                    ({
                        url: "actions.php",
                        type: "POST",
                        data: $("#form-data").serialize() + "&action=inserteglise",
                        success: function(response) 
                        {
                            // Analyser la réponse JSON
                            var data = JSON.parse(response);
                            if (data.hasOwnProperty('success')) 
                            {
                                // Si la réponse contient la clé 'success', afficher le message de succès
                                Swal.fire
                                ({
                                    title: data.success,
                                    icon: 'success'
                                }).then(function() 
                                {
                                    // Recharger la table après un ajout réussi
                                    showAll();
                                });
                                // Réinitialiser le formulaire et fermer le modal d'ajout
                                $("#form-data")[0].reset();
                                $("#addModal").modal('hide');
                            } 
                            else if (data.hasOwnProperty('error')) 
                            {
                                // Si la réponse contient la clé 'error', afficher le message d'erreur
                                Swal.fire
                                ({
                                    title: data.error,
                                    icon: 'error'
                                });
                            }
                        }
                    });
                }
            });


           
           $("body").on("click", ".editBtn", function(e)
           {
                e.preventDefault();
                edit_id = $(this).attr('id');
                $.ajax
                    ({
                            url:"actions.php",
                            type: "POST",
                            data: { edit_id: edit_id, action: 'edit' },
                            success:function(response){
                               data = JSON.parse(response);
                               $("#ideglise").val(data.ideglise);
                               $("#designeglise").val(data.designeglise);
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = xhr.status + ': ' + xhr.statusText;
                                if(xhr.responseText){
                                    errorMessage += ' - ' + xhr.responseText;
                                }
                                console.log('Error - ' + errorMessage);
                            }
                        
                    });

           });

            $("#updateeglise").click(function(e)
            {
                if($("#edit-form-data")[0].checkValidity())
                {
                    e.preventDefault();
                    $.ajax({
                        url:"actions.php",
                        type: "POST",
                        data: $("#edit-form-data").serialize()+"&action=updateeglise",
                        success:function(response)
                        {
                        Swal.fire({
                            title: 'La modification a été un succès!',
                            type:'success',
                            icon: "success"
                        })
                        $("#editModal").modal('hide');
                        $("#edit-form-data")[0].reset();
                        showAll();
                        }
                    });
                }

            });

            $("body").on("click", ".delBtn", function(e)
            {
                e.preventDefault();
                var tr = $(this).closest('tr');
                del_ideglise = $(this).attr('id');
                Swal.fire
                ({
                    title: "Êtes-vous sûr?",
                    text: "Vous ne pourrez pas revenir en arrière une fois les données supprimées!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "'Oui, supprimer!'",
                    cancelButtonText:"'Annuler'"
                }).then((result) => 
                    {
                        if (result.value)
                            {
                                $.ajax
                                ({
                                    url:"actions.php",
                                    type: "POST",
                                    data:{del_ideglise:del_ideglise},
                                    success:function(response)
                                    {
                                        tr.css('background-color', "#ff6666");
                                        Swal.fire(
                                            'Suppression réussie!',
                                            'Les données sont définitivement supprimées!',
                                            'success'
                                        )
                                        showAll();
                                    }
                                });
                            }
                    });
                
            });

            
          

        });
</script>

</body>
</html>

 
