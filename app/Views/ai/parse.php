<!DOCTYPE html>
<html lang="es">
<head>
    <title>Parsear Contacto desde Texto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>🧠 Extraer contacto desde texto</h3>
            <a href="/contacts" class="btn btn-secondary">Volver</a>
        </div>
        <div class="row">
            <div class="col-md-7">
                <form method="post" action="/ai/parse">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Pega aquí texto de una tarjeta/email (Nombre, Teléfono, Email...)</label>
                        <textarea name="text" class="form-control" rows="10" placeholder="Ejemplo:
Juan Pérez
Agente de viajes
Tel: +34 600 123 456
Email: juan.perez@viajes.com"></textarea>
                    </div>
                    <button class="btn btn-primary" type="submit">Analizar</button>
                </form>
            </div>
            <div class="col-md-5">
                <?php if (!empty($result)): ?>
                    <div class="card">
                        <div class="card-header">Resultado detectado</div>
                        <div class="card-body">
                            <p><strong>Nombre:</strong> <?= esc($result['name']) ?: '-' ?></p>
                            <p><strong>Teléfono:</strong> <?= esc($result['phone']) ?: '-' ?></p>
                            <p><strong>Email:</strong> <?= esc($result['email']) ?: '-' ?></p>
                            <?php if (!empty($result['name'])): ?>
                                <form method="post" action="/contacts/store">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="name" value="<?= esc($result['name']) ?>">
                                    <input type="hidden" name="phone" value="<?= esc($result['phone']) ?>">
                                    <input type="hidden" name="email" value="<?= esc($result['email']) ?>">
                                    <button class="btn btn-success" type="submit">Guardar como contacto</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>


