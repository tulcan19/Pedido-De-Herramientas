# CAPÍTULO III PROTOCOLO DE PRUEBAS

## 3.1. Plan de pruebas del sistema

El plan de pruebas del "Sistema de Control de Inventario para el Taller Mecánico del ISTPET" tiene como objetivo principal garantizar que la aplicación web cumpla con todos los requerimientos funcionales y no funcionales definidos durante su diseño. A través de este plan, se busca identificar, registrar y mitigar posibles fallos antes de la implementación final, asegurando la estabilidad, seguridad y fiabilidad del software.

**Objetivos de las pruebas:**
*   **Validación de Roles y Accesos:** Verificar que los roles de Estudiante, Docente y Coordinador restrinjan adecuadamente el acceso a los módulos correspondientes.
*   **Integridad del Flujo de Préstamos:** Validar el ciclo completo de una herramienta: solicitud (incluyendo escaneo QR), doble aprobación (docente y coordinador), entrega y devolución (con checklist de accesorios y evidencia fotográfica).
*   **Generación de Documentos:** Comprobar la correcta estructuración y descarga de los comprobantes y reportes gerenciales en formato PDF.
*   **Trazabilidad:** Asegurar que todos los cambios de estado (disponible, prestado, mantenimiento, perdido) se registren con precisión en la bitácora interactiva.

**Alcance de las Pruebas:**
Las pruebas abarcan la totalidad de la interfaz de usuario y la lógica de negocio subyacente. Se enfocan en las operaciones transaccionales críticas del taller mecánico. No se incluyen pruebas de estrés extremo (stress testing a nivel de servidor) ni auditorías avanzadas de ciberseguridad, limitándose al alcance académico y funcional del proyecto.

**Entorno de Ejecución:**
*   **Hardware:** Computadoras de escritorio (para simular el rol de Coordinador en ventanilla) y dispositivos móviles smartphone (para probar la cámara y la experiencia responsiva del estudiante/docente).
*   **Software Base:** PHP, Framework Laravel, Gestor de Base de Datos MySQL.
*   **Navegadores:** Google Chrome y Mozilla Firefox en sus versiones más recientes, asegurando la compatibilidad del motor de renderizado y JavaScript.

**Estrategia Metodológica:**
Se aplicará primordialmente la técnica de "Pruebas de Caja Negra" (Black-Box Testing). Se evaluará el sistema ingresando datos de prueba (inputs) y analizando los resultados mostrados en pantalla y base de datos (outputs), comprobando que el comportamiento real del sistema coincida con el comportamiento esperado descrito en los casos de uso.

## 3.2. Pruebas funcionales
[En esta sección se documentan los casos de prueba sobre las funcionalidades principales: inicio de sesión, reserva de herramientas, aprobación por parte del docente/coordinador, proceso de entrega y devolución de herramientas, y actualización de la bitácora interactiva.]

## 3.3. Pruebas de usabilidad
[Aquí se detalla cómo los usuarios (estudiantes, docentes y coordinadores) interactúan con la interfaz del sistema. Puedes incluir pruebas de navegación, facilidad de uso de los códigos QR, y claridad en los menús y notificaciones.]

## 3.4. Pruebas de rendimiento
[En este apartado se describe cómo se comporta el sistema bajo cierta carga, tiempos de respuesta al generar reportes en PDF, y eficiencia al buscar o filtrar herramientas en la base de datos.]

## 3.5. Resultados obtenidos
[Aquí se presentan los datos y métricas recolectados durante la ejecución de las pruebas anteriores (errores encontrados, tasas de éxito, tiempos promedio, etc.).]

## 3.6. Discusión de resultados
[Finalmente, en esta sección analizas los resultados obtenidos frente a los objetivos iniciales, destacando las mejoras implementadas durante el desarrollo y cómo el sistema resuelve el problema del taller mecánico del instituto.]
