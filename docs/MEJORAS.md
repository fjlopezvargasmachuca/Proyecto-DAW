# Cambios respecto al proyecto DAW original

La memoria original de 2023 describe la personalización de coches, su fabricación supervisada por operarios, reparaciones con seguimiento, anuncios y cuentas de cliente.

## Estructura

**Antes:** páginas PHP, controladores incompletos, JS, CSS y SQL en el directorio principal.

**Ahora:** carpetas `app/Controllers`, `app/Core`, `app/Models`, `app/Services`, `app/Views`, `config`, `public`, `database`, `docs`, `bin` y `tests`. Un punto de entrada gestiona rutas y permisos.

## Diseño y experiencia

- Identidad visual unificada, cabecera y pie reutilizables, diseño adaptable a escritorio/móvil.
- Configurador por categorías con controles accesibles, selección resaltada, resumen lateral y cálculo de precio instantáneo.
- Historial de pedidos, barra de progreso, detalle de fases, panel de operarios, historial de taller y mercado de ocasión.
- Validación nativa HTML5 y validación obligatoria del lado del servidor.

## Persistencia y seguridad

- Esquema relacional nuevo de siete áreas principales y catálogo de piezas normalizado.
- Contraseñas con hash, sentencias preparadas, escape HTML, protección CSRF y rutas con autorización por rol.
- El servidor calcula el presupuesto desde el catálogo de piezas activo; no acepta precios definidos por el navegador.
- Transacciones para alta de pedido y actualizaciones de fases.
- Configuración en `.env` excluido del control de versiones.
- Catálogo de demostración independiente del antiguo dump que contenía datos privados/inseguros.

## Operación y calidad

- Configuración reproducible mediante Docker Compose y seed de MariaDB.
- Script CLI para crear cuentas de operarios.
- Pruebas de reglas de negocio y workflow de CI para GitHub.
- README con instalación, arquitectura, pruebas, seguridad e instrucciones de GitHub.
- Se conserva la memoria y la presentación del proyecto original como documentación.

## Pendiente para una versión de producción

Recuperación segura de contraseñas por correo, tests de integración/end-to-end, accesibilidad verificada con lectores de pantalla, compatibilidad técnica entre piezas, reglas de stock, atención a clientes, cambios de estado auditables, subida validada de fotografías, medidas de prevención de abuso (WAF/rate limit por IP) y pasarela de pago real solo después de una evaluación de seguridad.
