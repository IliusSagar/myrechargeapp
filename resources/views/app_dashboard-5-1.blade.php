<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Digital Flexiload UI</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-blue-50">

<main class="max-w-md mx-auto min-h-screen bg-white shadow-2xl flex flex-col">

    <!-- Header -->
    <header class="bg-blue-600 p-4 flex justify-between items-center text-white">
        <div class="flex items-center gap-3">
            <div class="bg-gray-300 rounded-full h-10 w-10 flex items-center justify-center">
                <i class="fas fa-user text-gray-700 text-xl"></i>
            </div>
            
            <div class="flex flex-col">
    <p class="text-xs text-indigo-100 font-medium tracking-wide">
        USER ID
    </p>

    <div class="flex items-center gap-2 mt-1">
        <div class="bg-white/20 backdrop-blur-md border border-white/30 px-3 py-1.5 rounded-lg shadow-sm">
            <span class="text-white font-semibold tracking-wider">
                {{ Auth::user()->account->account_number ?? 'N/A' }}
            </span>
        </div>

        <button onclick="copyUserId()" 
            class="bg-white/20 hover:bg-white/30 transition px-2 py-1 rounded-md text-xs">
            <i class="fas fa-copy text-white"></i>
        </button>
    </div>
</div>

        </div>

        <!-- Top-right dropdown menu -->
        <div class="relative">
            <button id="dropdownButton" onclick="toggleDropdown()"
                class="bg-white text-blue-600 font-bold px-4 py-2 rounded-lg shadow hover:bg-blue-50 flex items-center gap-2 transition">
                Menu <i class="fas fa-caret-down"></i>
            </button>

            <div id="dropdownMenu"
                class="hidden absolute right-0 mt-2 w-48 bg-gradient-to-b from-blue-50 to-blue-100 border border-blue-300 rounded-lg shadow-lg z-50">
                <button onclick="openPasswordModal()"
                    class="w-full text-left px-4 py-2 text-blue-800 font-semibold hover:bg-yellow-300 rounded-t-lg transition">
                    <i class="fas fa-user-circle mr-2"></i> My Account
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-red-700 font-semibold hover:bg-red-200 rounded-b-lg transition">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Marquee under header -->
    <div class="bg-blue-500 overflow-hidden relative">
        @php
            $appNote = DB::table('app_setups')->where('id', 1)->first();
        @endphp
        <div class="marquee whitespace-nowrap text-white font-semibold py-2 px-4 text-sm md:text-base">
            {!! $appNote->marquee !!}
        </div>
    </div>

    <!-- Main Content -->
    <div class="px-4 py-6 flex-1 space-y-6">

        <!-- My Account Section -->
        <section class="border-2 border-gray-100 rounded-3xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-indigo-900 font-bold text-lg">My account</p>
                    <p class="text-blue-400 font-medium">{{ Auth::user()->name ?? 'Ronyl' }}</p>
                </div>

                <!-- My Balance Button with Dropdown -->
                <div class="relative">
                    <button onclick="toggleBalance()" 
                        class="flex items-center gap-2 border-2 border-blue-600 rounded-full px-4 py-1 text-indigo-900 font-bold text-sm">
                        <span class="bg-blue-400 text-white rounded-full w-5 h-5 flex items-center justify-center text-[10px]">৳</span>
                        My Balance
                    </button>

                    <!-- Balance Dropdown -->
                    <div id="balanceDropdown" 
                        class="hidden absolute right-0 mt-2 w-56 bg-white border border-blue-300 rounded-lg shadow-lg z-50 p-3 text-sm">
                        
                        @php
                            $authID = auth()->id();
                            $accountID = DB::table('accounts')->where('user_id', $authID)->value('id');
                            $totalDeposit = DB::table('transactions')
                                ->where('account_id', $accountID)
                                ->where('type', 'deposit')
                                ->where('status','approved')
                                ->sum('amount');
                        @endphp

                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600 font-medium">Current Balance :</span>
                            <span class="text-blue-600 font-bold">(MVR) {{ Auth::user()->account->balance ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 font-medium">Total Deposit:</span>
                            <span class="text-green-600 font-bold">(MVR) {{ $totalDeposit ?? 0 }}</span>
                        </div>
                        <hr class="my-1 border-gray-200">
                        <p class="text-xs text-gray-500">Updated: {{ now()->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="text-gray-400 font-bold text-sm">My Level</p>
                    <p class="text-orange-400 font-bold">Retailer</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-4 gap-2 text-center">
                <div class="group cursor-pointer" onclick="openBalanceModal()">
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
                    <p class="text-[11px] font-bold text-indigo-900 mt-2">My Users</p>
                </div>
            </div>
        </section>

        <!-- Recharge & Bill Payments -->
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

    </div>

    <!-- Footer -->
    <footer class="p-4 flex justify-center gap-12 bg-gray-50 border-t">
        <div class="w-4 h-4 bg-gray-400 rounded-sm"></div>
        <div class="w-4 h-4 border-2 border-gray-400 rounded-full"></div>
        <div class="w-0 h-0 border-y-[8px] border-y-transparent border-r-[12px] border-r-gray-400"></div>
    </footer>
</main>

<!-- Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">
        <button onclick="closePasswordModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Change Account</h2>
        <form method="POST" action="{{ route('password.change') }}">
            @csrf


            <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
            <input type="text" name="name" value="{{ Auth::user()->name ?? '' }}"  class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

      
            <label class="block text-sm font-medium text-gray-600 mb-1">Phone</label>
            <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}"  class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

     
            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ Auth::user()->email ?? '' }}"  class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500">

            <label class="block text-sm font-medium text-gray-600 mb-1">Change Password</label>
            <input type="password" name="password"  class="w-full border rounded-lg px-3 py-2 mb-5 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closePasswordModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-semibold">Update Account</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Balance Modal -->
<div id="balanceModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">
        <button onclick="closeBalanceModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>
        <h2 class="text-xl font-bold text-gray-800 mb-4">Add Balance</h2>
        @php
            $appSetup = DB::table('app_setups')->first();
        @endphp
        {!! $appSetup->add_balance_content !!}
        <form method="POST" action="{{ route('balance.add') }}" enctype="multipart/form-data">
            @csrf
            <label class="block text-sm font-medium text-gray-600 mb-1">Amount (MVR)</label>
            <div class="flex items-center border rounded-lg overflow-hidden mb-4">
                <span class="px-3 bg-gray-100 text-gray-600 font-semibold">MVR</span>
                <input type="number" name="amount" required min="1" placeholder="Enter amount"
                    class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Transaction ID</label>
            <input type="text" name="transaction_id" required placeholder="Enter transaction ID"
                class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">
            <label class="block text-sm font-medium text-gray-600 mb-1">Payment Proof (Screenshot)</label>
            <input type="file" name="file_upload" required accept="image/*,.pdf"
                class="w-full border rounded-lg px-3 py-2 mb-5 file:bg-green-600 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0 file:cursor-pointer">
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeBalanceModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold">Submit Request</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes spin-slow { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .animate-spin-slow { animation: spin-slow 3s linear infinite; }

    .marquee { display: inline-block; padding-left: 100%; animation: scroll-marquee 15s linear infinite; }
    @keyframes scroll-marquee { 0% { transform: translateX(0%); } 100% { transform: translateX(-100%); } }
    @media (max-width:768px){.marquee{font-size:12px;padding-left:100%;}}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    // Dropdown
    function toggleDropdown() { document.getElementById('dropdownMenu').classList.toggle('hidden'); }
    window.addEventListener('click', function(e){
        const button = document.getElementById('dropdownButton'), menu = document.getElementById('dropdownMenu');
        if(!button.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
    });

    // Password Modal
    function openPasswordModal() { document.getElementById('passwordModal').classList.remove('hidden'); }
    function closePasswordModal() { document.getElementById('passwordModal').classList.add('hidden'); }

    // Balance Dropdown
    function toggleBalance() { document.getElementById('balanceDropdown').classList.toggle('hidden'); }
    window.addEventListener('click', function(e){
        const button = document.querySelector('[onclick="toggleBalance()"]'), dropdown = document.getElementById('balanceDropdown');
        if(!button.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden');
    });

    // Add Balance Modal
    function openBalanceModal() { document.getElementById('balanceModal').classList.remove('hidden'); }
    function closeBalanceModal() { document.getElementById('balanceModal').classList.add('hidden'); }

    // Toastr
    toastr.options = { "closeButton": true, "progressBar": true, "positionClass": "toast-top-right", "timeOut": 4000 };
    @if(session('success')) toastr.success("{{ session('success') }}"); @endif
    @if(session('error')) toastr.error("{{ session('error') }}"); @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
        openBalanceModal();
    @endif
</script>

<!-- user ID Design JS  -->
<script>
    function copyUserId() {
    const userId = "{{ Auth::user()->account->account_number ?? '' }}";
    navigator.clipboard.writeText(userId);
    toastr.success("User ID copied!");
}
</script>

</body>
</html>