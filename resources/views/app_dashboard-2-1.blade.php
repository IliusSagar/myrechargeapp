<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Flexiload UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-blue-50">

    <main class="max-w-md mx-auto min-h-screen bg-white shadow-2xl flex flex-col">
        
        <header class="bg-blue-600 p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-3">
                <div class="bg-gray-300 rounded-full h-10 w-10 flex items-center justify-center">
                    <i class="fas fa-user text-gray-700 text-xl"></i>
                </div>
                <h1 class="text-xl font-bold tracking-tight">Digital Flexiload</h1>
            </div>
            <div class="h-8 w-8 bg-white rounded-lg p-1">
                <div class="w-full h-full bg-blue-400 rounded-sm"></div>
            </div>
        </header>

        <div class="px-4 py-6 flex-1 space-y-6">

            <section class="border-2 border-gray-100 rounded-3xl p-5 shadow-sm">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <p class="text-indigo-900 font-bold text-lg">My account</p>
                        <p class="text-blue-400 font-medium">{{ Auth::user()->name ?? 'Ronyl' }}</p>
                    </div>
                    <button class="flex items-center gap-2 border-2 border-blue-600 rounded-full px-4 py-1 text-indigo-900 font-bold text-sm">
                        <span class="bg-blue-400 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]">৳</span>
                        My Balance
                    </button>
                    <div class="text-right">
                        <p class="text-gray-400 font-bold text-sm">My Level</p>
                        <p class="text-orange-400 font-bold">Retailer</p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-2 text-center">
                    <div class="group cursor-pointer">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-blue-600">
                             <i class="fas fa-file-invoice-dollar text-3xl"></i>
                        </div>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2">Add Balance</p>
                    </div>
                    <div class="group cursor-pointer">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-blue-600">
                             <i class="fas fa-paper-plane text-3xl"></i>
                        </div>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2">Send Money</p>
                    </div>
                    <div class="group cursor-pointer">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-blue-600">
                             <i class="fas fa-user-plus text-3xl"></i>
                        </div>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2">Add User</p>
                    </div>
                    <div class="group cursor-pointer">
                        <div class="mx-auto w-12 h-12 flex items-center justify-center text-blue-600">
                             <i class="fas fa-users text-3xl"></i>
                        </div>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2">My users</p>
                    </div>
                </div>
            </section>

            <section class="border-2 border-gray-100 rounded-3xl p-5 shadow-sm relative">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-indigo-900 font-bold text-lg">Recharge & Bill Payments</h2>
                    <a href="#" class="text-blue-600 font-bold text-lg flex items-center gap-1">
                        History <i class="fas fa-chevron-right text-sm"></i>
                    </a>
                </div>

                <div class="grid grid-cols-4 gap-y-10 gap-x-2 text-center">
                    <div class="cursor-pointer">
                        <i class="fas fa-university text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">B banking</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-clock-rotate-left text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">History</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-layer-group text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">Regular pack</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-mobile-screen text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">Flexiload</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-database text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">Drive pack</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-lightbulb text-3xl text-blue-500"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight">Pay Bill</p>
                    </div>
                    <div class="cursor-pointer">
                        <i class="fas fa-paper-plane text-3xl text-blue-500 -rotate-12"></i>
                        <p class="text-[11px] font-bold text-indigo-900 mt-2 leading-tight uppercase">Rocket</p>
                    </div>
                </div>
            </section>

            <section class="rounded-2xl overflow-hidden shadow-lg bg-gradient-to-r from-purple-600 to-blue-500 p-4 text-white relative h-32 flex items-center">
                <div class="z-10 w-2/3">
                    <h3 class="font-black text-xl leading-none">WELCOME</h3>
                    <p class="text-xs font-bold opacity-80 mt-1 uppercase tracking-wider">To Digital Flexiload 2.0</p>
                    <p class="text-[10px] mt-2 font-medium">১০০% অটোমেটিক ডিজিটাল রিচার্জ সিস্টেম</p>
                </div>
                <div class="absolute right-4 top-2 h-28 w-16 bg-white rounded-lg border-2 border-gray-800 p-1 shadow-2xl">
                    <div class="w-full h-full bg-gray-100 rounded-sm grid grid-cols-3 gap-1 p-1">
                        <div class="bg-blue-200 h-2 w-full rounded-full"></div>
                        <div class="bg-blue-200 h-2 w-full rounded-full"></div>
                        <div class="bg-blue-200 h-2 w-full rounded-full"></div>
                    </div>
                </div>
            </section>

            <section class="border-2 border-gray-100 rounded-3xl p-5 shadow-sm">
                <h2 class="text-indigo-900 font-bold text-lg mb-4">Link & Service</h2>
                <div class="flex gap-4">
                    <div class="w-12 h-12 rounded-full border-4 border-blue-500 border-t-transparent animate-spin-slow"></div>
                    <div class="w-12 h-12 rounded-full border-4 border-blue-400 border-b-transparent"></div>
                </div>
            </section>

        </div>

        <footer class="p-4 flex justify-center gap-12 bg-gray-50 border-t">
            <div class="w-4 h-4 bg-gray-400 rounded-sm"></div>
            <div class="w-4 h-4 border-2 border-gray-400 rounded-full"></div>
            <div class="w-0 h-0 border-y-[8px] border-y-transparent border-r-[12px] border-r-gray-400"></div>
        </footer>
    </main>

    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }
    </style>
</body>
</html>