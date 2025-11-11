# Rolodex Contact Importer — CLI + Web + Multiusuario + AI

Herramienta para digitalizar contactos de un Rolodex físico a CSV, con interfaz CLI, web (CodeIgniter 4), multiusuario básico, organizaciones (CSV compartido), exportaciones y utilidades de “AI” ligera.

## 📦 Requisitos
- PHP 8.0+ (recomendado 8.1/8.2)
- Extensión intl habilitada si instalas dependencias con Composer
- Servidor embebido de PHP o cualquier servidor compatible

## 🚀 Arranque rápido
1) Clona el repo y sitúate en la carpeta del proyecto.
2) Opcional (según tu flujo): instala dependencias de CI4
   ```bash
   composer install
   # Si falla por ext-intl:
   composer install --ignore-platform-req=ext-intl
   ```
3) Lanza el servidor:
   ```bash
   php -S localhost:8080 -t public
   ```
4) Abre `http://localhost:8080`.

## 💻 Modo CLI
Alta rápida de contactos por terminal:
```bash
php contact-importer.php
```
Guarda en `writable/contacts.csv` (modo global sin sesión).

## 🌐 Modo Web
Rutas clave:
- `/register` y `/login`: registro e inicio de sesión.
- `/contacts`: lista, búsqueda, crear, editar, eliminar, importar CSV y exportar.
- `/contacts/export`: CSV.
- `/contacts/export/vcard` (Premium).
- `/contacts/export/pdf` (Premium).
- `/ai/duplicates` y `/ai/parse` (Premium): duplicados y extracción desde texto.
- `/org`: organizaciones del usuario (crear/seleccionar/salir).
- `/settings`: idioma y plan (free/premium).

Flujo recomendado:
1) Regístrate en `/register` o inicia sesión en `/login`.
2) Gestiona contactos en `/contacts` (CRUD, búsqueda, import/export).
3) Crea una organización en `/org/create` y selecciónala en `/org` para CSV compartido.
4) Cambia a Premium en `/settings` para vCard/PDF/AI.

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

## 🔒 Notas
- Datos en `writable/`. Para producción real, migrar a BD y roles/ACL.
- ext-intl puede ser necesaria para instalar dependencias con Composer.

## 🤝 Recursos
CodeIgniter Docs: https://codeigniter.com/user_guide/
