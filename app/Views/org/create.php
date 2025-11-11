<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear Organización</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Crear Organización</h3>
            <a href="/org" class="btn btn-secondary">Volver</a>
        </div>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <form method="post" action="/org/create">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Nombre de la organización</label>
                        <input type="text" class="form-control" name="name" required minlength="3" placeholder="Mi Empresa S.A.">
                    </div>
                    <button class="btn btn-primary" type="submit">Crear</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


