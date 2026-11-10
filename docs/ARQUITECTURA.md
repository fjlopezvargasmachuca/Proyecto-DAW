# Arquitectura de EligeCoche

## Flujo de una petición

1. Apache sirve solo el directorio `public/` y reescribe las URL hacia `public/index.php` (o `router.php` al usar `php -S`).
2. `config/bootstrap.php` carga la configuración de entorno, registra el autoload PSR-4 sencillo e inicia la sesión segura.
3. `public/index.php` aplica cabeceras, comprueba el token CSRF de peticiones POST y resuelve la ruta.
4. El controlador valida los parámetros y comprueba la autorización. Los modelos consultan MariaDB mediante PDO. El servicio `CarConfigurator` valida el catálogo y calcula el total.
5. Una vista recibe solo los datos pertinentes, escapa contenido con `e()` y se renderiza dentro del layout compartido.

## Entidades

- `users`: clientes y operarios con contraseñas hasheadas.
- `parts`: catálogo único de piezas, agrupado por `category`.
- `orders`: un encargo por cliente, precio total, estado y operario asignado (si existe).
- `order_items`: instantánea de nombre/categoría/precio de cada pieza elegida; se conserva el histórico aunque cambie el catálogo.
- `order_steps`: las siete fases de fabricación, con fecha de finalización opcional.
- `repair_requests`: solicitudes y sus estados de taller.
- `listings`: anuncios de mercado, activos o retirados.
- `contact_messages`: mensajes enviados desde el formulario.

## Estados de negocio

**Fabricación:** `pending` → `in_progress` → `completed` (determinado por las siete fases marcadas). Un operario puede corregir una fase si se marcó por error.

**Taller:** `received` → `in_transit` → `in_workshop` → `ready` → `delivered`. Cada acción avanza una única etapa.

## Rutas principales

| Método y ruta | Uso | Acceso |
| --- | --- | --- |
| GET `/`, `/proyecto`, `/catalogo`, `/ranking` | Contenido general | Público |
| GET/POST `/acceder`, `/registro` | Autenticación | Anónimo |
| POST `/salir` | Cierre de sesión | Autenticado |
| GET/POST `/configurador` | Elegir piezas y crear pedido | GET público; POST cliente |
| GET `/pedidos` y `/pedidos/{id}` | Historial y detalle | Cliente propietario / operario (detalle) |
| GET/POST `/taller` | Consulta y solicitud | GET público; POST cliente |
| GET/POST `/mercado` | Consulta y publicaciones | GET público; POST cliente |
| POST `/mercado/{id}/retirar` | Retirar anuncio | Solo propietario |
| GET `/operarios` | Panel interno | Operario |
| POST `/operarios/pedidos/{id}` | Fases de producción | Operario |
| POST `/operarios/taller/{id}` | Siguiente fase del taller | Operario |
| GET/POST `/contacto` | Formulario | Público |

## Limitaciones conscientes

La aplicación demuestra arquitectura y experiencia de usuario, no un sistema comercial. No hay pagos, email transaccional, recuperación de contraseña ni inventario de piezas en tiempo real. No se migran cuentas ni registros del dump original por riesgos de datos personales y contraseñas planas. Las validaciones de compatibilidad mecánica entre piezas pueden añadirse como ampliación del dominio.
