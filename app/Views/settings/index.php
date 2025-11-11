<!DOCTYPE html>
<html lang="es">
<head>
    <title>Configuración</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>⚙️ Configuración</h3>
            <a href="/contacts" class="btn btn-secondary">Volver</a>
        </div>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <div class="card">
            <div class="card-body">
                <form method="post" action="/settings">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Idioma</label>
                            <select class="form-select" name="lang">
                                <option value="es" <?= $lang==='es'?'selected':'' ?>>Español</option>
                                <option value="en" <?= $lang==='en'?'selected':'' ?>>English</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Plan</label>
                            <select class="form-select" name="plan">
                                <option value="free" <?= $plan==='free'?'selected':'' ?>>Free</option>
                                <option value="premium" <?= $plan==='premium'?'selected':'' ?>>Premium</option>
                            </select>
                            <small class="text-muted d-block mt-1">Premium desbloquea vCard, PDF y AI.</small>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


