<?php
session_start();
include "../stockage/HeaderOption.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé");
}
?>

<style>
.param-page {
    max-width: 900px;
    margin: 3rem auto;
    padding: 0 1.5rem 5rem;
}

.param-title {
    font-size: 1.75rem;
    font-weight: 900;
    color: #111827;
    margin: 0 0 0.75rem;
}

.param-title-bar {
    height: 5px;
    width: 60px;
    background-color: #2563eb;
    border-radius: 9999px;
    margin-bottom: 2.5rem;
}

.param-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.25rem;
}

.param-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    padding: 2rem 1.5rem;
    border-radius: 1.25rem;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
    text-align: center;
}

.param-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.12);
}

.param-card__icon { font-size: 2rem; }

.param-card--blue   { background-color: #2563eb; color: #ffffff; }
.param-card--green  { background-color: #059669; color: #ffffff; }
.param-card--red    { background-color: #dc2626; color: #ffffff; }

.param-card--blue:hover  { background-color: #1d4ed8; }
.param-card--green:hover { background-color: #047857; }
.param-card--red:hover   { background-color: #b91c1c; }
</style>

<div class="param-page">

    <div class="param-title-bar"></div>

    <div class="param-grid">

        <a href="/Projet_L1/admin/users.php" class="param-card param-card--blue">
            <span class="param-card__icon">👥</span>
            Utilisateurs
        </a>

        <a href="/Projet_L1/employés/ligne.php" class="param-card param-card--green">
            <span class="param-card__icon">🛣️</span>
            Lignes
        </a>

        <a href="/Projet_L1/employés/reset.php" class="param-card param-card--red">
            <span class="param-card__icon">🔄</span>
            Reset système
        </a>

    </div>
</div>

<?php include "../stockage/footer.php"; ?>
