# 🐳 Guía de Docker

Esta guía te ayudará a usar Docker para evitar problemas con extensiones PHP como `intl`.

## 📋 Requisitos Previos

- Docker instalado ([Descargar Docker Desktop](https://www.docker.com/products/docker-desktop))
- Docker Compose (incluido en Docker Desktop)

## 🚀 Inicio Rápido

### 1. Construir las imágenes

```bash
docker-compose build
```

### 2. Modo Web

Para ejecutar la aplicación web:

```bash
# Levantar el servidor web
docker-compose up -d web

# Ver logs
docker-compose logs -f web

# Acceder a la aplicación
# http://localhost:8080
```

### 3. Modo CLI

Para ejecutar comandos CLI:

```bash
# Ejecutar el importador standalone
docker-compose run --rm cli php contact-importer.php

# Ejecutar comandos de CodeIgniter Spark
docker-compose run --rm cli php spark import:contacts
docker-compose run --rm cli php spark list

# Ejecutar tests
docker-compose run --rm cli composer test
# O directamente:
docker-compose run --rm cli vendor/bin/phpunit
```

### 4. Shell Interactivo

Para trabajar dentro del contenedor:

```bash
# Entrar al contenedor CLI
docker-compose exec cli bash

# Dentro del contenedor puedes ejecutar cualquier comando:
php contact-importer.php
php spark import:contacts
composer install
composer test
```

## 📝 Comandos Útiles

### Gestión de Contenedores

```bash
# Ver contenedores en ejecución
docker-compose ps

# Detener todos los contenedores
docker-compose down

# Detener y eliminar volúmenes
docker-compose down -v

# Ver logs
docker-compose logs -f

# Reconstruir imágenes (si cambias el Dockerfile)
docker-compose build --no-cache
```

### Ejecutar Comandos Específicos

```bash
# Instalar dependencias
docker-compose run --rm cli composer install

# Actualizar dependencias
docker-compose run --rm cli composer update

# Ejecutar tests con cobertura
docker-compose run --rm cli vendor/bin/phpunit --coverage-html coverage

# Verificar estructura del proyecto
docker-compose run --rm cli php spark list
```

## 🧪 Testing con Docker

### Tests Unitarios

```bash
# Ejecutar todos los tests
docker-compose run --rm cli composer test

# Ejecutar un test específico
docker-compose run --rm cli vendor/bin/phpunit tests/CsvFileTest.php

# Tests con verbose
docker-compose run --rm cli vendor/bin/phpunit --verbose
```

### Pruebas Manuales

```bash
# Probar el importador CLI
docker-compose run --rm cli php contact-importer.php

# Verificar el CSV generado
docker-compose run --rm cli cat writable/contacts.csv
```

## 🔧 Solución de Problemas

### Reconstruir desde cero

```bash
# Eliminar contenedores, imágenes y volúmenes
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

### Verificar permisos

```bash
# Asegurar permisos en writable
docker-compose run --rm cli chmod -R 777 writable
```

### Limpiar Docker

```bash
# Limpiar contenedores parados
docker container prune

# Limpiar imágenes no usadas
docker image prune

# Limpiar todo (¡cuidado!)
docker system prune -a
```

## 📦 Estructura de Servicios

- **web**: Servidor web PHP en puerto 8080
- **cli**: Contenedor para comandos CLI y desarrollo

Ambos servicios comparten:
- Volúmenes montados para desarrollo en tiempo real
- Red interna `clvmax-network`
- Mismo código base

## ✅ Ventajas de Docker

- ✅ No necesitas instalar PHP localmente
- ✅ Todas las extensiones incluidas (intl, mbstring, etc.)
- ✅ Entorno consistente entre desarrolladores
- ✅ Fácil de limpiar y reiniciar
- ✅ No contamina tu sistema local

## 🎯 Flujo de Trabajo Recomendado

1. **Desarrollo Web**:
   ```bash
   docker-compose up -d web
   # Trabaja en http://localhost:8080
   ```

2. **Desarrollo CLI**:
   ```bash
   docker-compose exec cli bash
   # Trabaja dentro del contenedor
   ```

3. **Testing**:
   ```bash
   docker-compose run --rm cli composer test
   ```

4. **Al finalizar**:
   ```bash
   docker-compose down
   ```

## 📚 Recursos Adicionales

- [Documentación de Docker](https://docs.docker.com/)
- [Docker Compose Reference](https://docs.docker.com/compose/compose-file/)

