<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Cadastro de Hóspedes')</title>

    <!-- CSS do Laravel via Vite -->
    @vite('resources/css/app.css')

    <!-- CSS do DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.semanticui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.3/css/responsive.semanticui.css">
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="container mx-auto p-4">
        @yield('content')
    </div>

    <!-- Carregamento do jQuery (deve vir antes do DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Biblioteca Inputmask -->
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.7/dist/inputmask.min.js"></script>

    <!-- Scripts do Laravel via Vite -->
    @vite('resources/js/app.js')

    <!-- Carregamento do DataTables -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.semanticui.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.tailwindcss.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.semanticui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>

    <!-- Inicialização do DataTable -->
    <script>
        $(document).ready(function() {
            $('#hospedes-table').DataTable({
                responsive: true,
                "paging": true,
                "searching": true,
                "ordering": true
            });
        });
    </script>
</body>
</html>
