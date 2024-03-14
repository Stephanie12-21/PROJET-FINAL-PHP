<?php
    require_once 'db.php';
    $db = new Database();

    $total_sortie = $db->calculerSommeSortie();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de caisse d'une église table "sortie"</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
     <!--Datatables -->
    <link href="https://cdn.datatables.net/v/bs4/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <!-- Font awesome (pour les icônes) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
   <!--POUR LA TABLE "sortie" -->
 
  
    <div class="container">
        <a class="btn btn-outline-info" role="button" href="eglise.php">LISTE DES EGLISES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        
        <a class="btn btn-outline-info" role="button" href="entree.php">LISTE DES ENTREES DANS LA DATABASE</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <a class="btn btn-outline-info"  role="button"href="sortie.php">LISTE DES SORTIES DANS LA DATABASE</a>
        
        <div class="row">
            <div class="col-lg-12">
                <h4 class="text-center text-danger font-weight-normal my-3">LISTE DES SORTIES DE CAISSE DANS LA BASE DE DONNEES</h4>
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
                        <a href="sortie.php" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp; Retour
                        </a>
                        <button type="button" id="searchdateBtn" class="btn btn-outline-success">Rechercher</button>
                    </div>

                </form>
            </div>

           
            <div class="col-lg-6">
                <br>
                <div id="totalMontant" class="font-weight-bold text-primary" style="font-size: larger;"></div>
                <br>
                <button type="button" class="btn btn-outline-info m-1 float-right" data-toggle="modal" data-target="#addModal"><i class="fas fa-money-check-alt fa-lg" ></i>&nbsp;&nbsp; Ajouter une nouvelle sortie</button>
                <a href="pdf2.php" target="_blank" class="btn btn-outline-primary m-1 float-right"><i class="fas fa-file-pdf fa-lg"></i>&nbsp;&nbsp; Export en pdf</a> 
                <br>
                <br>
                <br>
                <br>
                
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par motif">
                

            </div>
            
        </div>
        
           
            <br>
            

        <div class="row mt-12">
            <div class="col-lg-12">
                <div class="table-responsive" id="showUser">
                         <!-- la table "sortie" s'affichera ici -->   
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
                    <form action="add_sortie.php" method="post" id="form-data">
                        <div class="form-group">
                            <label> Motif de l'sortie</label>
                            <input type="text" name="motifsortie" id="motifsortie"  class="form-control" placeholder="motif" required>
                        </div>
                        <div class="form-group">
                            <label> Montant de l'sortie</label>
                            <input type="text" name="montantsortie" id="montantsortie" class="form-control" placeholder="montant" required pattern="[0-9]+">
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
                        
                        <a href="add_sortie.php?motif=$motifsortie?"><input type="submit" name="insertsortie" id="insertsortieBtn" value="Add User" class="bn btn-success btn-block"></a>

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
                    <input type="hidden" id="idsortie" name="idsortie" value="">

                        <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Modification des données </h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            
                        <!-- Modal body -->
                            <div class="modal-body px-4">
                                <form action="" method="post" id="edit-form-data">
                                    <div class="form-group">
                                        <label> Motif de la sortie</label>
                                        <input type="text" name="motifsortie" id="motifsortie"  class="form-control" placeholder="motif" required>
                                    </div>
                                    <div class="form-group">
                                        <label> Montant de l'sortie</label>
                                        <input type="text" name="montantsortie" id="montantsortie" class="form-control" placeholder="montant" required pattern="[0-9]+">
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
                                    
                                        <input type="button" name="updatesortie" id="updatesortie" value="Enregistrer les modifications" class="btn btn-outline-success btn-block ">
                    
                                    </div>
                                </form>
                            </div>
                            
                </div>
            </div>
        </div>
            
    <!-- The edit user Modal -->

       


<!--FIN DE LA TABLE "sortie" -->

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

                    function showAll() 
                    {
                        $.ajax({
                            url: "actionsS.php",
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
                                    "searching": false, 
                                });
                            }
                        });
                    }

                    $('#selectEglise').change(function() 
                    {
                        var ideglise = $(this).val(); // Récupère l'ID de l'église sélectionnée
                        $.ajax({
                            url: 'get_selected_eglise.php',
                            type: 'GET',
                            data: {
                                ideglise: ideglise
                            },
                            success: function(response) {
                                // Affiche le nom de l'église dans la console
                                console.log(response);
                                // Vous pouvez également l'afficher à un endroit précis sur la page HTML
                                // Par exemple:
                                // $('#nomEgliseSelectionnee').text(response);
                            },
                            error: function(xhr, status, error) {
                                // Gérer les erreurs ici si nécessaire
                                console.error(error);
                            }
                        });
                    });


                    $('#form-data').submit(function(event) 
                    {
                        // Empêche le comportement par défaut du formulaire
                        event.preventDefault();

                        // Récupère les valeurs saisies dans le formulaire
                        var motifsortie = $('#motifsortie').val();
                        var montantsortie = $('#montantsortie').val();
                        var ideglise = $('#selectEglise').val(); // Utilise l'ID de l'église sélectionnée

                        // Envoie les valeurs à un fichier PHP via une requête AJAX pour l'ajout dans la base de données
                        $.ajax
                        ({
                            url: 'add_sortie.php',
                            type: 'POST',
                            data: 
                            {
                                motifsortie: motifsortie,
                                montantsortie: montantsortie,
                                ideglise: ideglise
                            },
                            success: function(response) 
                            {
                                // Vérifie si la réponse contient le message de succès
                                if (response.trim() === "success") 
                                {
                                    // Affiche un message de succès avec SweetAlert
                                    Swal.fire
                                    ({
                                        icon: 'success',
                                        title: 'Succès!',
                                        text: 'La sortie a été ajoutée avec succès.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $.ajax({
                                        url: 'update_totalsortie.php', // Remplacez 'update_total.php' par le chemin de votre fichier PHP pour mettre à jour le total
                                        type: 'POST',
                                        data: { action: 'update_totalsortie' },
                                        success: function(response) {
                                            // Mettre à jour le contenu de la balise span avec le nouveau total
                                            $('#totalMontant').text('Somme totale des montants en sortie : ' + response + ' Ar');
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(error);
                                        }
                                    });
                                } 
                                else 
                                {
                                    // Affiche un message d'erreur avec SweetAlert
                                    Swal.fire
                                    ({
                                        icon: 'error',
                                        title: 'Échec!',
                                        text: response,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }

                                // Recharge la table des entrées pour afficher la nouvelle entrée ajoutée
                                $("#addModal").modal('hide');
                                $("#form-data")[0].reset();
                                showAll();
                            },
                            error: function(xhr, status, error) 
                            {
                                // Gère les erreurs si nécessaire
                                console.error(error);
                            }
                        });

                    });
        
                    $('#insertsortieBtn').click(function() 
                    {
                        // Récupère les valeurs saisies dans les champs du formulaire
                        var motifsortie = $('input[name="motifsortie"]').val();
                        var montantsortie = $('input[name="montantsortie"]').val();
                        var ideglise = $('#selectEglise').val(); // Récupère la valeur sélectionnée dans la liste déroulante

                        // Affiche les valeurs dans la console
                        console.log("Motif de l'sortie:", motifsortie);
                        console.log("Montant de l'sortie:", montantsortie);
                        console.log("Église sélectionnée:", ideglise);
                    });

                    $(document).on('click', '.delBtn', function()
                    {
                        var idsortie = $(this).attr('id');

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
                                    url: 'delete_sortie.php',
                                    type: 'POST',
                                    data: { idsortie: idsortie },
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
            
            
                    $('#searchInput').on('input', function()
                    {
                        var motifsortie = $(this).val().trim();
                        $.ajax
                        ({
                            url: 'actionsS.php',
                            type: 'POST',
                            data: { action: 'view', motifsortie: motifsortie },
                            success: function(response) {
                                $('#showUser').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    });


                    $(document).on('click', '.editBtn', function() 
                    {
                        var idsortie = $(this).attr('id');

                        $.ajax
                        ({
                            url: 'get_sortie.php',  
                            type: 'POST',
                            data: { idsortie: idsortie },
                            success: function(response) 
                                {
                                    var sortie = JSON.parse(response);

                                     $('#editModal #motifsortie').val(sortie.motifsortie);
                                     $('#editModal #montantsortie').val(sortie.montantsortie);
                                     $('#editModal #selectEglise').val(sortie.ideglise);
                                   
                                    
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
                        var idsortie = $(this).attr('id');
                        idsortieSelectionne =  idsortie;
                        console.log("Identifiant de la sortie:", idsortie);
                        $.ajax
                        ({
                            url: 'get_sortie.php', 
                            type: 'POST',
                            data: { idsortie: idsortie },
                            success: function(response) {
                                var sortie = JSON.parse(response);

                                console.log("Données de la sortie:", sortie);
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }

                        });

                    });

                    $('#edit-form-data').submit(function(event) 
                    {
                        event.preventDefault();
                        
                        var idsortie = $('#idsortie').val();
                        var motifsortie = $('#motifsortie_edit').val();
                        var montantsortie = $('#montantsortie_edit').val();
                        var ideglise = $('#selectEglise_edit').val();
                        $.ajax({
                            url: 'update_sortie.php',
                            type: 'POST',
                            data: {
                                idsortie: idsortie,
                                motifsortie: motifsortie,
                                montantsortie: montantsortie,
                                ideglise: ideglise
                            },
                            success: function(response) {

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
                            url: 'filter_sortie.php',
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

                    $('#editInfoCheckbox').change(function()
                    {
                        if ($(this).is(':checked')) {
                            var ancienMotifsortie = $('#editModal #motifsortie').val();
                            var ancienMontantsortie = $('#editModal #montantsortie').val();
                            var ancienSelectEglise = $('#editModal #selectEglise').val();

                           
                            $('#editModal #motifsortie').val('');
                            $('#editModal #montantsortie').val('');
                            $('#editModal #selectEglise').val('');

                            $.ajax({
                                url: 'update_egliseSortie.php',
                                type: 'POST',
                                data: {
                                    ancienSelectEglise: ancienSelectEglise,
                                    ancienMontantsortie: ancienMontantsortie
                                },
                                success: function(response) {
                                    console.log(response);
                                },
                                error: function(xhr, status, error) {
                                    console.error(error);
                                }
                            });

                            console.log("Ancien motif de la sortie:", ancienMotifsortie);
                            console.log("Ancien montant de la sortie:", ancienMontantsortie);
                            console.log("Ancienne église sélectionnée:", ancienSelectEglise);
                        } else {
                            console.log("La case à cocher n'est pas cochée.");
                        }
                    });

                    function afficherMotifValeur() 
                    {
                        var motifsortie = $('#editModal #motifsortie').val();
                        return motifsortie;
                    }

                    function afficherMontantValeur() 
                    {
                        var montantsortie = $('#editModal #montantsortie').val();
                        return montantsortie;
                    }

                    function afficherEgliseValeur() 
                    {
                        var selectEglise = $('#editModal #selectEglise').val();
                        return selectEglise;
                    }


                    $('#updatesortie').click(function() 
                    {
                        var NewmotifValeur = afficherMotifValeur();
                        var NewmontantValeur = afficherMontantValeur();
                        var NewegliseValeur = afficherEgliseValeur();

                        Swal.fire({
                            title: 'Valeurs à mettre à jour',
                            html: '<div>Nouveau motif de la sortie: ' + NewmotifValeur + '</div>' +
                                '<div>Nouveau montant de la sortie: ' + NewmontantValeur + '</div>' +
                                '<div>Nouvelle église sélectionnée: ' + NewegliseValeur + '</div>' +
                                '<div>Identifiant de la sortie : ' + idsortieSelectionne + '</div>',
                            icon: 'info',
                            confirmButtonText: 'OK',
                            preConfirm: function() {
                                return new Promise(function(resolve, reject) {
                                    $.ajax({
                                        type: 'POST',
                                        url: 'editS.php',
                                        data: {
                                            motif: NewmotifValeur,
                                            montant: NewmontantValeur,
                                            eglise: NewegliseValeur,
                                            entreid: idsortieSelectionne
                                        },
                                        success: function(response) {
                                            Swal.fire({
                                                title: 'Succès',
                                                text: 'Les données ont été mises à jour avec succès !',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: 'updateEgliseSortie.php',
                                                        data: {
                                                            eglise: NewegliseValeur,
                                                            montant: NewmontantValeur
                                                        },
                                                        success: function(response) {
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

                    document.getElementById('totalMontant').innerHTML = 'Somme totale des montants en sortie : <?php echo $total_sortie; ?> Ar';

       
        });
    </script>    
 

</body>
</html>

 
