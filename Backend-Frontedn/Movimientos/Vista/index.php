<?php
// index.php dentro de Movimientos/Vista
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Movimientos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="container py-4 bg-dark text-white">
    <h1 class="mb-4 text-center"></i> Movimientos</h1>

    <?php if (!empty($mensaje)): ?>
        <div class="alert alert-info text-center"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <!-- Botones -->
    <div class="text-center mb-4">
        <a href="../Controlador/MovimientosController.php?accion=ver_todos" id="btnVer" class="btn btn-primary">Ver Movimientos</a>
        <button id="btnOcultar" class="btn btn-secondary d-none">Ocultar Movimientos</button>
    </div>

    <!-- Tabla de movimientos -->
    <div id="tablaMovimientos" class="<?= !empty($movimientos) ? '' : 'd-none' ?>">
        <?php if (!empty($movimientos)): ?>
            <table class="table table-bordered table-striped table-dark">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Usuario Responsable</th>
                        <th>Acción</th>
                        <th>ID Producto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $m): ?>
                        <tr>
                            <td><?= htmlspecialchars($m->id_movimiento ?? '') ?></td>
                            <td><?= htmlspecialchars($m->tipo ?? '') ?></td>
                            <td><?= htmlspecialchars($m->descripcion ?? '') ?></td>
                            <td><?= htmlspecialchars($m->cantidad ?? '') ?></td>
                            <td><?= htmlspecialchars($m->fecha ?? '') ?></td>
                            <td><?= htmlspecialchars($m->usuario_responsable ?? '') ?></td>
                            <td><?= htmlspecialchars($m->accion ?? '') ?></td>
                            <td><?= htmlspecialchars($m->id_producto ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info text-center">No hay movimientos disponibles.</div>
        <?php endif; ?>
    </div>

    <!-- Formularios CRUD -->
    <div class="row mt-5">
        <!-- Agregar Movimiento -->
        <div class="col-md-4">
            <h4>Agregar Movimiento</h4>
            <form method="post" action="../Controlador/MovimientosController.php?accion=agregar" class="p-3 border rounded bg-dark text-white">
                <div class="mb-2"><input type="text" name="tipo" class="form-control" placeholder="Tipo"></div>
                <div class="mb-2"><input type="text" name="descripcion" class="form-control" placeholder="Descripción"></div>
                <div class="mb-2"><input type="number" name="cantidad" class="form-control" placeholder="Cantidad"></div>
                <div class="mb-2"><input type="date" name="fecha" class="form-control"></div>
                <div class="mb-2"><input type="text" name="usuario_responsable" class="form-control" placeholder="Usuario Responsable"></div>
                <div class="mb-2"><input type="text" name="accion_movimiento" class="form-control" placeholder="Acción"></div>
                <div class="mb-2"><input type="text" name="id_producto" class="form-control" placeholder="ID Producto"></div>
                <button type="submit" class="btn btn-success w-100">Agregar</button>
            </form>
        </div>

        <!-- Actualizar Movimiento -->
        <div class="col-md-4">
            <h4>Actualizar Movimiento</h4>
            <form method="post" action="../Controlador/MovimientosController.php?accion=actualizar" class="p-3 border rounded bg-dark text-white">
                <div class="mb-2"><input type="number" name="movimiento_id" class="form-control" placeholder="ID Movimiento"></div>
                <div class="mb-2"><input type="text" name="tipo" class="form-control" placeholder="Tipo"></div>
                <div class="mb-2"><input type="text" name="descripcion" class="form-control" placeholder="Descripción"></div>
                <div class="mb-2"><input type="number" name="cantidad" class="form-control" placeholder="Cantidad"></div>
                <div class="mb-2"><input type="date" name="fecha" class="form-control"></div>
                <div class="mb-2"><input type="text" name="usuario_responsable" class="form-control" placeholder="Usuario Responsable"></div>
                <div class="mb-2"><input type="text" name="accion_movimiento" class="form-control" placeholder="Acción"></div>
                <div class="mb-2"><input type="text" name="id_producto" class="form-control" placeholder="ID Producto"></div>
                <button type="submit" class="btn btn-warning w-100">Actualizar</button>
            </form>
        </div>

        <!-- Eliminar Movimiento -->
        <div class="col-md-4 ">
            <h4>Eliminar Movimiento</h4>
            <form method="post" action="../Controlador/MovimientosController.php?accion=eliminar" class="p-3 border rounded bg-dark text-white">
                <div class="mb-2"><input type="number" name="movimiento_id" class="form-control" placeholder="ID Movimiento"></div>
                <button type="submit" class="btn btn-danger w-100">Eliminar</button>
            </form>
        </div>
    </div>

    <script>
        const btnVer = document.getElementById("btnVer");
        const btnOcultar = document.getElementById("btnOcultar");
        const tabla = document.getElementById("tablaMovimientos");

        btnOcultar.addEventListener("click", () => {
            tabla.classList.add("d-none");
            btnVer.classList.remove("d-none");
            btnOcultar.classList.add("d-none");
        });

        if (!tabla.classList.contains("d-none")) {
            btnVer.classList.add("d-none");
            btnOcultar.classList.remove("d-none");
        }
    </script>

</body>
</html>

