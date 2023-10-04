<?php require_once INCLUDES . 'header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="text-center">
                <h2 class="mt-5 mb-3">
                    <span class="text-danger">404</span><br />
                    Not Found
                </h2>

                <p>
                    La página o recurso que buscas no existe.
                </p>

                <div class="mt-5">
                    <a class="btn btn-success" href="<?= URL; ?>">
                        <i class="fa-solid fa-rotate-left"></i>
                        Regresar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once INCLUDES . 'footer.php'; ?>