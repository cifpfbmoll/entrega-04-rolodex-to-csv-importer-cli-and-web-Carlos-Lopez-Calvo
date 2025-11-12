# Rolodex Contact Importer — CLI + Web + Multiusuario + AI

Herramienta para digitalizar contactos de un Rolodex físico a CSV, con interfaz CLI, web (CodeIgniter 4), multiusuario básico, organizaciones (CSV compartido), exportaciones y utilidades de “AI” ligera.

## 📦 Requisitos

### Opción 1: Docker (Recomendado) 🐳
- Docker Desktop instalado ([Descargar aquí](https://www.docker.com/products/docker-desktop))
- Docker Compose (incluido en Docker Desktop)

### Opción 2: Instalación Local
- PHP 8.0+ (recomendado 8.1/8.2)
- Extensión `intl` habilitada
- Composer instalado
- Servidor embebido de PHP o cualquier servidor compatible

## 🚀 Arranque Rápido

### Con Docker (Recomendado) 🐳

Esta es la forma más fácil y evita problemas con extensiones PHP:

```bash
# 1. Clona el repositorio y entra al directorio
git clone <url-del-repo>
cd entrega-04-rolodex-to-csv-importer-cli-and-web-Carlos-Lopez-Calvo

# 2. Construye las imágenes Docker
docker-compose build

# 3. Levanta el servidor web
docker-compose up -d web

# 4. Accede a la aplicación
# Abre tu navegador en: http://localhost:8080
```

**Comandos útiles con Docker:**

```bash
# Ver logs del servidor web
docker-compose logs -f web

# Detener el servidor
docker-compose down

# Reiniciar el servidor
docker-compose restart web

# Ejecutar comandos CLI
docker-compose run --rm cli php contact-importer.php

# Entrar al contenedor CLI
docker-compose exec cli bash
```

📖 **Para más detalles sobre Docker, consulta [DOCKER.md](DOCKER.md)**

### Sin Docker (Instalación Local)

```bash
# 1. Clona el repositorio y entra al directorio
git clone <url-del-repo>
cd entrega-04-rolodex-to-csv-importer-cli-and-web-Carlos-Lopez-Calvo

# 2. Instala dependencias
composer install
# Si falla por ext-intl:
composer install --ignore-platform-req=ext-intl

# 3. Lanza el servidor
php -S localhost:8080 -t public

# 4. Abre http://localhost:8080 en tu navegador
```

## 💻 Modo CLI

### Con Docker
```bash
# Ejecutar el importador standalone
docker-compose run --rm cli php contact-importer.php

# O entrar al contenedor CLI
docker-compose exec cli bash
# Luego ejecutar:
php contact-importer.php
```

### Sin Docker
```bash
php contact-importer.php
```

Guarda en `writable/contacts.csv` (modo global sin sesión).

## 🌐 Modo Web

### Acceso
- **Con Docker**: http://localhost:8080
- **Sin Docker**: http://localhost:8080 (después de ejecutar `php -S localhost:8080 -t public`)

### Rutas Principales
- **`/register`** y **`/login`**: Registro e inicio de sesión
- **`/contacts`**: Lista, búsqueda, crear, editar, eliminar, importar CSV y exportar
- **`/contacts/export`**: Exportar a CSV
- **`/contacts/export/vcard`**: Exportar a vCard (requiere plan Premium)
- **`/contacts/export/pdf`**: Exportar a PDF (requiere plan Premium)
- **`/ai/duplicates`**: Detectar contactos duplicados (requiere plan Premium)
- **`/ai/parse`**: Extraer contactos desde texto libre (requiere plan Premium)
- **`/org`**: Gestionar organizaciones (crear/seleccionar/salir)
- **`/settings`**: Configurar idioma y plan (free/premium)

### Flujo Recomendado

1. **Registro/Login**:
   - Ve a `http://localhost:8080/register` para crear una cuenta
   - O inicia sesión en `http://localhost:8080/login` si ya tienes cuenta

2. **Gestionar Contactos**:
   - Accede a `http://localhost:8080/contacts`
   - Puedes crear, editar, eliminar y buscar contactos
   - Importa contactos desde un archivo CSV
   - Exporta tus contactos a CSV

3. **Organizaciones** (Opcional):
   - Crea una organización en `/org/create`
   - Selecciónala en `/org` para usar un CSV compartido entre miembros

4. **Funciones Premium** (Opcional):
   - Ve a `/settings` y cambia tu plan a "Premium"
   - Desbloquea exportación a vCard/PDF y funciones de AI

## 🧠 AI ligera (sin servicios externos)
- Duplicados por nombre/email/teléfono normalizados.
- Parser de contacto desde texto libre.
- Búsqueda semántica simple (sinónimos básicos).

## 🏷️ Multiusuario y Organizaciones
- Usuarios en `writable/users.json` (contraseña con hash).
- Contactos por usuario: `writable/users/{userId}/contacts.csv`.
- Organizaciones con CSV compartido: `writable/orgs/{orgId}/contacts.csv`.
- Badge de organización activa en la cabecera del listado.

## 📤 Import/Export
- Importar CSV desde `/contacts`.
- Exportar:
  - CSV: libre.
  - vCard (.vcf): Premium.
  - PDF/HTML: Premium.

## 📁 Estructura relevante
```
app/
  Controllers/ (Contacts, Auth, Org, AI, Settings)
  Helpers/     (ContactHelper, OrgHelper, AIHelper)
  Views/       (contacts, auth, org, ai, settings)
public/index.php
contact-importer.php  # CLI standalone
writable/
  contacts.csv        # Global (sin sesión)
  users/{id}/contacts.csv
  orgs/{id}/contacts.csv
```

## ✅ Características
- CLI: entrada rápida.
- Web: Bootstrap 5, tabla, búsqueda, métricas, tel/mail.
- CRUD completo.
- Import CSV, export CSV/vCard/PDF (premium).
- AI: duplicados y parser desde texto.
- Multiusuario + organizaciones.
- Ajustes: idioma y plan.

## 🧪 Testing

### Con Docker
```bash
# Ejecutar todos los tests
docker-compose run --rm cli composer test

# O directamente con PHPUnit
docker-compose run --rm cli vendor/bin/phpunit
```

### Sin Docker
```bash
composer test
# O
vendor/bin/phpunit
```

## 🔧 Solución de Problemas

### Problemas Comunes

**Error: "ext-intl no encontrada"**
- **Solución con Docker**: No deberías tener este problema, Docker incluye todas las extensiones
- **Solución sin Docker**: Instala la extensión o usa `composer install --ignore-platform-req=ext-intl`

**El servidor no inicia**
- **Con Docker**: Verifica que Docker esté corriendo y ejecuta `docker-compose logs web`
- **Sin Docker**: Verifica que el puerto 8080 esté libre

**No puedo guardar contactos**
- Verifica los permisos del directorio `writable/`
- **Con Docker**: `docker-compose run --rm cli chmod -R 777 writable`
- **Sin Docker**: `chmod -R 777 writable`

**El helper no se carga**
- Este problema ya está resuelto en el código actual
- Si persiste, reinicia el servidor

### Verificar Usuarios Registrados

```bash
# Con Docker
docker-compose exec web php check-users.php

# Sin Docker
php check-users.php
```

## 🔒 Notas de Seguridad

- Los datos se almacenan en `writable/` (archivos JSON y CSV)
- Las contraseñas están hasheadas con `password_hash()`
- **Para producción**: Migrar a base de datos y implementar roles/ACL
- La extensión `intl` puede ser necesaria para instalar dependencias con Composer (Docker la incluye automáticamente)

## 📚 Recursos Adicionales

- [Documentación de CodeIgniter 4](https://codeigniter.com/user_guide/)
- [Guía completa de Docker](DOCKER.md) - Detalles sobre el uso de Docker
- [Estructura del Proyecto](PROJECT_STRUCTURE.md) - Documentación detallada de la estructura

## 🎯 Resumen de Comandos Rápidos

### Docker (Recomendado)
```bash
# Iniciar
docker-compose up -d web

# Ver logs
docker-compose logs -f web

# CLI
docker-compose run --rm cli php contact-importer.php

# Tests
docker-compose run --rm cli composer test

# Detener
docker-compose down
```

### Sin Docker
```bash
# Iniciar servidor
php -S localhost:8080 -t public

# CLI
php contact-importer.php

# Tests
composer test
```
