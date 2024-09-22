<?php
try {
    $bdd = new PDO('mysql:host=localhost;port=3308;dbname=arcadia', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arcadia</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">  
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <!-- START HEADER -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-3" id="menu">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <span class="text-success fs-5 fw-bold">Arcadia</span>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Accueil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="habitats_page.php">Nos Habitats</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="page_services.php">Nos Services</a>
              </li>
            </ul>
            <form class="d-flex" role="search">
                <button class="btn btn-outline-success" type="submit" ><a href="connexion.php" >connexion</a></button>
            </form>
          </div>
        </div>
      </nav>

     <!-- START SLIDER -->

     <div id="carouselExampleCaptions" class="carousel slide d-block mx-auto"   data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner border border-success border-3 rounded-4">
        <div class="carousel-item active" >
          <img src="assets/slide1.jpg" class="d-block w-100" alt="slide1">
          <div class="carousel-caption d-none d-md-block">
            <h1 class="text-success">Bienvenue à Arcadia</h1>
            <p>Un lieu où la nature et la durabilité sont au cœur de tout.</p>
          </div>
        </div>
        <div class="carousel-item" >
          <img src="assets/slide2.jpg" class="d-block w-100" alt="slide2">
          <div class="carousel-caption d-none d-md-block">
            <h1 class="text-success">Bienvenue à Arcadia</h1>
            <p>Un lieu où la nature et la durabilité sont au cœur de tout.</p>
          </div>
        </div>
        <div class="carousel-item" >
          <img src="assets/slide3.jpg" class="d-block w-100" alt="slide3">
          <div class="carousel-caption d-none d-md-block">
            <h1 class="text-success">Bienvenue à Arcadia</h1>
            <p>Un lieu où la nature et la durabilité sont au cœur de tout.</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
      <!-- PRESENTATION -->
  <section class="w-50 mx-auto text-center pt-5" id="presentation">
    <h1 class="fs-4 border-bottom border-2 border-success p-2">Un peu d'histoire sur <span class="text-success">Arcadia</span></h1>
    <p class="p-3 fs-6 fw-light">Arcadia a été fondé en 1960 par un groupe de biologistes passionnés et de défenseurs de la nature. Leur vision était de créer un espace où la conservation et l'éducation pourraient converger pour protéger les espèces menacées et sensibiliser le public à l'importance de la biodiversité.</p>
    <h1 class="fs-4 border-bottom border-2 border-success p-2">Nos Valeurs
    </h1>
    <p class="p-3 fs-6 fw-light">Le zoo est entièrement indépendant au niveau des énergies et respecte les principes de durabilité.
    </p>
  </section>

  <!-- SERVICES -->
  <div class="container-fluid">
    <div class="row w-75 mx-auto my-5 service-row">
      <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
       <img class="image-services" src="assets/image-service.jpg" alt="services" width="180" height=160>
       <div>
      <h3 class="fs-5 mt-4 px-4 pb-1 text-success"><a class="text-success" href="page_services.php">Services</a></h3>
      <p class="px-4">Restauration, visite des habitats avec un guide (gratuit), visite du zoo en petit train.</p>
      </div>
      </div>
      <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
       <img class="image-services" src="assets/animaux-image.jpg" alt="services" width="180" height=160>
       <div>
      <h3 class="fs-5 mt-4 px-4 pb-1 text-success">Animaux</h3>
      <p class="px-4">Faitez la connaisance de nos pensionnaires. Des infos mises à jour chaque matin par nos veterinaires.</p>
      </div>
      </div>
      </div>
      <div class="row w-75 mx-auto my-5 service-row">
        <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
         <img class="image-services" src="assets/image-habitat.jpg" alt="services" width="180" height=160>
         <div>
        <h3 class="fs-5 mt-4 px-4 pb-1 "><a class="text-success" href="habitats_page.php">Nos Habitats</a></h3>
        <p class="px-4">Nous comptons trois habitats specialement conçus pour nos animaux. Envie d'en savoir plus ?</p>
        <!-- <a class="btn btn-succes" href="habitats.html" role="button">En savoir plus.</a>   -->
      </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-start my-5 icono-wrap">
         <img class="image-services" src="assets/avis-image.jpg" alt="services" width="180" height=160>
         <div>
        <h3 class="fs-5 mt-4 px-4 pb-1 text-success"><a class="text-success" href="page_laisser_avis.php">Vos Avis</a></h3>
        <p class="px-4">Vos avis sont precieux ! N'hesitez pas à partager les points positifs et negatifs.</p>
        </div>
        </div>
        </div>
    </div>

    <!-- INFO -->
     <div id="info" class="border-top border-2">
         <div class="carte">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2668.7348371867056!2d-2.176537524382008!3d48.018832559421625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x480faceab3587495%3A0xcdc883e818be2eb2!2sFor%C3%AAt%20de%20Broc%C3%A9liande!5e0!3m2!1sfr!2ses!4v1723212665818!5m2!1sfr!2ses" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
         </div>
      <div class="wrapper">
          <h2 class="text-success">Situé dans la fôret de Broceliande, Bretagne.</h2>
          <h2 class="text-success mb-4" id="typewriter"></h2>
        <p class="fs-5 text-light">La forêt de Brocéliande, située en Bretagne près de Ploërmel, est légendaire pour ses liens avec les mythes arthuriennes. C'est dans cette forêt que le roi Arthur, Merlin l'Enchanteur, et les chevaliers de la Table Ronde auraient vécu leurs aventures.</p>
        <section class="d-flex" id="horaires">
        <?php
        $query = 'SELECT type_jour, heure_ouverture, heure_fermeture FROM horaires_ouverture';
        $horaires_ouverture = $bdd->query($query)->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <div class="container my-5">
        <h2 class="text-center text-light mb-4">Horaires d'ouverture</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-success">Type de jour</th>
                    <th class="text-success">Heure d'ouverture</th>
                    <th class="text-success">Heure de fermeture</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($horaires_ouverture as $horaire): ?>
                    <tr>
                        <td class="text-success"><?php echo ($horaire['type_jour']); ?></td>
                        <td class="text-success"><?php echo ($horaire['heure_ouverture']); ?></td>
                        <td class="text-success"><?php echo ($horaire['heure_fermeture']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                </div>
        </section> 
      </div>
     </div>
     


      <!-- AVIS -->

      <?php

$sql = "SELECT * FROM avis WHERE isVisible = TRUE";
$avis = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>

     <main class="container my-5">
    <h2 class="text-center text-success mb-4">L'avis de nos visiteurs</h2>
    <div class="row">
        <?php if (count($avis) > 0): ?>
            <?php foreach ($avis as $un_avis): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success"><?php echo ($un_avis['pseudo']); ?></h5>
                            <p class="card-text"><?php echo ($un_avis['commentaire']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Aucun avis trouvé.</p>
        <?php endif; ?>
    </div>
</main>

<footer class="text-center text-lg-start bg-body-tertiary text-muted">
  <section class="d-flex justify-content-center justify-content-lg-around p-4 border-bottom">
    
     
      <div class="me-5 d-none d-lg-block text-success ">
        <span>Retrouvez-nous sur les reseaux sociaux:</span>
      </div>
    
      <div>
        <a href="" class="me-4 text-success">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a href="" class="me-4 text-success">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="" class="me-4 text-success">
          <i class="fab fa-instagram"></i>
        </a>
      </div>
      
    </section>
 

  <!-- START LINKS -->
  <section class="">
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4 text-success">
            <i class="fas fa-gem me-3 text-success"></i>Arcadia
          </h6>
          <p>
            Un lieu où la nature et la durabilité sont au cœur de tout.
          </p>
        </div>
      
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4 text-success">
            Notre Zoo
          </h6>
          <p>
            <a href="#!" class="text-success">Animaux</a>
          </p>
          <p>
            <a href="habitats_page.php" class="text-success">Habitats</a>
          </p>
          <p>
            <a href="#!" class="text-success">Rejoignez-nous</a>
          </p>
      
        </div>
  
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4 text-success">
           Services
          </h6>
          <p>
            <a href="#!" class="text-success">Billeterie</a>
          </p>
          <p>
            <a href="page_services.php" class="text-success">Restauration</a>
          </p>
          <p>
            <a href="page_services.php" class="text-success">Visite du zoo avec un guide</a>
          </p>
          <p>
            <a href="page_services.php" class="text-success">Visite du zoo en petit train</a>
          </p>
        </div>
    
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4 text-success">Contact</h6>
          <p><i class="fas fa-home me-3 text-success"></i> Forêt de Brocéliande, 35380 Paimpont</p>
          <p>
            <i class="fas fa-envelope me-3 text-success"></i>
            info@arcadia.com
          </p> 
          <p><i class="fas fa-phone me-3 text-success"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3 text-success"></i> + 01 234 567 89</p>
        </div>
      </div>
    </div>
  </section>
  

  <!-- COPYRIGHT -->
  <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Copyright:
    <a class=" fw-bold text-success" href="#">ARCADIA</a>
  </div> 
</footer>

      
      <!-- SCRIPT -->
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/typewriter-effect@latest/dist/core.js"></script>
      <script src="script.js"></script>
  </body>
</html>