# 📦 Sistema de Control de Inventario - Almacén Central

Un sistema web intuitivo y eficiente para la gestión de inventarios, desarrollado con **PHP** puro y **MySQL**. Diseñado para llevar un control preciso de la mercancía, generar reportes dinámicos y alertar sobre niveles críticos de stock.

---

## 🚀 Características Principales

* **📊 Dashboard Gerencial:** Panel de control principal con métricas en tiempo real, cálculo del capital total estimado y alertas automáticas de stock bajo (<= 15 unidades).
* **🛠️ CRUD Completo:** Sistema robusto para Crear, Leer, Actualizar y Eliminar productos del inventario de forma segura (usando sentencias preparadas).
* **🔍 Filtros Dinámicos:** Motor de búsqueda integrado para filtrar la mercancía por nombre o categoría sin recargar toda la interfaz de forma invasiva.
* **📄 Reportes en PDF:** Generación automática de reportes de inventario listos para imprimir o guardar en PDF, respetando los filtros de búsqueda aplicados y con paginación inteligente.
* **🎨 Interfaz UI/UX:** Diseño limpio, responsivo y moderno, con etiquetas de colores dinámicas según la categoría del producto.

---

## 💻 Tecnologías Utilizadas

* **Backend:** PHP 8+
* **Base de Datos:** MySQL / MariaDB (Optimizado con relaciones `LEFT JOIN` y `FOREIGN KEYS`)
* **Frontend:** HTML5, CSS3 (Diseño con Flexbox y CSS puro sin frameworks)
* **Entorno de Desarrollo:** XAMPP

---

## ⚙️ Instalación y Configuración

Si deseas probar este proyecto en tu entorno local, sigue estos pasos:

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/TuUsuarioDeGithub/Sistema_inventario.git](https://github.com/TuUsuarioDeGithub/Sistema_inventario.git)
    ```
2.  **Mover al servidor local:**
    Mueve la carpeta del proyecto al directorio público de tu servidor local (por ejemplo, la carpeta `htdocs` si usas XAMPP).
3.  **Configurar la Base de Datos:**
    * Abre phpMyAdmin (o tu gestor de DB favorito).
    * Crea una base de datos llamada `Inventario`.
    * Importa el archivo `crear_almacen.sql` (asegúrate de incluirlo en el repositorio) para generar las tablas `productos` y `categorias` con sus respectivos datos de prueba.
4.  **Conexión:**
    Si tu usuario de MySQL no es `root` o tiene contraseña, ajusta las credenciales en el archivo `conexion.php` ubicado en la raíz del proyecto.
5.  **Ejecutar:**
    Abre tu navegador y entra a `http://localhost/Sistema_inventario/index.php`.

---

## 📂 Estructura del Proyecto

```text
Sistema_inventario/
├── assets/
│   └── css/
│       └── estilos.css         # Hoja de estilos principal
├── includes/
│   ├── navbar.php              # Menú de navegación modular
│   └── footer.php              # Pie de página dinámico
├── procesos/
│   ├── guardar_producto.php    # Backend (INSERT)
│   ├── actualizar_producto.php # Backend (UPDATE)
│   └── eliminar_producto.php   # Backend (DELETE)
├── views/
│   ├── listar_inventario.php   # Tabla principal y filtros (SELECT)
│   ├── formulario_producto.php # Interfaz para registrar
│   ├── editar_producto.php     # Interfaz pre-llenada para edición
│   └── reporte_inventario.php  # Generador de plantilla para PDF
├── conexion.php                # Conector a la base de datos MySQL
└── index.php                   # Dashboard principal