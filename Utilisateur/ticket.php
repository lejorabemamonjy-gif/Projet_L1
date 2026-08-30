<?php
session_start();

if (!isset($_SESSION['id_utilisateur'])) {
    header("Location: /Projet_L1/login.php?message=connexion_requise");
    exit();
}

include('../stockage/header.php');

$conn    = new mysqli('localhost', 'root', '', 'tbn');
$id_user = intval($_SESSION['id_utilisateur']);

// Accepter un id_reservation précis en GET, sinon prendre le dernier
$id_res = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_res > 0) {
    $stmt = $conn->prepare("
        SELECT r.*, t.heure, t.jour, v.matricule, v.chauffeur,
               ro.nom_route, ro.prix
        FROM reservation r
        JOIN trajet  t  ON r.id_trajet  = t.id_trajet
        JOIN voiture v  ON t.id_voiture = v.id_voiture
        JOIN route   ro ON t.id_route   = ro.id_route
        WHERE r.id_reservation = ? AND r.id_utilisateur = ?
    ");
    $stmt->bind_param("ii", $id_res, $id_user);
} else {
    $stmt = $conn->prepare("
        SELECT r.*, t.heure, t.jour, v.matricule, v.chauffeur,
               ro.nom_route, ro.prix
        FROM reservation r
        JOIN trajet  t  ON r.id_trajet  = t.id_trajet
        JOIN voiture v  ON t.id_voiture = v.id_voiture
        JOIN route   ro ON t.id_route   = ro.id_route
        WHERE r.id_utilisateur = ?
        ORDER BY r.id_reservation DESC
        LIMIT 1
    ");
    $stmt->bind_param("i", $id_user);
}

$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("❌ Ticket introuvable.");
}
?>
<style>
body { background:#f1f5f9; font-family:'Segoe UI',system-ui,sans-serif; }

.ticket-wrapper {
    max-width: 480px;
    margin: 3rem auto 5rem;
    padding: 0 1rem;
}

.ticket-card {
    background: #fff;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
}

.ticket-header {
    background: #1f2937;
    color: #fff;
    padding: 2rem 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.ticket-header .company { font-size: 1.5rem; font-weight: 900; letter-spacing: 0.15em; }
.ticket-header .route   { font-size: 1rem; opacity: 0.7; margin-top: 0.25rem; }

.ticket-ref {
    background: #111827;
    text-align: center;
    padding: 0.6rem;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: #94a3b8;
    text-transform: uppercase;
}

.ticket-body { padding: 1.75rem 2rem; }

.ticket-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.ticket-row:last-child { border-bottom: none; }

.ticket-label {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    color: #94a3b8;
}

.ticket-value {
    font-size: 0.95rem;
    font-weight: 700;
    color: #111827;
}

/* Séparateur pointillé façon ticket */
.ticket-separator {
    display: flex;
    align-items: center;
    margin: 0 -2rem;
    position: relative;
}
.ticket-separator::before,
.ticket-separator::after {
    content: '';
    width: 22px;
    height: 22px;
    background: #f1f5f9;
    border-radius: 50%;
    flex-shrink: 0;
}
.ticket-separator span {
    flex: 1;
    border-top: 2px dashed #e5e7eb;
}

/* Badge statut */
.ticket-status {
    text-align: center;
    padding: 1rem 2rem 1.5rem;
}

.badge-active {
    display: inline-block;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    padding: 0.4rem 1rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 700;
}

.badge-annulee {
    display: inline-block;
    background: #f3f4f6;
    color: #6b7280;
    border: 1px solid #d1d5db;
    padding: 0.4rem 1rem;
    border-radius: 9999px;
    font-size: 0.8rem;
    font-weight: 700;
}

/* Actions */
.ticket-actions {
    display: flex;
    gap: 0.75rem;
    padding: 0 2rem 2rem;
}

.btn-print {
    flex: 1;
    background: #1f2937;
    color: #fff;
    border: none;
    padding: 0.85rem;
    border-radius: 0.75rem;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-print:hover { background: #2563eb; }

.btn-back {
    display: flex;
    flex: 1;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    padding: 0.85rem;
    border-radius: 0.75rem;
    font-weight: 700;
    font-size: 0.9rem;
    transition: background 0.2s;
}
.btn-back:hover { background: #e5e7eb; }

@media print {
    nav, footer, .ticket-actions { display: none !important; }
    body { background: #fff; }
    .ticket-wrapper { margin: 0; }
    .ticket-card { box-shadow: none; }
}
</style>

<div class="ticket-wrapper">
    <div class="ticket-card">

        <div class="ticket-header">
            <div class="company">TBN 🎟️</div>
            <div class="route"><?= htmlspecialchars($data['nom_route']) ?></div>
        </div>

        <div class="ticket-ref">
            Réservation #<?= str_pad($data['id_reservation'], 6, '0', STR_PAD_LEFT) ?>
        </div>

        <div class="ticket-body">
            <div class="ticket-row">
                <span class="ticket-label">Jour</span>
                <span class="ticket-value"><?= htmlspecialchars($data['jour']) ?></span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Départ</span>
                <span class="ticket-value"><?= htmlspecialchars(substr($data['heure'], 0, 5)) ?></span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Voiture</span>
                <span class="ticket-value"><?= htmlspecialchars($data['matricule']) ?></span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Chauffeur</span>
                <span class="ticket-value"><?= htmlspecialchars($data['chauffeur']) ?></span>
            </div>
        </div>

        <div class="ticket-separator"><span></span></div>

        <div class="ticket-body">
            <div class="ticket-row">
                <span class="ticket-label">Place</span>
                <span class="ticket-value" style="font-size:1.4rem;color:#2563eb;"><?= intval($data['num_place']) ?></span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Prix</span>
                <span class="ticket-value"><?= number_format($data['prix'], 0, ',', ' ') ?> Ar</span>
            </div>
            <div class="ticket-row">
                <span class="ticket-label">Réservé le</span>
                <span class="ticket-value"><?= date('d/m/Y à H:i', strtotime($data['created_at'])) ?></span>
            </div>
        </div>

        <div class="ticket-status">
            <?php if ($data['status'] === 'active'): ?>
                <span class="badge-active">✅ Réservation active</span>
            <?php else: ?>
                <span class="badge-annulee">✕ Annulée</span>
            <?php endif; ?>
        </div>

        <div class="ticket-actions">
            <button class="btn-print" onclick="window.print()">🖨️ Imprimer / PDF</button>
            <a href="mes_reservation.php" class="btn-back">← Retour</a>
        </div>

    </div>
</div>

<?php include('../stockage/footer.php'); ?>
