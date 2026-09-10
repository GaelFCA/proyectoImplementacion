<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipo de Desarrollo</title>
    <!-- Importando Tailwind CSS para dar estilos modernos rápidamente sin configurar nada -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Importando Figtree, la misma fuente tipográfica que usa Laravel -->
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased min-h-screen flex items-center justify-center">

    <div class="max-w-3xl w-full mx-auto p-6">
        <!-- Tarjeta Principal -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            
            <!-- Encabezado (Rojo Laravel) -->
            <div class="bg-[#FF2D20] px-8 py-10 text-center">
                <h1 class="text-3xl font-bold text-white tracking-wide">
                    Proyecto Laravel
                </h1>
                <p class="text-red-100 mt-2 text-lg">Equipo de Desarrollo</p>
            </div>

            <!-- Lista de Integrantes -->
            <div class="p-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-2">Integrantes del Proyecto</h2>
                
                <ul class="space-y-4">
                    <!-- Integrante 1 -->
                    <li class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-full bg-[#FF2D20] flex items-center justify-center text-white font-bold text-xl mr-4">
                            L
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">Lechuga Arellano Leonardo Gael</p>
                            <p class="text-sm text-gray-500">Informática</p>
                        </div>
                    </li>

                    <!-- Integrante 2 -->
                    <li class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-full bg-gray-800 flex items-center justify-center text-white font-bold text-xl mr-4">
                            S
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">Galicia Romahn Santiago</p>
                            <p class="text-sm text-gray-500">Informática</p>
                        </div>
                    </li>

                    <!-- Integrante 3 -->
                    <li class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="h-12 w-12 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold text-xl mr-4">
                            G
                        </div>
                        <div>
                            <p class="text-lg font-bold text-gray-900">Pacheco Galvez Gabriela</p>
                            <p class="text-sm text-gray-500">Informática</p>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Pie de página -->
            <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-200 text-sm text-gray-400">
                Laravel v11.x
            </div>
        </div>
    </div>

</body>
</html>