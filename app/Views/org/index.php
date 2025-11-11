<!DOCTYPE html>
<html lang="es">
<head>
    <title>Organizaciones</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>🏢 Organizaciones</h3>
            <a href="/org/create" class="btn btn-primary">Crear organización</a>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                Tus organizaciones
                <?php if (!empty($current['id'])): ?>
                    <span class="badge bg-success ms-2">Actual: <?= esc($current['name']) ?></span>
                    <a href="/org/clear" class="btn btn-sm btn-outline-secondary float-end">Salir del contexto</a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($orgs)): ?>
                    <p class="text-muted mb-0">No perteneces a ninguna organización todavía.</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($orgs as $o): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold"><?= esc($o['name']) ?></div>
                                    <small class="text-muted">Rol: <?= esc($o['role']) ?></small>
                                </div>
                                <div>
                                    <a href="/org/select/<?= esc($o['id']) ?>" class="btn btn-outline-primary btn-sm">Seleccionar</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mt-3">
            <a href="/contacts" class="btn btn-secondary">Volver a contactos</a>
        </div>
    </div>
</body>
</html>


