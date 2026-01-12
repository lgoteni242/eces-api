<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="API ECES - {{ $project['fullName'] }}">
    <title>ECES API | {{ $project['name'] }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        mono: ['JetBrains Mono', 'Menlo', 'Monaco', 'Courier New', 'monospace'],
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                    colors: {
                        gray: {
                            50: '#F9FAFB',
                            100: '#F3F4F6',
                            200: '#E5E7EB',
                            300: '#D1D5DB',
                            400: '#9CA3AF',
                            500: '#6B7280',
                            600: '#4B5563',
                            700: '#374151',
                            800: '#1F2937',
                            900: '#111827',
                            950: '#030712',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e5e7eb;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #374151;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .brutal-hover:hover {
            background-color: #f3f4f6;
        }

        .dark .brutal-hover:hover {
            background-color: #1f2937;
        }

        .active-nav {
            background-color: #f3f4f6;
            border-right: 2px solid #000;
        }

        .dark .active-nav {
            background-color: #1f2937;
            border-right: 2px solid #fff;
        }

        .method-badge {
            display: inline-block;
            min-width: 60px;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 8px;
        }

        .method-get {
            background-color: #3b82f6;
            color: white;
        }

        .method-post {
            background-color: #10b981;
            color: white;
        }

        .method-put {
            background-color: #f59e0b;
            color: white;
        }

        .method-delete {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>

<body
    class="h-full bg-white dark:bg-[#0a0a0a] text-gray-900 dark:text-gray-100 font-sans selection:bg-black selection:text-white dark:selection:bg-white dark:selection:text-black">

    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside
            class="w-64 flex-shrink-0 border-r border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a] flex flex-col z-20">
            <!-- Logo Area -->
            <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <a href="/" class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold font-mono text-sm">
                            GI
                        </div>
                        <span class="font-bold tracking-tight">ECES API {{  date('Y') }}</span>
                    </a>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 mb-2">
                    <p class="text-xs font-mono text-gray-500 uppercase tracking-wider mb-2">Menu Principal</p>
                </div>
                <a href="/"
                    class="block px-6 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white brutal-hover">
                    <i class="fas fa-home w-5 text-gray-400"></i> Vue d'ensemble
                </a>
                <a href="#documentation"
                    class="block px-6 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white brutal-hover">
                    <i class="fas fa-book w-5 text-gray-400"></i> Documentation
                </a>
                <a href="#auth"
                    class="block px-6 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white brutal-hover">
                    <i class="fas fa-key w-5 text-gray-400"></i> Authentification
                </a>

                <div class="px-4 mt-8 mb-2">
                    <p class="text-xs font-mono text-gray-500 uppercase tracking-wider mb-2">Projets Étudiants</p>
                </div>
                <div class="space-y-0.5">
                    @php
                        $projects = [
                            'Groupe 1 - E-commerce',
                            'Groupe 2 - Scolaire',
                            'Groupe 3 - Réservation',
                            'Groupe 4 - Social',
                            'Groupe 5 - Tâches',
                            'Groupe 6 - Learning',
                            'Groupe 7 - Budget',
                            'Groupe 8 - Avis',
                            'Groupe 9 - Event',
                            'Groupe 10 - RH',
                        ];
                    @endphp
                    @foreach ($projects as $index => $projectName)
                        <a href="/projet/{{ $index + 1 }}"
                            class="block px-6 py-2 text-sm {{ $project['id'] == $index + 1 ? 'active-nav text-black dark:text-white' : 'text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white brutal-hover' }} truncate">
                            <span class="font-mono text-xs text-gray-400 mr-2">{{ sprintf('%02d', $index + 1) }}</span>
                            {{ $projectName }}
                        </a>
                    @endforeach
                </div>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-6 border-t border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-[#111]">
                <p class="text-xs font-mono text-gray-500 uppercase tracking-wider mb-2">Enseignant Responsable</p>
                <div class="font-bold text-sm tracking-tight border-l-2 border-black dark:border-white pl-3 py-1">
                    GOTENI AMBOULOU<br>LEVI CHRIST
                </div>
            </div>

            <div class="p-4 border-t border-gray-200 dark:border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">État du système</p>
                        <p class="text-xs text-green-600 dark:text-green-400 flex items-center gap-1 mt-0.5">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-none"></span> Opérationnel
                        </p>
                    </div>
                    <button id="themeToggle"
                        class="p-2 text-gray-500 hover:text-black dark:hover:text-white transition-colors">
                        <i class="fas fa-adjust"></i>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-[#0f0f0f]">
            <!-- Top Bar -->
            <header
                class="h-16 bg-white dark:bg-[#0a0a0a] border-b border-gray-200 dark:border-gray-800 flex items-center justify-between px-8 sticky top-0 z-10">
                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <a href="/" class="hover:text-black dark:hover:text-white">ECES</a>
                    <span class="text-gray-300 dark:text-gray-700">/</span>
                    <a href="/" class="hover:text-black dark:hover:text-white">Génie Informatique</a>
                    <span class="text-gray-300 dark:text-gray-700">/</span>
                    <span class="text-black dark:text-white font-medium">{{ $project['name'] }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="https://github.com/lgoteni242/eces-api" class="text-sm font-mono hover:underline">github.com/eces/api</a>
                    <div class="h-4 w-px bg-gray-300 dark:bg-gray-700"></div>
                    <span
                        class="text-xs bg-black text-white dark:bg-white dark:text-black px-2 py-1 font-mono">DEV</span>
                </div>
            </header>

            <div class="p-8 max-w-6xl mx-auto">

                <!-- Project Header -->
                <div class="mb-12 border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a] p-8">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-4">
                                <span class="font-mono text-sm text-gray-500">GROUPE
                                    {{ sprintf('%02d', $project['id']) }}</span>
                                <div class="h-4 w-px bg-gray-300 dark:bg-gray-700"></div>
                                <span class="text-sm text-gray-500">{{ $project['name'] }}</span>
                            </div>
                            <h1 class="text-4xl font-light mb-4 tracking-tight">{{ $project['fullName'] }}</h1>
                        </div>
                        <div class="text-right">
                            <div class="font-mono text-xs text-gray-500 mb-1">Base URL</div>
                            <code class="text-sm bg-black dark:bg-white text-white dark:text-black px-3 py-2 block">
                                /api/groupe-{{ $project['id'] }}
                            </code>
                        </div>
                    </div>

                    <p class="text-gray-600 dark:text-gray-400 max-w-3xl text-lg font-light leading-relaxed mb-8">
                        {{ $project['description'] }}
                    </p>

                    <div class="flex flex-wrap gap-2">
                        @foreach ($project['tech'] as $tech)
                            <div class="border border-gray-200 dark:border-gray-800 px-3 py-1.5 text-xs font-mono">
                                {{ $tech }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Features Section -->
                <div class="mb-12 border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                    <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4 bg-gray-50 dark:bg-[#111]">
                        <h2 class="font-mono font-bold text-sm uppercase">Fonctionnalités Principales</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($project['features'] as $feature)
                                <div class="flex items-start gap-3">
                                    <span class="text-gray-400 mt-0.5">•</span>
                                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Endpoints Section -->
                <div class="mb-12 border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                    <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4 bg-gray-50 dark:bg-[#111]">
                        <h2 class="font-mono font-bold text-sm uppercase">Endpoints Disponibles</h2>
                    </div>
                    <div class="divide-y divide-gray-200 dark:divide-gray-800">
                        @foreach ($project['endpoints'] as $endpoint)
                            <div class="p-6 hover:bg-gray-50 dark:hover:bg-[#111] transition-colors">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <div class="flex items-center gap-3 flex-1 min-w-0">
                                        <span
                                            class="method-badge method-{{ strtolower($endpoint['method']) }}">{{ $endpoint['method'] }}</span>
                                        <code
                                            class="text-sm font-mono bg-gray-100 dark:bg-[#111] px-3 py-1.5 flex-1 truncate">{{ $endpoint['path'] }}</code>
                                    </div>
                                    <button onclick="copyToClipboard('{{ $endpoint['path'] }}')"
                                        class="text-gray-400 hover:text-black dark:hover:text-white p-1">
                                        <i class="fas fa-copy text-xs"></i>
                                    </button>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400 ml-20">{{ $endpoint['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Quick Start -->
                <div class="mb-12 border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                    <div class="border-b border-gray-200 dark:border-gray-800 px-6 py-4 bg-gray-50 dark:bg-[#111]">
                        <h2 class="font-mono font-bold text-sm uppercase">Démarrage Rapide</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                <strong class="text-black dark:text-white">1. Authentification</strong><br>
                                Commencez par créer un compte ou vous connecter pour obtenir votre token d'accès.
                            </p>
                            <div class="bg-black dark:bg-white text-white dark:text-black p-4 font-mono text-xs">
                                POST /api/groupe-{{ $project['id'] }}/auth/register<br>
                                POST /api/groupe-{{ $project['id'] }}/auth/login
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                <strong class="text-black dark:text-white">2. Utilisation</strong><br>
                                Utilisez le token Bearer dans l'en-tête Authorization de vos requêtes.
                            </p>
                            <div
                                class="bg-gray-100 dark:bg-[#111] border border-gray-200 dark:border-gray-800 p-4 font-mono text-xs">
                                Authorization: Bearer {your_token}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Footer -->
                <div class="flex justify-between items-center pt-8 border-t border-gray-200 dark:border-gray-800">
                    @if ($project['id'] > 1)
                        <a href="/projet/{{ $project['id'] - 1 }}"
                            class="text-sm font-mono text-gray-500 hover:text-black dark:hover:text-white">
                            ← Projet précédent
                        </a>
                    @else
                        <div></div>
                    @endif

                    <a href="/" class="text-sm font-mono text-gray-500 hover:text-black dark:hover:text-white">
                        Retour à l'index
                    </a>

                    @if ($project['id'] < 10)
                        <a href="/projet/{{ $project['id'] + 1 }}"
                            class="text-sm font-mono text-gray-500 hover:text-black dark:hover:text-white">
                            Projet suivant →
                        </a>
                    @else
                        <div></div>
                    @endif
                </div>

                <div
                    class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} ECES API Ecosystem. All rights reserved.</p>
                    <p class="font-mono">PROJECT_ID: {{ sprintf('%02d', $project['id']) }}</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle Dark Mode
        const themeToggle = document.getElementById('themeToggle');

        // Initial Theme Check
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });

        // Copy to Clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Visual feedback could be added here
                console.log('Copied:', text);
            });
        }
    </script>
</body>

</html>
