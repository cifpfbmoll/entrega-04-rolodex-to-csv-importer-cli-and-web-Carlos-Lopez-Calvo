<!DOCTYPE html>
<html lang="es">
<head>
    <title>Posibles Duplicados</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>🔍 Posibles Duplicados</h3>
            <a href="/contacts" class="btn btn-secondary">Volver</a>
        </div>
        <?php if (empty($groups)): ?>
            <div class="alert alert-info">No se encontraron duplicados.</div>
        <?php else: ?>
            <?php foreach ($groups as $g): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        Coincidencia por <strong><?= esc($g['type']) ?></strong>: <code><?= esc($g['key']) ?></code>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($g['indexes'] as $idx): $c = $contacts[$idx]; ?>
                                        <tr>
                                            <td><?= $idx ?></td>
                                            <td><?= esc($c['name']) ?></td>
                                            <td><?= esc($c['phone']) ?></td>
                                            <td><?= esc($c['email']) ?></td>
                                            <td>
                                                <a href="/contacts/edit/<?= $c['index'] ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                                                <a href="/contacts/delete/<?= $c['index'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este duplicado?')">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>


