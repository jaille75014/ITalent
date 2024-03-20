<footer>
  
  <div class="row">
    <div class="col-12 col-lg-3">
      <img src="assets/man_working.png" class="logo" height="120px">
      <p>Le Treizième Travail d'Hercule : Trouver un emploi.</p>
    </div>
      <div class=" col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Nous contacter</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="https://maps.app.goo.gl/qd5XGyCC3ew7SA596" target="_blank" class="text-white"><i class='bx bxs-map'></i>21 rue Erard, 75012 Paris</a>
            </li>
            <li class="mb-2">
              <a href="tel:0602081047" class="text-white"><i class='bx bxs-phone'></i>+33 6 02 08 10 47</a>
            </li>
            <li class="mb-2">
              <a href="mailto:contact@italent.com" class="text-white"><i class='bx bxs-mail'>contact@italent.site</i></a>
            </li>
          </ul>
        </div>


        <div class="col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Liens</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="connexion.php" class="text-white">Se connecter</a>
            </li>
            <li class="mb-2">
              <a href="inscription.php" class="text-white">S'enregistrer</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">A propos de nous</a>
            </li>
          </ul>
    </div>

    <div class="col-12 col-lg-3">
        <h5 class="text-uppercase mb-4">Informations légales</h5>
        <ul class="list-unstyled">
            <li class="mb-2">
              <a href="#!" class="text-white">Mentions légales</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Conditions généraless</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Politique de confidentialité</a>
            </li>
            <li class="mb-2">
              <a href="#!" class="text-white">Utilisation des cookies</a>
            </li>
          </ul>
    </div>
  </div>

  <div class="row">
      <div class="col-8 offset-2 col-lg-4 offset-lg-4">
      <h5 class="text-uppercase mb-4">Newsletter</h5>

      <form action="<?php echo '../back/verification_newsletter.php?url=' . $url ?>" method="POST">
      <i class='bx bxs-envelope'></i>
      <input type="email" name="email" placeholder="Entrez votre e-mail" required>
      <button type="submit"><i class='bx bx-right-arrow-alt'></i></button>
    </form>
      </div>
  </div>
  </div>
  <hr>
  <p class="copyright">Tous droits réservés &copy 2024 - ITalent </p>

</footer>