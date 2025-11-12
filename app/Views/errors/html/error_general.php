<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Error</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #d32f2f;
            margin-top: 0;
        }
        .error-message {
            background: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 15px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Error</h1>
        <div class="error-message">
            <strong><?= esc($message ?? 'Ha ocurrido un error') ?></strong>
        </div>
        <p><a href="/">Volver al inicio</a></p>
    </div>
</body>
</html>

