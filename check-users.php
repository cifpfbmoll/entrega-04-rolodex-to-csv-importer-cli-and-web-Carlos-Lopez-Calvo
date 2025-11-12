<?php
/**
 * Script para verificar usuarios registrados
 * Uso: docker-compose exec web php check-users.php
 */

require __DIR__ . '/vendor/autoload.php';

// Definir constantes necesarias
define('ROOTPATH', __DIR__ . '/');
define('WRITEPATH', __DIR__ . '/writable/');
define('ENVIRONMENT', 'development');

$usersFile = WRITEPATH . 'users.json';

echo "=== Verificación de Usuarios ===\n\n";

// Verificar archivo de usuarios
if (!file_exists($usersFile)) {
    echo "❌ El archivo users.json no existe: $usersFile\n";
    exit(1);
}

echo "✅ Archivo users.json existe: $usersFile\n\n";

// Leer usuarios
$raw = file_get_contents($usersFile);
$users = json_decode($raw ?: '[]', true);

if (!is_array($users)) {
    echo "❌ Error: El archivo users.json no contiene un array válido\n";
    exit(1);
}

echo "📊 Total de usuarios registrados: " . count($users) . "\n\n";

if (empty($users)) {
    echo "⚠️  No hay usuarios registrados todavía.\n";
    echo "   Crea una cuenta desde: http://localhost:8080/register\n";
    exit(0);
}

// Mostrar información de cada usuario
foreach ($users as $index => $user) {
    $num = $index + 1;
    echo "--- Usuario #$num ---\n";
    echo "  ID: " . ($user['id'] ?? 'N/A') . "\n";
    echo "  Nombre: " . ($user['name'] ?? 'N/A') . "\n";
    echo "  Email: " . ($user['email'] ?? 'N/A') . "\n";
    echo "  Fecha de creación: " . ($user['createdAt'] ?? 'N/A') . "\n";
    
    // Verificar si tiene directorio y CSV
    $userId = $user['id'] ?? null;
    if ($userId) {
        $userDir = WRITEPATH . 'users/' . $userId;
        $csvFile = $userDir . '/contacts.csv';
        
        if (is_dir($userDir)) {
            echo "  ✅ Directorio de usuario existe: $userDir\n";
        } else {
            echo "  ⚠️  Directorio de usuario NO existe: $userDir\n";
        }
        
        if (file_exists($csvFile)) {
            $csvSize = filesize($csvFile);
            echo "  ✅ Archivo CSV existe: $csvFile ($csvSize bytes)\n";
        } else {
            echo "  ⚠️  Archivo CSV NO existe: $csvFile\n";
        }
    }
    
    echo "\n";
}

echo "=== Fin de la verificación ===\n";

