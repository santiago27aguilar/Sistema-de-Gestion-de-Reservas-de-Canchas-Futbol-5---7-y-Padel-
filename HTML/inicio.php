<?php
    session_start();
    if(!isset($_SESSION['usuario_nombre'])){
        header("Location: login.php");
        exit();
    }
    include '../php/conexion.php';

    $rol_usuario = $_SESSION['usuario_rol'];
    
    $busqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
    $sql = "SELECT * FROM clientes WHERE dni LIKE :busqueda OR nombre LIKE :busqueda OR apellido LIKE :busqueda";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':busqueda' => "%$busqueda%"]);
    $resultado_clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="../css/estilos_inicio.css?v=<?php echo time(); ?>">
</head>
<body>
    <nav class="navbar">
        <a href="reservas.php">RESERVAS</a>
        <a href="canchas.php">CANCHAS</a>
        <a href="pagos.php">PAGOS</a>
        <a href="../php/cerrar_sesion.php" class="btn-salir">CERRAR SESION</a>
    </nav>

    <div class="container">  
        
        <div class="header-titulo">
            <h1>PANEL DE CLIENTES</h1>
            <img src="../img/icono-usuario.png" alt="Icono Usuario" class="icono-usuario">
        </div>
        <p class="bienvenida">Bienvenido <strong><?php echo $_SESSION['usuario_nombre']; ?></strong> (<?php echo strtoupper($_SESSION['usuario_rol']); ?>)</p>

        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'eliminado'): ?>
            <div class="alerta alerta-exito">Cliente eliminado correctamente</div>
        <?php endif; ?>
        <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'registrado'): ?>
            <div class="alerta alerta-exito">¡Cliente registrado con éxito!</div>
        <?php endif; ?>
        <?php if (isset($_GET['error']) && $_GET['error'] === 'sin_permisos'): ?>
            <div class="alerta alerta-error">No tienes permisos para realizar esta acción</div>
        <?php endif; ?>

        <div class="card-blanca">
            <h2>REGISTRAR NUEVO CLIENTE</h2>
            <form action="../php/registrar_cliente.php" method="POST">
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" placeholder="Ej: Juan" required>
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" name="apellido" placeholder="Ej: Pérez" required>
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="number" name="dni" placeholder="Sin puntos">
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" placeholder="Ej: 381...">
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" name="correo" placeholder="email@ejemplo.com">
                    </div>
                    <button type="submit" class="btn-guardar btn-full" style="align-self: end;">GUARDAR CLIENTE</button>
                </div>
            </form>
        </div>

        <div class="seccion-clientes">
            <h2>CLIENTES REGISTRADOS</h2>
            
            <div class="contenedor-busqueda-disenio">
                
                <form method="GET" action="inicio.php" class="buscador-largo">
                    <input type="text" name="buscar" placeholder="Buscar por DNI o Nombre..." value="<?php echo htmlspecialchars($busqueda); ?>">
                </form>

                <div class="fila-botones-disenio">
                    <button type="submit" form="form-real" class="btn-disenio btn-verde">BUSCAR</button>
                    <a href="inicio.php" class="link-disenio">
                        <button type="button" class="btn-disenio btn-rojo">LIMPIAR</button>
                    </a>
                    <a href="../php/exportar_excel_inicio.php" class="link-disenio"> 

                        <button type="button" class="btn-disenio btn-verde">EXCEL</button>
                    </a>
                    <a href="../php/exportar_pdf_inicio.php" class="link-disenio">
                        <button type="button" class="btn-disenio btn-rojo">PDF</button>
                    </a>
                </div>
            </div>

            <form id="form-real" method="GET" action="inicio.php" style="display:none;">
                <input type="hidden" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>">
            </form>

            <div class="table-responsive-wrapper">
                <table class="tabla-moderna">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>DNI</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Acciones</th> 
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resultado_clientes as $fila) { ?>
                            <tr>
                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['apellido']; ?></td>
                                <td><strong><?php echo $fila['dni'];?></strong></td>
                                <td><?php echo $fila['telefono'];?></td>
                                <td><?php echo $fila['correo'];?></td>
                                <td>
                                    <div class="acciones-flex">
                                        <a href="editar_cliente.php?id=<?php echo $fila['idclientes'];?>" class="btn-editar">Editar</a>
                                        <?php if (strtolower($rol_usuario) === 'admin' || strtolower($rol_usuario) === 'administrador'): ?>
                                            <a href="../php/eliminar_cliente.php?id=<?php echo $fila['idclientes'];?>" class="btn-eliminar" onclick="return confirm('¿Deseas eliminar este cliente?')">Eliminar</a>
                                        <?php else: ?>
                                            <span class="sin-permisos">Sin permisos</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>