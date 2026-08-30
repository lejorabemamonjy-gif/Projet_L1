    <footer class="site-footer">
        <div class="site-footer__inner">

            <div class="footer-col">
                <span class="footer-logo">TBN</span>
                <p class="footer-desc">
                    Transport en Bus à Madagascar.<br>
                    Réservez votre place en ligne, facilement et rapidement.
                </p>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Navigation</h4>
                <ul class="footer-list">
                    <li><a href="/Projet_L1/Utilisateur/index.php" class="footer-link">Accueil</a></li>
                    <li><a href="/Projet_L1/contact.php"           class="footer-link">Contact</a></li>
                    <li><a href="/Projet_L1/Utilisateur/mes_reservation.php" class="footer-link">Mes réservations</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4 class="footer-heading">Mon compte</h4>
                <ul class="footer-list">
                    <?php if (!isset($_SESSION['role'])): ?>
                        <li><a href="/Projet_L1/login.php"    class="footer-link">Se connecter</a></li>
                        <li><a href="/Projet_L1/register.php" class="footer-link">S'inscrire</a></li>
                    <?php else: ?>
                        <li><a href="/Projet_L1/logout.php" class="footer-link">Se déconnecter</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <div class="site-footer__bottom">
            <p>&copy; <?= date('Y') ?> TBN — votre réservation, sans problème.</p>
        </div>
    </footer>

</body>
</html>
