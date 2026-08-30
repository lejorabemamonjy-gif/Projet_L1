<?php include "stockage/HeaderOption.php"; ?>

<style>
/* ---- Page contact ---- */
.contact-page {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 1.5rem 5rem;
}

/* En-tête */
.contact-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin: 4rem 0 3rem;
    text-align: center;
}

.contact-main-title {
    font-size: 3rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    color: #111827;
    margin: 0 0 0.75rem;
    /* Dégradé rouge sang */
    background: linear-gradient(180deg, #450a0a 0%, #991b1b 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    filter: drop-shadow(0 4px 4px rgba(0,0,0,0.25));
}

.contact-title-bar {
    height: 6px;
    width: 96px;
    background-color: #7f1d1d;
    border-radius: 9999px;
    box-shadow: 0 2px 6px rgba(127,29,29,0.4);
}

/* Sections */
.contact-section {
    margin-bottom: 3.5rem;
}

.contact-section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}

.contact-section-bar {
    width: 6px;
    height: 28px;
    background-color: #b91c1c;
    border-radius: 9999px;
    flex-shrink: 0;
}

.contact-section-title {
    font-size: 1.25rem;
    font-weight: 900;
    color: #1f2937;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin: 0;
}

/* Tableau */
.contact-table-wrap {
    border-radius: 1.25rem;
    overflow: hidden;
    border: 1px solid #f1f5f9;
    box-shadow: 0 10px 25px rgba(0,0,0,0.07);
    background-color: #ffffff;
}

.contact-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}

.contact-table thead tr {
    background-color: #1f2937;
    color: #ffffff;
}

.contact-table th {
    padding: 1rem 1.25rem;
    font-size: 0.72rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
}

.contact-table tbody tr {
    border-top: 1px solid #f1f5f9;
    transition: background-color 0.15s;
}

.contact-table tbody tr:hover {
    background-color: #fff5f5;
}

.contact-table td {
    padding: 1rem 1.25rem;
    font-size: 0.9rem;
    color: #374151;
}

.contact-table td:first-child {
    font-weight: 700;
    color: #111827;
}

.contact-table td.mono {
    font-family: 'Courier New', monospace;
    color: #6b7280;
    font-style: italic;
}

.contact-link-wa {
    color: #374151;
    text-decoration: none;
    transition: color 0.15s;
}
.contact-link-wa:hover { color: #16a34a; }

.contact-badge-fb {
    display: inline-block;
    background-color: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    padding: 0.2rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 700;
}

.contact-link-mail {
    color: #2563eb;
    text-decoration: none;
    transition: color 0.15s;
}
.contact-link-mail:hover { text-decoration: underline; }

/* Responsive */
@media (max-width: 640px) {
    .contact-main-title { font-size: 2rem; }
    .contact-table th,
    .contact-table td { padding: 0.75rem; font-size: 0.82rem; }
}
</style>

<?php
$equipes = [
    "Bureau" => [
        ["nom" => "Abishai", "tel" => "+261 38 06 803 76", "fb" => "RMTA",     "mail" => "rmta@gmail.com"],
        ["nom" => "Bryan",   "tel" => "+261 38 05 813 76", "fb" => "Jo Bryan", "mail" => "jobryan@gmail.com"],
        ["nom" => "Nante",   "tel" => "+261 38 36 808 76", "fb" => "Nan Te",   "mail" => "nante@gmail.com"],
    ],
    "Chauffeur" => [
        ["nom" => "Menja",    "tel" => "+261 38 06 803 76", "fb" => "Ma be",        "mail" => "menja@gmail.com"],
        ["nom" => "Rondro",   "tel" => "+261 38 05 813 76", "fb" => "Rondro Kely",  "mail" => "rondro@gmail.com"],
        ["nom" => "Nathalie", "tel" => "+261 38 36 808 76", "fb" => "Nathalie",     "mail" => "nathalie@gmail.com"],
    ],
];
?>

<div class="contact-page">

    <section class="contact-header">
        <h1 class="contact-main-title">Employés</h1>
        <div class="contact-title-bar"></div>
    </section>

    <?php foreach ($equipes as $titre => $membres): ?>
    <section class="contact-section">

        <div class="contact-section-header">
            <div class="contact-section-bar"></div>
            <h2 class="contact-section-title"><?= htmlspecialchars($titre) ?></h2>
        </div>

        <div class="contact-table-wrap">
            <table class="contact-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>WhatsApp</th>
                        <th>Facebook</th>
                        <th>E-mail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($membres as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['nom']) ?></td>
                        <td class="mono">
                            <a href="https://wa.me/<?= str_replace([' ', '+'], '', $m['tel']) ?>"
                               class="contact-link-wa">
                                <?= htmlspecialchars($m['tel']) ?>
                            </a>
                        </td>
                        <td>
                            <span class="contact-badge-fb"><?= htmlspecialchars($m['fb']) ?></span>
                        </td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($m['mail']) ?>"
                               class="contact-link-mail">
                                <?= htmlspecialchars($m['mail']) ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
    <?php endforeach; ?>

</div>

<?php include "stockage/footer.php"; ?>
