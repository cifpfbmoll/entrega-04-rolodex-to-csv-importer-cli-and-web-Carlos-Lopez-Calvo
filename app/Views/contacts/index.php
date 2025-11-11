<!DOCTYPE html>
<html lang="es">
<head>
    <title>📇 Mis Contactos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container { 
            max-width: 900px; 
            padding-top: 2rem;
        }
        .card { 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            border: none;
            border-radius: 12px;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            border: none;
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .alert {
            border-radius: 8px;
            border: none;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            text-align: center;
        }
        .stats-badge {
            background-color: rgba(255,255,255,0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="mb-3">📇 Gestor de Contactos</h1>
            <p class="mb-4">Convierte tu Rolodex físico en una agenda digital moderna</p>
            <div class="d-flex justify-content-center gap-2 flex-wrap">
                <a href="/contacts/create" class="btn btn-light">
                    <i class="bi bi-person-plus"></i> Añadir Contacto
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-download"></i> Exportar
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/contacts/export"><i class="bi bi-filetype-csv"></i> CSV</a></li>
                        <li><a class="dropdown-item" href="/contacts/export/vcard"><i class="bi bi-phone"></i> vCard</a></li>
                        <li><a class="dropdown-item" href="/contacts/export/pdf"><i class="bi bi-filetype-pdf"></i> PDF/HTML</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-magic"></i> AI
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/ai/duplicates"><i class="bi bi-intersect"></i> Detectar duplicados</a></li>
                        <li><a class="dropdown-item" href="/ai/parse"><i class="bi bi-clipboard"></i> Extraer desde texto</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Alerts -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Main Card -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i>
                        Lista de Contactos
                    </h4>
                    <div class="d-flex align-items-center gap-2">
                        <?php $org = session()->get('org'); if (!empty($org['id'])): ?>
                            <span class="badge bg-success">Org: <?= esc($org['name']) ?></span>
                        <?php endif; ?>
                        <span class="stats-badge">
                            <i class="bi bi-person-badge me-1"></i>
                            <?= count($contacts) ?> contacto(s)
                        </span>
                        <a class="btn btn-sm btn-outline-light" href="/org">Organizaciones</a>
                        <a class="btn btn-sm btn-outline-light" href="/settings">Configuración</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Import Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="get" action="/contacts" class="d-flex">
                            <input type="text" 
                                   class="form-control me-2" 
                                   name="search" 
                                   placeholder="Buscar por nombre, teléfono o email..." 
                                   value="<?= esc($search) ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="/contacts" class="btn btn-outline-secondary ms-2">
                                    <i class="bi bi-x"></i>
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form method="post" action="/contacts/import" enctype="multipart/form-data" class="d-flex">
                            <?= csrf_field() ?>
                            <input type="file" 
                                   class="form-control me-2" 
                                   name="csv_file" 
                                   accept=".csv" 
                                   required>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-upload"></i> Importar CSV
                            </button>
                        </form>
                    </div>
                </div>
                
                <?php if (empty($contacts)): ?>
                    <div class="text-center py-5">
                        <i class="bi bi-person-x display-1 text-muted"></i>
                        <h5 class="text-muted mt-3">No hay contactos todavía</h5>
                        <p class="text-muted">Comienza añadiendo tu primer contacto o usa la línea de comandos:</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="/contacts/create" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Añadir Primer Contacto
                            </a>
                            <button class="btn btn-outline-secondary" onclick="copyCommand()">
                                <i class="bi bi-terminal"></i> Copiar Comando CLI
                            </button>
                        </div>
                        <div id="commandAlert" class="alert alert-info mt-3" style="display: none;">
                            <small><code>php contact-importer.php</code></small>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i> Nombre</th>
                                    <th><i class="bi bi-telephone me-1"></i> Teléfono</th>
                                    <th><i class="bi bi-envelope me-1"></i> Email</th>
                                    <th><i class="bi bi-gear me-1"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($contacts as $contact): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($contact['name']) ?></strong>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['phone'])): ?>
                                            <a href="tel:<?= esc($contact['phone']) ?>" class="text-decoration-none">
                                                <i class="bi bi-telephone-fill text-success"></i>
                                                <?= esc($contact['phone']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($contact['email'])): ?>
                                            <a href="mailto:<?= esc($contact['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope-fill text-primary"></i>
                                                <?= esc($contact['email']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="/contacts/edit/<?= $contact['index'] ?>" class="btn btn-outline-primary" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="/contacts/delete/<?= $contact['index'] ?>" 
                                               class="btn btn-outline-danger" 
                                               title="Eliminar"
                                               onclick="return confirm('¿Estás seguro de eliminar este contacto?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded">
                                <i class="bi bi-people display-4 text-primary"></i>
                                <h5 class="mt-2"><?= count($contacts) ?></h5>
                                <small class="text-muted">Total Contactos</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded">
                                <?php 
                                $withPhone = count(array_filter($contacts, fn($c) => !empty($c['phone'])));
                                ?>
                                <i class="bi bi-telephone display-4 text-success"></i>
                                <h5 class="mt-2"><?= $withPhone ?></h5>
                                <small class="text-muted">Con Teléfono</small>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded">
                                <?php 
                                $withEmail = count(array_filter($contacts, fn($c) => !empty($c['email'])));
                                ?>
                                <i class="bi bi-envelope display-4 text-info"></i>
                                <h5 class="mt-2"><?= $withEmail ?></h5>
                                <small class="text-muted">Con Email</small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Footer Tips -->
        <div class="text-center mt-4">
            <div class="card bg-light">
                <div class="card-body py-3">
                    <small class="text-muted">
                        <i class="bi bi-lightbulb me-1"></i>
                        <strong>Tip:</strong> También puedes usar la línea de comandos con 
                        <code>php contact-importer.php</code> para una rápida entrada de datos
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function copyCommand() {
            navigator.clipboard.writeText('php contact-importer.php');
            const alert = document.getElementById('commandAlert');
            alert.style.display = 'block';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
