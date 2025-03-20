<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <title>@yield('title', 'Biblioteca')</title>
    <!-- jQuery (Debe ser lo primero) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Select JS (Versión compatible con Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
        .td-delete {
            padding: 0;
            text-align: left; 
        }

        .form-delete {
            display: inline-block;
            margin: 0 !important;
        }

        .form-delete, .form-delete button{
            padding: 0 !important;
            background: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .form-delete button i {
            font-size: 1.5rem;
            color: inherit;
        }

        /* Estilo general */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }

        .container {
            max-width: 850px !important;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #343a40;
            font-weight: bold;
        }

        hr {
            border-top: 2px solid #007bff;
        }

        /* Estilos del formulario */
        form {
            background: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form_add {
            border: 0 !important;
        }

        /* Estilos de los inputs */
        input, select {
            border-radius: 5px;
            border: 1px solid #ced4da;
            padding: 8px;
        }

        /* Tabla estilizada */
        .table {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table tbody tr:hover {
            background: #f1f1f1;
        }

        /* Botones de acciones */
        .btn-outline-danger, .btn-outline-primary {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .btn-outline-danger:hover, .btn-outline-primary:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            transform: scale(1.2);
        }

        .btn-outline-danger:hover {
            color: #dc3545 !important;
        }
        
        .btn-outline-primary:hover {
            color: #0d6efd !important;
        }

        /* Portadas de libros */
        td img {
            border-radius: 5px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .bootstrap-select .dropdown-toggle,  input {
            background-color: #fff !important; /* Fondo blanco */
            color: #212529 !important; /* Color de texto predeterminado */
            border: 1px solid #ced4da !important; /* Borde de Bootstrap */
            opacity: 1 !important; /* Asegura que no esté transparente */
        }

        /* Miscelánea */
        .bootstrap-select .dropdown-toggle:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important; /* Estilo de focus similar al input */
        }

        .enlace {
            color: black !important;
            text-decoration: none !important;
        }

        .img-thumbnail {
            padding: 0 !important;
        }

        .btn-info {
            color: white !important;
        }

        .bg-warning-dark {
            background-color: #d39e00 !important; /* Amarillo más oscuro */
            color: white !important; /* Mantiene el texto legible */
        }

        .space-bottom-table {
            margin-block-end: 1em !important;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        @yield('content')
    </div>
</body>
</html>