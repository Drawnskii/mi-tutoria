<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-7xl max-w-none text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-between gap-4">
                <!-- Logo a la izquierda -->
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" alt="MiTU Logo" class="w-16 h-12" />
                    <span class="font-semibold text-lg">MiTU</span>
                </div>

                <!-- Enlaces a la derecha -->
                <div class="flex items-center gap-4">
                    @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                    @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>

                    @if (Route::has('register'))
                        <a
                        href="{{ route('register') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                        Register
                        </a>
                    @endif
                    @endauth
                </div>
                </nav>
            @endif
        </header>

        <div class="flex flex-col items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <div class="w-full max-w-none mx-auto text-center px-14 py-8">
                <h1 class="text-8xl font-extrabold">
                    Mi<span class="font-black">TU</span>
                </h1>
                <p class="text-4xl text-gray-600 dark:text-gray-400 mt-1">Mi Tutor Universitario</p>

                <div class="border border-gray-300 rounded-lg mt-6 w-full max-w-none h-[70vh] flex items-center justify-center overflow-hidden bg-gray-50 dark:bg-gray-800">
                    <img src="{{ asset('img/clases.png') }}" alt="Imagen representativa" class="object-cover w-full h-full" />
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-36 max-w-none mx-auto px-14 py-8 w-full">
                <!-- Texto Acerca de -->
                <div class="lg:w-1/2 text-justify text-xl">
                    <h2 class="text-6xl font-semibold mb-4 text-center">Acerca de</h2>
                    <p class="mb-4">
                    En MiTU, facilitamos la conexión entre estudiantes y tutores universitarios para brindar un apoyo académico personalizado. Nuestra plataforma promueve un ambiente colaborativo donde el aprendizaje se adapta a las necesidades individuales de cada alumno. Trabajamos para que la educación sea accesible, efectiva y motivadora, ayudando a mejorar el rendimiento y la confianza de los estudiantes en sus estudios. Con herramientas prácticas y comunicación directa, buscamos fortalecer el proceso educativo. Creemos que una tutoría de calidad es clave para el éxito académico y personal.
                    </p>
                    <p>
                    Nuestra misión es acompañar a la comunidad universitaria en cada etapa de su formación, promoviendo el crecimiento integral. Estamos comprometidos con crear un espacio donde todos puedan alcanzar su máximo potencial con el soporte adecuado. La innovación y la colaboración son el corazón de nuestra plataforma.
                    </p>
                </div>

                <!-- Imagen a la derecha -->
                <div class="lg:w-1/2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 h-96 flex items-center justify-center overflow-hidden mt-5">
                    <img src="{{ asset('img/profe.jpg') }}" alt="Imagen Acerca de" class="object-cover w-full h-full" />
                </div>
            </div>

            <div class="max-w-none mx-auto px-20 py-8 text-center">
                <h2 class="text-6xl font-semibold mb-10">¿Qué ofrece?</h2>
                
                <div class="flex flex-col md:flex-row justify-center gap-36 ">
                    <!-- Como estudiante -->
                    <div class="md:w-1/2 my-7">
                    <h3 class="text-2xl font-semibold mb-4 text-center">Como estudiante</h3>
                    <div class="border border-gray-300 rounded p-4 max-w-xs h-40 mx-auto mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Ícono estudiante" class="mt-2 mx-auto w-28 h-28" />
                    </div>
                    <p class="text-xl  leading-tight max-w-none mx-auto text-center">
                        En MiTU, los estudiantes pueden acceder a tutorías personalizadas para fortalecer sus conocimientos y resolver dudas en tiempo real. La plataforma facilita la gestión de solicitudes y el seguimiento del progreso académico, asegurando un apoyo constante. Además, los estudiantes pueden conectarse con tutores expertos en distintas áreas para recibir orientación y mejorar su desempeño.
                    </p>
                    </div>
                    
                    <!-- Como tutor -->
                    <div class="md:w-1/2 my-7">
                    <h3 class="text-2xl font-semibold mb-4 text-center">Como tutor</h3>
                    <div class="border border-gray-300 rounded p-4 max-w-xs h-40 mx-auto mb-4">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135716.png" alt="Ícono tutor" class="mt-2 mx-auto w-28 h-28" />
                    </div>
                    <p class="text-xl  leading-tight max-w-none mx-auto text-center">
                        MiTU permite a los tutores gestionar sus horarios, aceptar solicitudes y brindar retroalimentación personalizada a los estudiantes. Los tutores pueden crear planes de estudio adaptados a las necesidades individuales de cada alumno, fomentando un ambiente colaborativo y de confianza. La plataforma también facilita la comunicación directa y el seguimiento del avance académico, optimizando el proceso de enseñanza.
                    </p>
                    </div>
                </div>
            </div>

             <div class="bg-gray-400 py-12 flex justify-center w-full py-56">
                <!-- Botón Empieza Ahora! -->
                <a href="{{ route('login') }}" class="px-14 py-7 bg-blue-600 text-white font-bold rounded shadow hover:bg-blue-700 transition">
                    ¡Empieza Ahora!
                </a>
            </div>
        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>

    <footer class="max-w-none mx-auto px-6 py-8 border-t border-gray-300 dark:border-gray-700 text-xl text-gray-700 dark:text-gray-300">
        <div class="flex flex-col md:flex-row md:justify-between gap-96">
            <!-- Logo e Iconos redes sociales -->
            <div class="flex flex-col md:w-1/3 mx-10">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('img/logo.png') }}" alt="MiTU Logo" class="w-16 h-12" />
                <span class="font-semibold text-lg">MiTU</span>
            </div>
            <span class="font-semibold mb-3 ">Encuentranos</span>
            <div class="flex gap-4 mb-4 ">
                <a href="#" aria-label="Facebook" class="w-6 h-6 block">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" />
                </a>
                <a href="#" aria-label="Instagram" class="w-6 h-6 block">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram" />
                </a>
                <a href="#" aria-label="GitHub" class="w-6 h-6 block">
                <img src="https://cdn-icons-png.flaticon.com/512/733/733609.png" alt="GitHub" />
                </a>
            </div>
            <p> Sitio creado por: </p>
            <p class="text-blue-600">
                <a href="mailto:fernandobeltran@correo.com">fernandobeltran@correo.com</a><br />
                <a href="mailto:eddyaguagallo@correo.com">eddyaguagallo@correo.com</a><br />
                <a href="mailto:stalynrgerman@correo.com">stalynrgerman@correo.com</a>
            </p>
            </div>

            <!-- Institución -->
            <div class="md:w-1/3 mx-10">
            <h3 class="font-semibold mb-3 mt-20">Institución</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-blue-600 hover:underline">Acerca de</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">¿Qué ofrece?</a></li>
            </ul>
            </div>

            <!-- Más Enlaces -->
            <div class="md:w-1/3 mx-10">
            <h3 class="font-semibold mb-3 mt-20">Más Enlaces</h3>
            <ul class="space-y-2">
                <li><a href="#" class="text-blue-600 hover:underline">MiESPE</a></li>
                <li><a href="#" class="text-blue-600 hover:underline">MiCampus</a></li>
            </ul>
            </div>
        </div>

        <div class="text-center text-xs mt-8">
            © 2025 MiTutoría. Todos los derechos reservados.
        </div>
    </footer>

</html> 