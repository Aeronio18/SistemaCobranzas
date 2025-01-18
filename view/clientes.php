<?php
$pageTitle = "Gestión de Clientes";
$content = '
<div class="row g-4">
    <!-- Tarjeta para registrar nuevo cliente -->
    <div class="col-md-12">
        <div class="card text-bg-success">
            <div class="card-body text-center">
                <h5 class="card-title">Registrar Nuevo Cliente</h5>
                <p class="card-text">Agrega un nuevo cliente al sistema.</p>
                <a href="#" class="btn btn-light btn-sm">Registrar Cliente</a>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de clientes -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Lista de Clientes</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Contacto Adicional</th>
                            <th>Crédito Actual</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Juan Pérez</td>
                            <td>Calle Falsa 123</td>
                            <td>555-123-456</td>
                            <td>555-654-321</td>
                            <td>$1,000</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                        <tr>
                            <td>María López</td>
                            <td>Avenida Siempreviva 742</td>
                            <td>555-987-654</td>
                            <td>555-321-987</td>
                            <td>$500</td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Editar</a>
                                <a href="#" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>';

include '../templates/dashboard_layout.php';
?>
