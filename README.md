# EligeCoche 🚘

**Crea un coche a tu medida.** Aplicación web para configurar vehículos eligiendo **piezas propias** —carrocería, motor, pintura, puertas, ruedas, tracción y accesorios—, obtener un presupuesto orientativo y seguir sus etapas de fabricación.

Este repositorio es una **refactorización y modernización para portfolio** del proyecto final de **Desarrollo de Aplicaciones Web (DAW, 2023)**. Conserva su propósito y los flujos descritos en la memoria original, e incorpora una arquitectura modular, diseño responsive y mejoras de seguridad. Es una **demo educativa**: no se compran, fabrican ni reparan coches reales.

## Funcionalidades

| Visitantes | Clientes | Operarios |
| --- | --- | --- |
| Página de inicio, catálogo y ranking de piezas | Registro e inicio de sesión | Panel restringido |
| Consultar mercado de ocasión | Configurar coche y calcular presupuesto | Marcar etapas de fabricación |
| Conocer el proyecto y contactar | Guardar pedidos y consultar su avance | Actualizar solicitudes de taller |
| | Solicitar mantenimiento | Leer mensajes de contacto |
| | Publicar/retirar anuncios de ocasión | |

**Configurador:** seis categorías obligatorias y una opcional. La interfaz actualiza el precio estimado al elegir piezas; el servidor **recalcula y valida** cada elemento contra el catálogo antes de almacenar el pedido. El proceso de fabricación se divide en siete etapas.

## Tecnologías

- **Backend:** PHP 8.3, PDO y MySQL/MariaDB.
- **Frontend:** HTML5, CSS3 y JavaScript nativo, sin dependencias ni frameworks externos.
- **Infraestructura:** Docker Compose (PHP + Apache + MariaDB).
- **Pruebas:** test runner propio en PHP y workflow de GitHub Actions para sintaxis y pruebas.

## Requisitos

**Opción recomendada:** [Docker Desktop](https://www.docker.com/products/docker-desktop/) (con Docker Compose). También puedes instalar **PHP 8.3+**, la extensión **pdo_mysql**, **MySQL/MariaDB** y un servidor web manualmente.

## Puesta en marcha con Docker

Desde la carpeta raíz del repositorio:

```bash
cp .env.example .env
# Abre .env y cambia DB_PASSWORD y MYSQL_ROOT_PASSWORD por valores seguros.
docker compose up --build -d
```

Abre **http://localhost:8080**.

La **primera** creación del contenedor de MariaDB importa automáticamente `database/01_schema.sql` y `database/02_seed.sql`. La tabla de usuarios empieza vacía: no se distribuyen las contraseñas inseguras ni los datos personales de la antigua base de datos. Crea una cuenta cliente desde **Registro**.

Para crear una cuenta de operario:

```bash
docker compose exec web php bin/create-staff.php
```

El script te pedirá nombre, email y una contraseña segura. Entra después por **Acceder**; las cuentas de operario llegan al panel `/operarios`.

Para apagar los servicios sin borrar los datos:

```bash
docker compose down
```

Para **reiniciar por completo los datos de la demo** (destructivo):

```bash
docker compose down -v
docker compose up --build -d
```

> Si usas Windows PowerShell, sustituye `cp` por `Copy-Item .env.example .env`.

## Ejecución sin Docker

1. Crea una base de datos vacía con nombre `eligecoche` (o el que prefieras).
2. Importa, **en este orden**, `database/01_schema.sql` y `database/02_seed.sql`.
3. Copia `.env.example` a `.env` y configura `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` y `DB_PASSWORD` con los valores de tu servidor local. Establece `APP_DEBUG=0` si está disponible públicamente.
4. Arranca el servidor de desarrollo desde la raíz:

```bash
php -S localhost:8080 -t public public/router.php
```

5. Accede a **http://localhost:8080**. Para crear un operario: `php bin/create-staff.php`.

> Usa `public/` como **DocumentRoot** en Apache/Nginx. **No publiques la raíz del repositorio**, para evitar exponer `.env`, `database/`, `app/` y la documentación.

## Estructura del proyecto

```text
EligeCoche-Portfolio/
├── .github/workflows/php.yml   # CI de sintaxis y pruebas
├── app/
│   ├── Controllers/            # Rutas: acciones y autorización
│   ├── Core/                   # PDO, sesiones, CSRF, validación, helpers
│   ├── Models/                 # Consultas y persistencia
│   ├── Services/               # Reglas y presupuesto del configurador
│   └── Views/                  # Plantillas organizadas por funcionalidad
├── bin/create-staff.php        # Alta segura de cuentas de operario
├── config/bootstrap.php        # Autoload y configuración
├── database/
│   ├── 01_schema.sql           # Modelo relacional nuevo
│   └── 02_seed.sql             # Catálogo de piezas inicial
├── docs/
│   ├── ARQUITECTURA.md
│   ├── MEJORAS.md
│   ├── Memoria-DAW-2023.pdf    # Documento original
│   └── Presentacion-DAW-2023.pptx
├── public/
│   ├── assets/css/styles.css
│   ├── assets/js/app.js
│   ├── assets/images/...
│   ├── .htaccess
│   ├── index.php              # Punto de entrada y rutas
│   └── router.php             # Servidor de desarrollo
├── tests/run.php
├── Dockerfile
├── docker-compose.yml
└── .env.example
```

## Pruebas

Ejecuta desde la raíz:

```bash
php tests/run.php
find app config public bin tests -name '*.php' -exec php -l {} \;
```

En PowerShell para comprobar sintaxis:

```powershell
Get-ChildItem app,config,public,bin,tests -Recurse -Filter *.php | ForEach-Object { php -l $_.FullName }
```

El test runner cubre la selección obligatoria, validación por categoría, protección frente a piezas inexistentes, accesorios repetidos, conversión de precios, validación y escapado HTML. **No sustituye pruebas de integración con MariaDB o pruebas end-to-end**, que requieren una base de datos ejecutándose. GitHub Actions los ejecuta automáticamente en `push` y `pull_request`.

## Seguridad y decisiones técnicas

- Consultas con **PDO y sentencias preparadas** (no concatenación de entradas en SQL).
- Contraseñas con `password_hash()` y verificación mediante `password_verify()`.
- Validación en servidor, salida HTML escapada y token **CSRF** en formularios POST.
- Sesiones con cookies `HttpOnly`, `SameSite=Lax`, regeneración de ID y protección básica frente a intentos de login repetidos por sesión.
- Acceso a pedidos por su dueño o por operario autorizado; el área interna requiere rol `staff`.
- Credenciales fuera de Git mediante `.env` ignorado.
- El dump antiguo no se reutiliza: contenía datos que no deben publicarse.

**Aviso:** la app es una demo de portfolio, no una aplicación auditada para producción. Antes de un uso comercial real, añade tests de integración, controles antifraude, verificaciones específicas del negocio, protección frente a bots a nivel de servidor, recuperación de contraseñas segura y procesos de privacidad/consentimiento conforme a la normativa aplicable. Los precios y anuncios son únicamente ilustrativos. No incorpora pagos ni envío de correos.

## Subir a GitHub

1. Crea un repositorio **vacío** en GitHub, por ejemplo `eligecoche-portfolio` (sin inicializar README ni `.gitignore`).
2. Abre una terminal en la carpeta del proyecto y ejecuta:

```bash
git init
git add .
git commit -m "Refactoriza EligeCoche para portfolio DAW"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/eligecoche-portfolio.git
git push -u origin main
```

Sustituye **`TU_USUARIO`** por tu usuario de GitHub. Si `git commit` pide configurar la identidad, ejecuta `git config --global user.name "Tu nombre"` y `git config --global user.email "tu-email@example.com"` y vuelve a intentarlo. GitHub te solicitará autenticarte mediante navegador, Git Credential Manager o una clave/token; no uses tu contraseña de GitHub en comandos.

Para futuras actualizaciones:

```bash
git add .
git commit -m "Describe tus cambios"
git push
```

**Importante:** no ejecutes `git add -f .env`; comprueba que el fichero de secretos se mantiene excluido con `git status`.

## Origen y documentación

Basado en la memoria y presentación originales conservadas en `docs/`. Consulta [`docs/ARQUITECTURA.md`](docs/ARQUITECTURA.md) y [`docs/MEJORAS.md`](docs/MEJORAS.md) para entender las decisiones de refactorización y el alcance del portfolio.

La licencia del proyecto se conserva en [`LICENSE`](LICENSE).
