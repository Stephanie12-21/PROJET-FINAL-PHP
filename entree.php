<?php
    require_once 'db.php';
    $db = new Database();

    $total_entree = $db->calculerSommeEntree();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de caisse d'une église table "entree"</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
     <!--Datatables -->
    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <!-- Font awesome (pour les icônes) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
   <!--POUR LA TABLE "entree" -->
    
    <div class="container">
        <a class="btn btn-outline-info" role="button" href="eglise.php">LISTE DES EGLISES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="btn btn-outline-info" role="button" href="entree.php">LISTE DES ENTREES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <a class="btn btn-outline-info"  role="button"href="sortie.php">LISTE DES SORTIES DANS LA DATABASE</a>

        <div class="row">
            <div class="col-lg-12">
                <h4 class="text-center text-danger font-weight-normal my-3">LISTE DES ENTREES DE CAISSE DANS LA BASE DE DONNEES</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <form action="" method="post" id="search-data">
                    <div class="form-group">
                        <label>Date de début</label>
                        <input type="date" name="date-start" id="date-start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Date de fin</label>
                        <input type="date" name="date-fin" id="date-fin" class="form-control" required>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="entree.php" class="btn btn-outline-primary">
                            <i class="fas fa-sync"></i>&nbsp;&nbsp; Retour
                        </a>
                        <button type="button" id="searchdateBtn" class="btn btn-outline-success">Rechercher</button>
                    </div>

                </form>

                <div class=" form-group float-end">
                    
                </div>
            </div>
            

            <div class="col-lg-6">
                <br>
                <div id="totalMontant" class="font-weight-bold text-primary" style="font-size: larger;" ></div>
                <br>
                
                <button type="button" class="btn btn-outline-info m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-money-check-alt fa-lg" ></i>&nbsp;&nbsp; Ajouter une nouvelle entrée</button>
                <a href="pdf.php" target="_blank" class="btn btn-outline-primary m-1 float-right"><i class="fas fa-file-pdf fa-lg"></i>&nbsp;&nbsp; Export en pdf</a> 
                <br>
                <br>
                <br>
                <br>
                
                <input type="text" id="searchInput" class="form-control" name="q" placeholder="rechercher par motif" value="<?= htmlentities($_GET['q'] ?? null) ?>">
                

            </div>
           
            
        </div>
        
           
            <br>
            

        <div class="row mt-12">
            <div class="col-lg-12">
                <div class="table-responsive" id="showUser">
                         <!-- la table "entree" s'affichera ici -->   
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
                        <h4 class="modal-title">Add new </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body px-4">
                    <form action="add_entry.php" method="post" id="form-data">
                        <div class="form-group">
                            <label> Motif de l'entrée</label>
                            <input type="text" name="motifentre" id="motifentre"  class="form-control" placeholder="motif" required>
                        </div>
                        <div class="form-group">
                            <label> Montant de l'entrée</label>
                            <input type="text" name="montantentre" id="montantentre" class="form-control" placeholder="montant" required pattern="[0-9]+">
                        </div>
                        <div class="form-group">
                            <label> EGLISE</label>
                            <select  name="ideglise" id="selectEglise" class="form-control">
                                <option value=""></option>
                                <?php
                                    $list_eglise = $db->readeglise();
                                    foreach($list_eglise as $eglise) {
                                        echo "<option value='" . $eglise['ideglise'] . "'>" . $eglise['ideglise'] . "-" . $eglise['designeglise'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                        
                        <a href="add_entry.php?motif=$motifentre?"><input type="submit" name="insertentre" id="insertentreBtn" value="Add User" class="bn btn-success btn-block"></a>

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
                    <input type="hidden" id="identre" name="identre" value="">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Modification des données </h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <!-- Modal body -->
                        <div class="modal-body px-4">
                            <form action="" method="post" id="edit-form-data">
                                <div class="form-group">
                                    <label> Motif de l'entrée</label>
                                    <input type="text" name="motifentre" id="motifentre"  class="form-control" placeholder="motif" required>
                                </div>
                                <div class="form-group">
                                    <label> Montant de l'entrée</label>
                                    <input type="text" name="montantentre" id="montantentre" class="form-control" placeholder="montant" required pattern="[0-9]+">
                                </div>
                                <div class="form-group">
                                    <label> EGLISE</label>
                                    <select  name="ideglise" id="selectEglise" class="form-control">
                                        <option value=""></option>
                                        <?php
                                            $list_eglise = $db->readeglise();
                                            foreach($list_eglise as $eglise) {
                                                echo "<option value='" . $eglise['ideglise'] . "'>" . $eglise['ideglise'] . "-" . $eglise['designeglise'] . "</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="editInfoCheckbox">
                                        <label class="form-check-label" for="editInfoCheckbox">
                                            Modifier les données
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                
                                <input type="button" name="updateentre" id="updateentre" value="Enregistrer les modifications" class="btn btn-outline-success btn-block ">
                  
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
        </div>
            
    <!-- The edit user Modal -->


<!--FIN DE LA TABLE "entree" -->

<!-- jQuery library -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


<br>
<!--Datatables -->
<script src="https://cdn.datatables.net/v/bs4/dt-2.0.0/datatables.min.js"></script>

<!--Sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
         $(document).ready(function()
        {
                    showAll();

                    function showAll() 
                    {
                        $.ajax({
                            url: "actionsE.php",
                            type: "POST",
                            data: {
                                action: "view"
                            },
                            success: function(response) {
                                $("#showUser").html(response);
                                $('#showUser table').DataTable({
                                    order: [0, 'desc'],
                                    "lengthChange": false,
                                    "info": false,
                                    "searching": false, 
                                });
                            }
                        });
                    }

                    $('#selectEglise').change(function() 
                    {
                        var ideglise = $(this).val(); 
                        $.ajax({
                            url: 'get_selected_eglise.php',
                            type: 'GET',
                            data: {
                                ideglise: ideglise
                            },
                            success: function(response) {
                               
                                console.log(response);
                                
                            },
                            error: function(xhr, status, error) {
                               
                                console.error(error);
                            }
                        });
                    });


                    $('#form-data').submit(function(event) 
                    {
                        event.preventDefault();

                        var motifentre = $('#motifentre').val();
                        var montantentre = $('#montantentre').val();
                        var ideglise = $('#selectEglise').val(); 
                        $.ajax({
                            url: 'add_entry.php',
                            type: 'POST',
                            data: {
                                motifentre: motifentre,
                                montantentre: montantentre,
                                ideglise: ideglise
                            },
                            success: function(response) {
                                                            
                                Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'L\'entrée a été ajoutée avec succès.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $("#addModal").modal('hide');
                                    $("#form-data")[0].reset();
                                    showAll();
                                    $.ajax({
                                        url: 'update_total.php', 
                                        type: 'POST',
                                        data: { action: 'update_total' },
                                        success: function(response) {

                                            $('#totalMontant').text('Somme totale des montants en entrée : ' + response + ' Ar');
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(error);
                                        }
                                    });
                            },
                            
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
        
                    $('#insertentreBtn').click(function() 
                    {
                        var motifentre = $('input[name="motifentre"]').val();
                        var montantentre = $('input[name="montantentre"]').val();
                        var ideglise = $('#selectEglise').val(); 

                      
                        console.log("Motif de l'entrée:", motifentre);
                        console.log("Montant de l'entrée:", montantentre);
                        console.log("Église sélectionnée:", ideglise);
                    });


                    $(document).on('click', '.delBtn', function()
                    {
                        var identre = $(this).attr('id');

                        Swal.fire
                        ({
                            title: 'Êtes-vous sûr?',
                            text: "Vous ne pourrez pas revenir en arrière une fois les données supprimées!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui, supprimer!',
                            cancelButtonText: 'Annuler'
                        }).then((result) => 
                        {
                            if (result.isConfirmed) 
                            {
                                $.ajax({
                                    url: 'delete_entry.php',
                                    type: 'POST',
                                    data: { identre: identre },
                                    success: function(response) {
                                        Swal.fire(
                                            'Suppression réussie!',
                                            'Les données sont définitivement supprimées!',
                                            'success'
                                        )
                                        showAll();
                                    },
                                    error: function(xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                        });

                    });
                    
                    $(document).on('click', '.editBtn', function() 
                    {
                        var identre = $(this).attr('id');

                        $.ajax
                        ({
                            url: 'get_entry.php', 
                            type: 'POST',
                            data: { identre: identre },
                            success: function(response) 
                                {
                                  
                                    var entry = JSON.parse(response);

                                    
                                     $('#editModal #motifentre').val(entry.motifentre);
                                     $('#editModal #montantentre').val(entry.montantentre);
                                     $('#editModal #selectEglise').val(entry.ideglise);
                                   
                                    
                                    
                                    $('#editModal').modal('show');
                                },
                            error: function(xhr, status, error) 
                                {
                                 
                                    console.error(error);
                                }
                        });
                    });

                    $(document).on('click', '.editBtn', function() 
                    {
                        var identre = $(this).attr('id');
                        identreSelectionne =  identre;
                        console.log("Identifiant de l'entrée:", identre);
                        $.ajax
                        ({
                            url: 'get_entry.php', 
                            type: 'POST',
                            data: { identre: identre },
                            success: function(response) {
                                var entry = JSON.parse(response);

                                console.log("Données de l'entrée:", entry);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }

                        });

                    });


                    $('#searchInput').on('input', function() 
                    {
                        var motifentre = $(this).val().trim();
                        $.ajax({
                            url: 'actionsE.php',
                            type: 'POST',
                            data: {action: 'view', motifentre: motifentre},
                            success: function(response) {
                                $('#showUser').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                    

                    $('#searchdateBtn').click(function() 
                    {
                        var dateStart = $('#date-start').val();
                        var dateEnd = $('#date-fin').val();

                        $.ajax({
                            url: 'filter_entries.php',
                            type: 'POST',
                            data: {
                                dateStart: dateStart,
                                dateEnd: dateEnd
                            },
                            success: function(response) 
                            {
                                $('#showUser').html(response);
                                    
                                
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });
                    
                     
                    document.getElementById('totalMontant').innerHTML = 'Somme totale des montants en entrée :  <?php echo $total_entree; ?> Ar';

                    
                    
                    $('#editInfoCheckbox').change(function()
                    {
                        if ($(this).is(':checked')) {
                            var ancienMotifentre = $('#editModal #motifentre').val();
                            var ancienMontantentre = $('#editModal #montantentre').val();
                            var ancienSelectEglise = $('#editModal #selectEglise').val();

                            $('#editModal #motifentre').val('');
                            $('#editModal #montantentre').val('');
                            $('#editModal #selectEglise').val('');

                            $.ajax({
                                url: 'update_eglise.php',
                                type: 'POST',
                                data: {
                                    ancienSelectEglise: ancienSelectEglise,
                                    ancienMontantentre: ancienMontantentre
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });

                            console.log("Ancien motif de l'entrée:", ancienMotifentre);
                            console.log("Ancien montant de l'entrée:", ancienMontantentre);
                            console.log("Ancienne église sélectionnée:", ancienSelectEglise);
                        } else {
                            console.log("La case à cocher n'est pas cochée.");
                        }
                    });

                    function afficherMotifValeur() 
                    {
                        var motifentre = $('#editModal #motifentre').val();
                        return motifentre;
                    }

                    function afficherMontantValeur() 
                    {
                        var montantentre = $('#editModal #montantentre').val();
                        return montantentre;
                    }

                    function afficherEgliseValeur() 
                    {
                        var selectEglise = $('#editModal #selectEglise').val();
                        return selectEglise;
                    }

                    $('#updateentre').click(function() 
                    {
                        var NewmotifValeur = afficherMotifValeur();
                        var NewmontantValeur = afficherMontantValeur();
                        var NewegliseValeur = afficherEgliseValeur();

                        Swal.fire({
                            title: 'Valeurs à mettre à jour',
                            html: '<div>Nouveau motif de l\'entrée: ' + NewmotifValeur + '</div>' +
                                '<div>Nouveau montant de l\'entrée: ' + NewmontantValeur + '</div>' +
                                '<div>Nouvelle église sélectionnée: ' + NewegliseValeur + '</div>' +
                                '<div>Identifiant de l\'entrée : ' + identreSelectionne + '</div>',
                            icon: 'info',
                            confirmButtonText: 'OK',
                            preConfirm: function() {
                                return new Promise(function(resolve, reject) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'editE.php',
                                        data: {
                                            motif: NewmotifValeur,
                                            montant: NewmontantValeur,
                                            eglise: NewegliseValeur,
                                            entreid: identreSelectionne
                                        },
                                        success: function(response) {
                                            Swal.fire({
                                                title: 'Succès',
                                                text: 'Les données ont été mises à jour avec succès !',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Exécuter une requête AJAX pour mettre à jour le solde de l'église
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'updateEglise.php',
                                                        data: {
                                                            eglise: NewegliseValeur,
                                                            montant: NewmontantValeur
                                                        },
                                                        success: function(response) {
                                                            // Vérifier si la mise à jour de l'église est un succès
                                                            if (response == "success") {
                                                                Swal.fire({
                                                                    title: 'Succès',
                                                                    text: 'Le solde de l\'église a été mis à jour avec succès !',
                                                                    icon: 'success',
                                                                    confirmButtonText: 'OK'
                                                                });
                                                                $("#editModal").modal('hide');
                                                                $("#edit-form-data")[0].reset();
                                                                showAll();
                                                            } else {
                                                                Swal.fire({
                                                                    title: 'Erreur',
                                                                    text: 'Une erreur est survenue lors de la mise à jour du solde de l\'église.',
                                                                    icon: 'error',
                                                                    confirmButtonText: 'OK'
                                                                });
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            // Gérer l'erreur
                                                            Swal.fire({
                                                                title: 'Erreur',
                                                                text: 'Une erreur est survenue lors de la mise à jour du solde de l\'église.',
                                                                icon: 'error',
                                                                confirmButtonText: 'OK'
                                                            });
                                                        }
                                                    });
                                                }
                                            });
                                        },
                                        error: function(xhr, status, error) {
                                            Swal.fire({
                                                title: 'Erreur',
                                                text: 'Une erreur est survenue lors de la mise à jour des données.',
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            });
                                            reject('Erreur lors de la mise à jour.');
                                        }
                                    });
                                });
                            }
                        });
                    });



                    

                                    

        
        });
    
     


    
    
    </script>    
 

</body>
</html>

 
