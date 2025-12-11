<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="API ECES - Documentation Technique">
    <title>ECES API | Documentation Technique</title>

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
        /* Custom Scrollbar for a technical feel */
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

        /* Brutalist utility classes */
        .brutal-border {
            border: 1px solid #e5e7eb;
        }

        .dark .brutal-border {
            border-color: #374151;
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
                    <div
                        class="w-8 h-8 bg-black dark:bg-white text-white dark:text-black flex items-center justify-center font-bold font-mono text-sm">
                        GI
                    </div>
                    <span class="font-bold tracking-tight">ECES API</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-4 mb-2">
                    <p class="text-xs font-mono text-gray-500 uppercase tracking-wider mb-2">Menu Principal</p>
                </div>
                <a href="#" class="block px-6 py-2 text-sm font-medium active-nav">
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
                    @foreach ($projects as $index => $project)
                        <a href="#groupe-{{ $index + 1 }}"
                            class="block px-6 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white brutal-hover truncate">
                            <span class="font-mono text-xs text-gray-400 mr-2">{{ sprintf('%02d', $index + 1) }}</span>
                            {{ $project }}
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
                    <span>ECES</span>
                    <span class="text-gray-300 dark:text-gray-700">/</span>
                    <span>Génie Informatique</span>
                    <span class="text-gray-300 dark:text-gray-700">/</span>
                    <span class="text-black dark:text-white font-medium">API Rest V1.0</span>
                </div>
                <div class="flex items-center gap-4">
                    <a href="#" class="text-sm font-mono hover:underline">github.com/eces/api</a>
                    <div class="h-4 w-px bg-gray-300 dark:bg-gray-700"></div>
                    <span
                        class="text-xs bg-black text-white dark:bg-white dark:text-black px-2 py-1 font-mono">DEV</span>
                </div>
            </header>

            <div class="p-8 max-w-6xl mx-auto">

                <!-- Hero -->
                <div class="mb-12 border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a] p-8">
                    <h1 class="text-4xl font-light mb-4 tracking-tight">Interface de Programmation <br /><span
                            class="font-bold">Multi-Projets Académiques</span></h1>
                    <p class="text-gray-600 dark:text-gray-400 max-w-2xl text-lg font-light leading-relaxed mb-8">
                        Plateforme centralisée exposant 10 environnements isolés. Conçue pour le développement frontend
                        React des étudiants de Génie Informatique.
                    </p>

                    <div class="flex gap-4 font-mono text-sm">
                        <div class="border border-gray-200 dark:border-gray-800 px-4 py-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-black dark:bg-white"></span>
                            RESTful
                        </div>
                        <div class="border border-gray-200 dark:border-gray-800 px-4 py-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-black dark:bg-white"></span>
                            JSON
                        </div>
                        <div class="border border-gray-200 dark:border-gray-800 px-4 py-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-black dark:bg-white"></span>
                            Secure
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div
                    class="grid grid-cols-1 md:grid-cols-4 gap-px bg-gray-200 dark:bg-gray-800 border border-gray-200 dark:border-gray-800 mb-12">
                    <div class="bg-white dark:bg-[#0a0a0a] p-6">
                        <div class="text-xs text-gray-500 uppercase tracking-widest font-mono mb-1">Projets</div>
                        <div class="text-3xl font-bold">10</div>
                    </div>
                    <div class="bg-white dark:bg-[#0a0a0a] p-6">
                        <div class="text-xs text-gray-500 uppercase tracking-widest font-mono mb-1">Endpoints</div>
                        <div class="text-3xl font-bold">50+</div>
                    </div>
                    <div class="bg-white dark:bg-[#0a0a0a] p-6">
                        <div class="text-xs text-gray-500 uppercase tracking-widest font-mono mb-1">Status</div>
                        <div class="text-3xl font-bold text-green-600">200</div>
                    </div>
                    <div class="bg-white dark:bg-[#0a0a0a] p-6">
                        <div class="text-xs text-gray-500 uppercase tracking-widest font-mono mb-1">Version</div>
                        <div class="text-3xl font-bold">1.0.2</div>
                    </div>
                </div>

                <!-- Technical Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                    <!-- Auth -->
                    <div id="auth" class="border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                        <div
                            class="border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex justify-between items-center bg-gray-50 dark:bg-[#111]">
                            <h3 class="font-mono font-bold text-sm uppercase">Authentification</h3>
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                L'accès aux endpoints protégés nécessite un jeton Bearer. Utilisez les routes ci-dessous
                                pour obtenir vos accès.
                            </p>

                            <div class="space-y-4 font-mono text-xs">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-gray-500">Créer un compte</span>
                                        <span class="text-green-600">POST</span>
                                    </div>
                                    <div
                                        class="bg-black dark:bg-white text-white dark:text-black p-3 block w-full select-all">
                                        /api/groupe-{id}/auth/register
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-gray-500">Connexion</span>
                                        <span class="text-blue-600">POST</span>
                                    </div>
                                    <div
                                        class="bg-gray-100 dark:bg-[#111] border border-gray-200 dark:border-gray-800 p-3 block w-full select-all">
                                        /api/groupe-{id}/auth/login
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Files -->
                    <div class="border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                        <div
                            class="border-b border-gray-200 dark:border-gray-800 px-6 py-4 flex justify-between items-center bg-gray-50 dark:bg-[#111]">
                            <h3 class="font-mono font-bold text-sm uppercase">Système de Fichiers</h3>
                            <i class="fas fa-hdd text-gray-400"></i>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                Service global de stockage d'assets. Les fichiers sont validés et stockés publiquement.
                            </p>

                            <div class="space-y-4 font-mono text-xs">
                                <div class="flex items-center gap-4">
                                    <span class="w-12 text-yellow-600 font-bold">POST</span>
                                    <span class="text-gray-600 dark:text-gray-400">/api/upload/image</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="w-12 text-blue-600 font-bold">GET</span>
                                    <span class="text-gray-600 dark:text-gray-400">/api/upload/files</span>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="w-12 text-red-600 font-bold">DEL</span>
                                    <span class="text-gray-600 dark:text-gray-400">/api/upload/file/{uuid}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects List -->
                <div class="mb-8 flex items-end justify-between">
                    <h2 class="text-2xl font-light">Index des Projets</h2>
                    <span class="font-mono text-xs text-gray-500">10 ENTRÉES</span>
                </div>

                <div class="border border-gray-200 dark:border-gray-800 bg-white dark:bg-[#0a0a0a]">
                    <div
                        class="grid grid-cols-12 gap-0 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-[#111] text-xs font-mono uppercase text-gray-500 py-3 px-4">
                        <div class="col-span-1">ID</div>
                        <div class="col-span-4">Nom du Projet</div>
                        <div class="col-span-5">Description</div>
                        <div class="col-span-2 text-right">Route</div>
                    </div>

                    @php
                        $projectsDetails = [
                            [
                                'id' => '01',
                                'name' => 'E-commerce',
                                'desc' => 'Plateforme de vente avec panier et commandes',
                            ],
                            [
                                'id' => '02',
                                'name' => 'Gestion Scolaire',
                                'desc' => 'Suivi des notes, matières et étudiants',
                            ],
                            [
                                'id' => '03',
                                'name' => 'Réservation Salles',
                                'desc' => 'Calendrier de réservation de ressources',
                            ],
                            [
                                'id' => '04',
                                'name' => 'Réseau Social',
                                'desc' => 'Feed d\'actualité, posts et commentaires',
                            ],
                            [
                                'id' => '05',
                                'name' => 'Gestion Tâches',
                                'desc' => 'Tableau Kanban et assignation de tâches',
                            ],
                            ['id' => '06', 'name' => 'E-Learning', 'desc' => 'Catalogue de cours et progression'],
                            ['id' => '07', 'name' => 'Budget Perso', 'desc' => 'Suivi des dépenses et graphiques'],
                            [
                                'id' => '08',
                                'name' => 'Avis Restaurants',
                                'desc' => 'Notation et commentaires d\'établissements',
                            ],
                            [
                                'id' => '09',
                                'name' => 'Événementiel',
                                'desc' => 'Billetterie et gestion de participants',
                            ],
                            ['id' => '10', 'name' => 'Portail RH', 'desc' => 'Annuaire employés et congés'],
                        ];
                    @endphp

                    @foreach ($projectsDetails as $p)
                        <div
                            class="grid grid-cols-12 gap-0 py-4 px-4 border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-[#111] transition-colors group">
                            <div class="col-span-1 font-mono text-sm text-gray-400">{{ $p['id'] }}</div>
                            <div class="col-span-4 font-medium">{{ $p['name'] }}</div>
                            <div class="col-span-5 text-sm text-gray-500">{{ $p['desc'] }}</div>
                            <div class="col-span-2 text-right">
                                <code
                                    class="text-xs bg-gray-100 dark:bg-gray-800 px-2 py-1 group-hover:bg-black group-hover:text-white dark:group-hover:bg-white dark:group-hover:text-black transition-colors">/api/g-{{ intval($p['id']) }}</code>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div
                    class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-800 flex justify-between items-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} ECES API Ecosystem. All rights reserved.</p>
                    <p class="font-mono">SERVER_TIME: {{ now()->format('H:i:s UTC') }}</p>
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
    </script>
</body>

</html>
