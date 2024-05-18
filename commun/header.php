<!-- header.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">

        <a class="navbar-brand" href="index.php?page=actualite"><img src="/image/Logos/logo-removebg-preview.png" alt="" style="height: 60px;width: 100%;object-fit: cover"></a>

        <div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    if (est_connecter()) { ?>
                        <div class="icon-container">
                            <a href="index.php?page=ajouter"><i class="fa-solid fa-circle-plus"></i></a>
                            <div class="hover-text">Créer une publication</div>
                        </div>
                        <li class="nav-item">
                            <a class="nav-link fw-bold <?= (isset($_GET['page']) && !empty($_GET['page']) && 'actualite' === $_GET['page']) ? 'active' : ''; ?>" aria-current="page" href="index.php?page=actualite">Actualite</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold <?= (isset($_GET['page']) && !empty($_GET['page']) && 'mes-publication' === $_GET['page']) ? 'active' : ''; ?>" href="index.php?page=mes-publications">Mes Publication</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold <?= (isset($_GET['page']) && !empty($_GET['page']) && 'profil' === $_GET['page']) ? 'active' : ''; ?>" href="index.php?page=mon-profil">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-bold <?= (isset($_GET['page']) && !empty($_GET['page']) && ('deconnexion' === $_GET['page'])) ? 'active' : ''; ?>" href="index.php?page=deconnexion">Deconnexion</a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold <?= (isset($_GET['page']) && !empty($_GET['page']) && ('connexion' === $_GET['page'])) ? 'active' : ''; ?>" href="index.php?page=connexion">connexion</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
</nav>