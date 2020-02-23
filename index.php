<?php
require_once("imports.php");
session_start();

$entreprisedao = new EntrepriseDAO;
$utilisateurdao = new UtilisateurDAO;

$lesentreprises = $entreprisedao->read(["", ""]);
$lesutilisateurs = $utilisateurdao->read(["", ""]);

$entreprises = "";
$utilisateurs = "";
$activation = "";
$status = "";

$activation_entreprise = "";
$status_entreprise = "";

foreach($lesentreprises as $entreprise){
    if($entreprise->getActivation() == True){
        $activation_entreprise = "<input type=\"submit\" name=\"desactiver_entr\" value=\"Désactiver\">";
        $status_entreprise = "Actif";
    }else{
        $activation_entreprise = "<input type=\"submit\" name=\"activer_entr\" value=\"activer\">";
        $status_entreprise = "Inactif";
    }

    $entreprises .=
    '
        <tr>
            <td>'.$entreprise->getSIREN().'</td>
            <td>'.$entreprise->getNom().'</td>
            <td>'.$entreprise->getEmail().'</td>
            <td>'.$entreprise->getTelephone().'</td>
            <td>'.$status_entreprise.'</td>
            <td><form method="POST"><input type="text" name="siren" value="'.$entreprise->getSIREN().'" hidden>'.$activation_entreprise.' <input type="submit" name="suprimmer_entr" value="Suprimmer"></form></td>
        </tr>
    '; 
}

foreach($lesutilisateurs as $utilisateur){
    if($utilisateur->getActivation() == True){
        $activation = "<input type=\"submit\" name=\"desactiver\" value=\"Désactiver\">";
        $status = "Actif";
    }else{
        $activation = "<input type=\"submit\" name=\"activer\" value=\"activer\">";
        $status = "Inactif";
    }

    if($utilisateur->getRole()->getNom() == "7"){
        $activation = "Impossible";
    }

    $utilisateurs .=
    '
        <tr>
            <td>'.$utilisateur->getNom().'</td>
            <td>'.$utilisateur->getPrenom().'</td>
            <td>'.$utilisateur->getEntreprise()->getNom().'</td>
            <td>'.$utilisateur->getRole()->getNom().'</td>
            <td>'.$status.'</td>
            <td style="text-align: center;">
                <form method="POST">
                    <input type="text" name="id" value="'.$utilisateur->getId().'" hidden>
                    '.$activation.' 
                    <input type="submit" name="modifier" value="Modifier"> 
                    <input type="submit" name="suprimmer" value="Suprimmer">
                </form>
            </td>
        </tr>
    '; 
}

$nav_links = "";
$contenu = "";
$tableau = "";
$tableau_entreprises = "";

if(isset($_SESSION["utilisateur"])){
    $utilisateur = $_SESSION["utilisateur"];

    $nav_links = 
    '
        <li class="nav-item">
            <a class="nav-link" href="modifier.php?id='.$utilisateur->getId().'">Modifier vos informations</a>
        </li>
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
                    <th scope="col" style="text-align: center;">Action</th>
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
    $nav_links = 
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
        <p class=\"lead\">Une autre manière de soigner</p>
        <p>
            La télémédecine est une autre manière de soigner, avec les mêmes exigences de qualité et de sécurité que des actes classiques. 
            Elle fait évoluer la médecine pour répondre à des défis tels que le vieillissement de la population ou encore le suivi approfondi des maladies chroniques. 
            Elle est également un vecteur important d’amélioration de l’accès aux soins, en particulier dans les zones fragiles. 
            En effet, elle permet une meilleure prise en charge au plus près du lieu de vie des patients et contribue aux prises en charge coordonnées par les professionnels de santé et les professionnels du secteur médico-social. 
            Elle constitue aussi un facteur d’amélioration de l’efficience et de l’organisation des soins.
        </p>
        <p>
            Elle permet d’établir un diagnostic, d’assurer, pour un patient à risque, un suivi à visée préventive ou un suivi post-thérapeutique, de requérir un avis spécialisé, 
            de préparer une décision thérapeutique, de prescrire des produits de santé, de prescrire ou de réaliser des prestations ou des actes, ou d’effectuer une surveillance 
            de l’état de santé des patients.
        </p>
        <p>
            Elle n’a pas pour objectif de remplacer les actes médicaux en présentiel mais elle leur est complémentaire. 
            Elle ne se substitue pas aux pratiques médicales plus habituelles mais constitue une réponse aux défis auxquels est confrontée l’offre de soins aujourd’hui. 
            La télémédecine doit reposer sur un projet médical répondant à des priorités et aux besoins de la population d’un territoire et des professionnels de santé. 
            C’est en ce sens qu’elle s’intègre au sein d’un parcours de soins.
        </p>
    ";
}

if(isset($_POST["activer"])){
    $utilisateur = $utilisateurdao->read(["id", $_POST["id"]])[0];
    $utilisateur->setActivation(True);
    $utilisateurdao->update($utilisateur);
    header("Location: index.php");
}

if(isset($_POST["desactiver"])){
    $utilisateur = $utilisateurdao->read(["id", $_POST["id"]])[0];
    $utilisateur->setActivation(False);
    $utilisateurdao->update($utilisateur);
    header("Location: index.php");
}

if(isset($_POST["activer_entr"])){
    $entreprise = $entreprisedao->read(["siren", $_POST["siren"]])[0];
    $entreprise->setActivation(True);
    $entreprisedao->update($entreprise);
    header("Location: index.php");
}

if(isset($_POST["desactiver_entr"])){
    $entreprise = $entreprisedao->read(["siren", $_POST["siren"]])[0];
    $entreprise->setActivation(False);
    $entreprisedao->update($entreprise);
    header("Location: index.php");
}

if(isset($_POST["suprimmer"])){
    $utilisateur = $utilisateurdao->delete(["id", $_POST["id"]]);
    if($utilisateur){
        header("Location: index.php");
    }else{
        echo "Supression a échouée.";
    }
}

if(isset($_POST["suprimmer_entr"])){
    $entreprise = $entreprisedao->delete(["id", $_POST["id"]]);
    if($entreprise){
        header("Location: index.php");
    }else{
        echo "Supression a échouée.";
    }
}

if(isset($_POST["modifier"])){
    header("Location: modifier.php?id=".$_POST["id"]);
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
                            echo $nav_links;
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
                <h1>La télémédecine</h1>
                <p class="lead">La téléconsultation</p>
                <p>
                    La téléconsultation permet à un professionnel médical de donner une consultation à distance par l’intermédiaire des technologies de l’information et 
                    de la communication. C’est un acte médical et une action synchrone (patient et médecin se parlent). Elle permet au professionnel de santé médical requis 
                    de réaliser une évaluation globale du patient, en vue de définir la conduite à tenir à la suite de cette téléconsultation.
                </p>
                <p class="lead">La téléexpertise</p>
                <p>
                    La téléexpertise permet à un professionnel médical de solliciter à distance l’avis d’un ou de plusieurs professionnels médicaux par l’intermédiaire des 
                    technologies de l’information et de la communication. C’est d’abord un acte médical et une action asynchrone (patient et médecin ne se parlent pas). 
                    Cela concerne deux médecins pendant ou à distance de la consultation initiale. Cette action ne faisait pas l’objet d’une rémunération jusqu’à présent.
                </p>
                <p class="lead">La télésurveillance</p>
                <p>La télésurveillance permet à un professionnel médical d’interpréter à distance des données recueillies sur le lieu de vie du patient.</p>
                <p>Dans le cadre des expérimentations tarifaires ETAPES, elle concerne les patients en ALD, se situant en établissement de santé, en structure médico-sociale ou à leur domicile.</p>
                <p>
                    Les informations relatives à sa mise en œuvre dans le cadre d’ETAPES (périmètre, missions des acteurs impliqués, tarification, critères d’inclusion, médecins requérants et 
                    médecins requis, rémunération, conditions de réalisation, déroulé de la procédure, outils ARS, tarification, sécurisation des échanges, circuit de facturation, évaluation,…) 
                    sont précisées dans des cahiers des charges.
                </p>
                <p class="lead">La téléassistance</p>
                <p>La téléassistance médicale a pour objet de permettre à un professionnel médical d’assister à distance un autre professionnel de santé au cours de la réalisation d’un acte.</p>
                <p class="lead">La régulation</p>
                <p>La régulation médicale est la réponse médicale apportée dans le cadre de l’activité des centres 15.</p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Télémédecine 2020</p>
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