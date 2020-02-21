<?php
require_once("imports.php");
session_start();

$entreprisedao = new ENtrepriseDAO;
$utilisateurdao = new UtilisateurDAO;

$lesentreprises = $entreprisedao->read(["option"=>"", "valeur"=>""]);
$lesutilisateurs = $utilisateurdao->read(["option"=>"", "valeur"=>""]);

$entreprises = "";
$utilisateurs = "";
$activation = "";
$status = "";

$activation_entreprise = "";
$status_entreprise = "";

foreach($lesentreprises as $entreprise){
    if($entreprise["entreprise_activation"] == True){
        $activation_entreprise = "<input type=\"submit\" name=\"desactiver_entr\" value=\"Désactiver\">";
        $status_entreprise = "Actif";
    }else{
        $activation_entreprise = "<input type=\"submit\" name=\"activer_entr\" value=\"activer\">";
        $status_entreprise = "Inactif";
    }

    $entreprises .=
    '
        <tr>
            <td>'.$entreprise["entreprise_siren"].'</td>
            <td>'.$entreprise["entreprise_nom"].'</td>
            <td>'.$entreprise["entreprise_email"].'</td>
            <td>'.$entreprise["entreprise_telephone"].'</td>
            <td>'.$status_entreprise.'</td>
            <td><form method="POST"><input type="text" name="siren" value="'.$entreprise["entreprise_siren"].'" hidden>'.$activation_entreprise.'</form></td>
        </tr>
    '; 
}

foreach($lesutilisateurs as $utilisateur){
    if($utilisateur["utilisateur_activation"] == True){
        $activation = "<input type=\"submit\" name=\"desactiver\" value=\"Désactiver\">";
        $status = "Actif";
    }else{
        $activation = "<input type=\"submit\" name=\"activer\" value=\"activer\">";
        $status = "Inactif";
    }

    if($utilisateur["role_id"] == "7"){
        $activation = "Impossible";
    }

    $utilisateurs .=
    '
        <tr>
            <td>'.$utilisateur["utilisateur_nom"].'</td>
            <td>'.$utilisateur["utilisateur_prenom"].'</td>
            <td>'.$utilisateur["entreprise_nom"].'</td>
            <td>'.$utilisateur["role_nom"].'</td>
            <td>'.$status.'</td>
            <td><form method="POST"><input type="text" name="id" value="'.$utilisateur["utilisateur_id"].'" hidden>'.$activation.'</form></td>
        </tr>
    '; 
}

$bar_links = "";
$contenu = "";
$tableau = "";
$tableau_entreprises = "";

if(isset($_SESSION["utilisateur"])){
    $utilisateur = $_SESSION["utilisateur"];

    $bar_links = 
    '
        <li class="nav-item">
            <a class="nav-link" href="deconnexion.php">Déconnexion</a>
        </li>
    ';

    $contenu = 
    "
        <h1>Bonjour ".$utilisateur->getPrenom()." ".$utilisateur->getNom()."</h1>
        <p class=\"lead\">Entreprise : ".$utilisateur->getEntreprise()->getNom()."</p>
        <p class=\"lead\">Rôle : ".$utilisateur->getRole()->getNom()."</p>
    ";

    if($utilisateur->getSpecialisation()->getId() != 1){
        $contenu .=
        "
            <p class=\"lead\">Spécialisation : ".$utilisateur->getSpecialisation()->getNom()."</p>
        ";
    }

    if($utilisateur->getRole()->getId() == 6 || $utilisateur->getRole()->getId() == 7){
        $contenu .= 
        "
        <p><button type=\"button\" id=\"utilisateurs\" value=\"utilisateurs\">Utilisateurs</button> <button type=\"button\" id=\"entreprises\" value=\"entreprises\">Entreprises</button></p>
        ";

        $tableau = 
        '
            <table class="table" id="table_user">
                <thead>
                    <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Entreprise</th>
                    <th scope="col">Rôle</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    '.$utilisateurs.'
                </tbody>
            </table>
        ';

        $tableau_entreprises = 
        '
            <table class="table" id="table_entreprise">
                <thead>
                    <tr>
                    <th scope="col">SIREN</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Email</th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    '.$entreprises.'
                </tbody>
            </table>
        ';
    }
}else{
    $bar_links = 
    '
        <li class="nav-item">
            <a class="nav-link" href="connexion.php">Connexion</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Inscription
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="inscription.php">Utilisateur</a>
            <a class="dropdown-item" href="inscription-entreprise.php">Entreprise</a>
        </li>
    ';

    $contenu = 
    "
    <h1>Bienvenue sur le réseau de télémédecine!</h1>
    <p class=\"lead\">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
    ";
}

if(isset($_POST["activer"])){
    $utilisateur = $utilisateurdao->read(["option"=>"id", "valeur"=>$_POST["id"]])[0];
    $authentification = new Authentification(null, $utilisateur["authentification_mot_de_passe"], $utilisateur["authentification_cle_secrete"]);

    $entreprise = new Entreprise(
        $utilisateur["entreprise_siren"], 
        $utilisateur["entreprise_activation"], 
        $utilisateur["entreprise_nom"],
        $utilisateur["entreprise_telephone"],
        $utilisateur["entreprise_email"],
        $utilisateur["entreprise_numero_de_rue"],
        $utilisateur["entreprise_rue"],
        $utilisateur["entreprise_ville"],
        $utilisateur["entreprise_code_postal"],
        $utilisateur["entreprise_date"]
    );

    $role = new Role($utilisateur["role_id"], $utilisateur["role_nom"]);
    $specialisation = new Specialisation($utilisateur["specialisation_id"], $utilisateur["specialisation_nom"]);

    $utilisateur = new Utilisateur(
        $utilisateur["utilisateur_id"],
        $entreprise,
        True,
        $role,
        $specialisation,
        $authentification,
        $utilisateur["utilisateur_nom"],
        $utilisateur["utilisateur_prenom"],
        $utilisateur["utilisateur_email"],
        $utilisateur["utilisateur_telephone"],
        $utilisateur["utilisateur_numero_de_rue"],
        $utilisateur["utilisateur_rue"],
        $utilisateur["utilisateur_ville"],
        $utilisateur["utilisateur_code_postal"],
        $utilisateur["utilisateur_date"]
    );

    $utilisateur->getAuthentification()->setUtilisateur($utilisateur);

    $utilisateurdao->update($utilisateur);
    header("Location: index.php");
}

if(isset($_POST["desactiver"])){
    $utilisateur = $utilisateurdao->read(["option"=>"id", "valeur"=>$_POST["id"]])[0];
    $authentification = new Authentification(null, $utilisateur["authentification_mot_de_passe"], $utilisateur["authentification_cle_secrete"]);

    $entreprise = new Entreprise(
        $utilisateur["entreprise_siren"], 
        $utilisateur["entreprise_activation"], 
        $utilisateur["entreprise_nom"],
        $utilisateur["entreprise_telephone"],
        $utilisateur["entreprise_email"],
        $utilisateur["entreprise_numero_de_rue"],
        $utilisateur["entreprise_rue"],
        $utilisateur["entreprise_ville"],
        $utilisateur["entreprise_code_postal"],
        $utilisateur["entreprise_date"]
    );

    $role = new Role($utilisateur["role_id"], $utilisateur["role_nom"]);
    $specialisation = new Specialisation($utilisateur["specialisation_id"], $utilisateur["specialisation_nom"]);

    $utilisateur = new Utilisateur(
        $utilisateur["utilisateur_id"],
        $entreprise,
        False,
        $role,
        $specialisation,
        $authentification,
        $utilisateur["utilisateur_nom"],
        $utilisateur["utilisateur_prenom"],
        $utilisateur["utilisateur_email"],
        $utilisateur["utilisateur_telephone"],
        $utilisateur["utilisateur_numero_de_rue"],
        $utilisateur["utilisateur_rue"],
        $utilisateur["utilisateur_ville"],
        $utilisateur["utilisateur_code_postal"],
        $utilisateur["utilisateur_date"]
    );

    $utilisateur->getAuthentification()->setUtilisateur($utilisateur);

    $utilisateurdao->update($utilisateur);
    header("Location: index.php");
}

if(isset($_POST["activer_entr"])){
    $entreprise = $entreprisedao->read(["option"=>"siren", "valeur"=>$_POST["siren"]])[0];
    $entreprise = new Entreprise(
        $entreprise["entreprise_siren"], 
        TRUE, 
        $entreprise["entreprise_nom"],
        $entreprise["entreprise_telephone"],
        $entreprise["entreprise_email"],
        $entreprise["entreprise_numero_de_rue"],
        $entreprise["entreprise_rue"],
        $entreprise["entreprise_ville"],
        $entreprise["entreprise_code_postal"],
        $entreprise["entreprise_date"]
    );

    $entreprisedao->update($entreprise);
    header("Location: index.php");
}

if(isset($_POST["desactiver_entr"])){
    $entreprise = $entreprisedao->read(["option"=>"siren", "valeur"=>$_POST["siren"]])[0];
    $entreprise = new Entreprise(
        $entreprise["entreprise_siren"], 
        FALSE, 
        $entreprise["entreprise_nom"],
        $entreprise["entreprise_telephone"],
        $entreprise["entreprise_email"],
        $entreprise["entreprise_numero_de_rue"],
        $entreprise["entreprise_rue"],
        $entreprise["entreprise_ville"],
        $entreprise["entreprise_code_postal"],
        $entreprise["entreprise_date"]
    );

    $entreprisedao->update($entreprise);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Télémédecine</title>

        <!-- Bootstrap core CSS -->
        <link href="assets/index/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="assets/index/css/full-width-pics.css" rel="stylesheet">
    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Télémédecine</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php">Accueil
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <?php 
                            echo $bar_links;
                        ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Header - set the background image for the header in the line below -->
        <header class="py-5 bg-image-full" style="background-image: url('https://images.unsplash.com/photo-1514416309827-bfb0cf433a2d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1351&q=80');">
            <img class="img-fluid d-block mx-auto" width="200" height="100" src="assets/index/images/kisspng-physician-assistant-medicine-clinic-health-care-doctor-5b110389e06fb2.0391593015278416739193.png" alt="">
        </header>

        <!-- Content section -->
        <section class="py-5">
            <div class="container">
                <?php 
                   echo $contenu;
                   echo $tableau;
                   echo $tableau_entreprises;
                ?>
            </div>
        </section>

        <!-- Image Section - set the background image for the header in the line below -->
        <section class="py-5 bg-image-full" style="background-image: url('https://images.unsplash.com/photo-1514415679929-1fd5193f14f7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80');">
            <!-- Put anything you want here! There is just a spacer below for demo purposes! -->
            <div style="height: 200px;"></div>
        </section>

        <!-- Content section -->
        <section class="py-5">
            <div class="container">
                <h1>Section Heading</h1>
                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, suscipit, rerum quos facilis repellat architecto commodi officia atque nemo facere eum non illo voluptatem quae delectus odit vel itaque amet.</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="assets/index/vendor/jquery/jquery.min.js"></script>
        <script src="assets/index/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script>
            $("#table_entreprise").hide();
            $("#utilisateurs").click(function(){
                $("#table_entreprise").hide();
                $("#table_user").show();
            });

            $("#entreprises").click(function(){
                $("#table_entreprise").show();
                $("#table_user").hide();
            });
        </script>
    </body>
</html>