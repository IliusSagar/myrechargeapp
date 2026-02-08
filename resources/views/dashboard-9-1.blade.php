<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- User Welcome -->
            <h1 class="text-xl font-bold">Welcome, {{ Auth::user()->name }}</h1>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-semibold transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto mt-10 px-4">

      <!-- Optional Stats / Info -->
       <!-- // need margin-bottom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 mb-10">

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Current Balance</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    <span class="text-sm font-semibold text-gray-500">MVR</span> {{ Auth::user()->account->balance ?? 0 }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Total Deposit</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    @php
    $authID = auth()->id();

    $accountID = DB::table('accounts')
        ->where('user_id', $authID)
        ->value('id');

    $totalDeposit = DB::table('transactions')
        ->where('account_id', $accountID)
        ->where('type', 'deposit')
        ->where('status','approved')
        ->sum('amount');
@endphp

<span class="text-sm font-semibold text-gray-500">MVR</span>
{{ $totalDeposit ?? 0 }}

                </h3>
            </div>

            
        </div>

       <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Deposit Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">
        <!-- Icon Circle -->
        <div class="absolute -top-6 left-6 bg-indigo-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2m0 0c0 1.1.9 2 2 2s2-.9 2-2m-2-2v4m0 6v2m0 0h4m-4 0H8"/>
            </svg>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Deposit</h2>
            <p class="text-gray-600 mb-4">Check your deposits and manage your funds.</p>
        </div>
        <button onclick="showDepositTable()"
            class="self-start bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition cursor-pointer">
            View Deposit
        </button>
    </div>

    <!-- Add Balance Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">
        <!-- Icon Circle -->
        <div class="absolute -top-6 left-6 bg-green-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8"/>
            </svg>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Add Balance</h2>
            <p class="text-gray-600 mb-4">Add funds to your account quickly and securely.</p>
        </div>
        <button onclick="openBalanceModal()"
            class="self-start bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition cursor-pointer">
            Add Balance
        </button>
    </div>

    <!-- Packages Card -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">
        <!-- Icon Circle -->
        <div class="absolute -top-6 left-6 bg-blue-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0a9 9 0 11-4-7.7"/>
            </svg>
        </div>

        <div class="mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Packages</h2>
            <p class="text-gray-600 mb-4">Explore and purchase available packages.</p>
        </div>

       <div class="flex gap-3">
    <!-- View Packages Button -->
    <a href="javascript:void(0)" 
       onclick="showPackagesTable()" 
       class="bg-blue-600 text-white text-sm px-3 py-1.5 rounded-lg font-semibold hover:bg-blue-700 transition">
       View Packages
    </a>

    <!-- Package History Button -->
    <a href="{{ route('packages.history') }}" 
       class="bg-green-600 text-white text-sm px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 transition">
       Package History
    </a>
</div>


    </div>

   <!-- Recharge Card -->
<div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative mt-6">

    <!-- Icon -->
    <div class="absolute -top-6 left-6 bg-purple-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8c-1.1 0-2 .9-2 2m0 0c0 1.1.9 2 2 2s2-.9 2-2m-2-2v4m0 6v2" />
        </svg>
    </div>

    <!-- Content -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">BD Recharge</h2>
        <p class="text-gray-600 mb-4">
            BD Recharge your mobile using your account balance or external payment.
        </p>
    </div>

    <!-- Action Buttons -->
<div class="flex justify-between gap-4 mt-4">
    <!-- Recharge Now (Left) -->
    <button onclick="openRechargeModal()"
        class="bg-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition text-sm">
        Recharge Now
    </button>

    <!-- Recharge History (Right) -->
    <a href="{{ route('recharge.history') }}"
        class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition text-sm">
        Recharge History
    </a>
</div>


</div>


<!-- Male Recharge Card -->
<div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">

    <!-- Icon -->
    <div class="absolute -top-6 left-6 bg-green-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5h12M9 3v2m0 14v2m-6-6h12m-9-4h6m-6 8h6" />
        </svg>
    </div>

    <!-- Content -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Male Recharge</h2>
        <p class="text-gray-600 mb-4">
            Male Recharge your mobile using your account balance or external payment.
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between gap-4 mt-4">
        <button onclick="openMaleRechargeModal()"
            class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition text-sm">
            Recharge Now
        </button>

        <a href="{{ route('male.recharge.history') }}"
            class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-emerald-700 transition text-sm">
            Recharge History
        </a>
    </div>

</div>




</div>


      

    </main>

    <!-- Deposit Table -->
<div id="depositTable" class="hidden mt-10 max-w-5xl mx-auto">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold text-gray-800">Deposit Transactions</h2>
           @php
    $transactions = Auth::user()->account->transactions;

    $totalApproved = $transactions->where('status', 'approved')->sum('amount');
    $totalPending = $transactions->where('status', 'pending')->sum('amount');
    $totalRejected = $transactions->where('status', 'rejected')->sum('amount');
@endphp
        <div class="space-x-4">
            <span class="font-semibold text-green-600">Approved: MVR {{ $totalApproved }}</span>
            <span class="font-semibold text-yellow-600">Pending: MVR {{ $totalPending }}</span>
            <span class="font-semibold text-red-600">Rejected: MVR {{ $totalRejected }}</span>
        </div>
        <button onclick="backToDashboard()"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold">Back</button>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow-lg p-4">
        <table class="min-w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="py-2 px-4 font-medium text-gray-700">Transaction ID</th>
                    <th class="py-2 px-4 font-medium text-gray-700">Amount (MVR)</th>
                    <th class="py-2 px-4 font-medium text-gray-700">Status</th>
                    <th class="py-2 px-4 font-medium text-gray-700">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->account->transactions as $transaction)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $transaction->transaction_id }}</td>
                    <td class="py-2 px-4">{{ $transaction->amount }}</td>
                    <!-- <td class="py-2 px-4 capitalize">{{ $transaction->status }}</td> -->
                     <td class="py-2 px-4 capitalize 
    @if($transaction->status == 'pending') text-yellow-500 font-semibold
    @elseif($transaction->status == 'approved') text-green-600 font-semibold
    @elseif($transaction->status == 'rejected') text-red-600 font-semibold
    @else text-gray-800
    @endif">
    {{ $transaction->status }}
</td>
                    <td class="py-2 px-4">{{ $transaction->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
                @if(Auth::user()->account->transactions->isEmpty())
                <tr>
                    <td colspan="4" class="py-4 text-center text-gray-500">No deposits found.</td>
                </tr>
                @endif
            </tbody>
         
            
        </table>
    </div>
</div>


    <!-- Add Balance Modal -->
   <!-- Add Balance Modal -->
<div id="balanceModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">

        <!-- Close Button -->
        <button onclick="closeBalanceModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add Balance</h2>

        @php
        $appSetup = DB::table('app_setups')->first();
        @endphp

         {!! $appSetup->add_balance_content !!}

        <!-- Add Balance Form -->
        <form method="POST" action="{{ route('balance.add') }}" enctype="multipart/form-data">
            @csrf

            <!-- Amount -->
            <label class="block text-sm font-medium text-gray-600 mb-1">Amount (MVR)</label>
            <div class="flex items-center border rounded-lg overflow-hidden mb-4">
                <span class="px-3 bg-gray-100 text-gray-600 font-semibold">MVR</span>
                <input type="number" name="amount" required min="1" placeholder="Enter amount"
                    class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Transaction ID -->
            <label class="block text-sm font-medium text-gray-600 mb-1">Transaction ID</label>
            <input type="text" name="transaction_id" required placeholder="Enter transaction ID"
                class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">

            <!-- File Upload -->
            <label class="block text-sm font-medium text-gray-600 mb-1">Payment Proof (Screenshot / PDF)</label>
            <input type="file" name="file_upload" required accept="image/*,.pdf"
                class="w-full border rounded-lg px-3 py-2 mb-5 file:bg-green-600 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0 file:cursor-pointer">

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeBalanceModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">Cancel</button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold">Submit Request</button>
            </div>
        </form>

    </div>
</div>

<!-- Packages Table / Cards -->
<div id="packagesTable" class="hidden mt-10 max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">

        <button onclick="backToDashboard()"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold transition">
            Back
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        @php
        $packages = \App\Models\Package::where('status', 'active')->get();
        @endphp

        @foreach($packages as $package)
        <div class="relative bg-white rounded-3xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-2xl hover:-translate-y-1 transition transform">

            <!-- Gradient Glow Circle Behind Image -->
            <div class="absolute -top-10 w-40 h-40 rounded-full bg-gradient-to-tr from-indigo-400 via-purple-400 to-pink-400 blur-2xl opacity-30"></div>

            <!-- Package Image with Link -->
            @if($package->image_icon)
            <a href="{{ route('package.show', $package->id) }}" class="relative z-10 block">
                <img src="{{ asset('storage/'.$package->image_icon) }}" 
                     alt="{{ $package->name }}" 
                     class="w-32 h-32 object-cover rounded-full mb-4 shadow-lg hover:scale-105 transition-transform">
            </a>
            @else
            <a href="#" class="relative z-10 block">
                <div class="w-32 h-32 bg-gray-200 flex items-center justify-center rounded-full mb-4 text-gray-500 shadow-inner">
                    No Image
                </div>
            </a>
            @endif

            <!-- Package Info -->
            <h3 class="text-lg font-bold text-gray-800 mb-2 z-10">{{ $package->name }}</h3>

            <!-- Optional Action Button -->
            <a href="{{ route('package.show', $package->id) }}" 
               class="z-10 mt-2 px-5 py-2 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition">
               View Package
            </a>

        </div>
        @endforeach

        @if($packages->isEmpty())
        <p class="col-span-3 text-center text-gray-500 mt-4 text-lg">No packages available.</p>
        @endif

    </div>
</div>


<!-- Recharge Modal -->
<div id="rechargeModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">

        <!-- Close Button -->
        <button onclick="closeRechargeModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">BD Mobile Recharge</h2>

        

        <!-- Recharge Form -->
        <form method="POST" action="{{ route('recharge.submit') }}">
            @csrf

            <!-- Mobile Number -->
            <label class="block text-sm font-medium text-gray-600 mb-1">Mobile Number</label>
            <input type="text" name="mobile" required placeholder="01XXXXXXXXX"
                class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-purple-500">

            <!-- Recharge Amount -->
            <label class="block text-sm font-medium text-gray-600 mb-1">Amount</label>
            <div class="flex items-center border rounded-lg overflow-hidden mb-5">
                <span class="px-3 bg-gray-100 text-gray-600 font-semibold">MVR</span>
                <input type="number" name="amount" required min="1" placeholder="Enter amount"
                    class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeRechargeModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">Cancel</button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 font-semibold">Confirm Recharge</button>
            </div>
        </form>

    </div>
</div>


<!-- Male Recharge Modal -->
<div id="MalerechargeModal"
     class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative max-h-[90vh] overflow-y-auto">

        <!-- Close Button -->
        <button onclick="closeMaleRechargeModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Male Mobile Recharge
        </h2>

        <!-- Recharge Form -->
        <form method="POST" action="{{ route('male.recharge.submit') }}">
            @csrf

            <!-- Mobile Number -->
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Mobile Number
            </label>
            <input type="text" name="mobile" required placeholder="01XXXXXXXXX"
                class="w-full border rounded-lg px-3 py-2 mb-4
                       focus:outline-none focus:ring-2 focus:ring-green-500">

            <!-- Recharge Amount -->
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Amount
            </label>
            <div class="flex items-center border rounded-lg overflow-hidden mb-5">
                <span class="px-3 bg-gray-100 text-gray-600 font-semibold">MVR</span>
                <input type="number" name="amount" required min="1"
                    placeholder="Enter amount"
                    class="w-full px-3 py-2
                           focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button type="button"
                    onclick="closeMaleRechargeModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold">
                    Confirm Recharge
                </button>
            </div>
        </form>

    </div>
</div>



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Modal functions
        function openBalanceModal() {
            document.getElementById('balanceModal').classList.remove('hidden');
        }
        function closeBalanceModal() {
            document.getElementById('balanceModal').classList.add('hidden');
        }

        // Toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": 4000
        };

        // Success / Error flash messages
        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        // Validation errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
            // Open modal if validation fails
            openBalanceModal();
        @endif
    </script>

    <script>
    function showDepositTable() {
        // Hide main dashboard
        document.querySelector('main').classList.add('hidden');
        // Show deposit table
        document.getElementById('depositTable').classList.remove('hidden');
    }

    function backToDashboard() {
        // Show main dashboard
        document.querySelector('main').classList.remove('hidden');
        // Hide deposit table
        document.getElementById('depositTable').classList.add('hidden');
    }
</script>

<script>
function showPackagesTable() {
    // Hide main dashboard
    document.querySelector('main').classList.add('hidden');
    // Hide deposit table if open
    document.getElementById('depositTable').classList.add('hidden');
    // Show packages table
    document.getElementById('packagesTable').classList.remove('hidden');
}

function backToDashboard() {
    // Show main dashboard
    document.querySelector('main').classList.remove('hidden');
    // Hide deposit table
    document.getElementById('depositTable').classList.add('hidden');
    // Hide packages table
    document.getElementById('packagesTable').classList.add('hidden');
}
</script>

<script>
    function openRechargeModal() {
        document.getElementById('rechargeModal').classList.remove('hidden');
    }

    function closeRechargeModal() {
        document.getElementById('rechargeModal').classList.add('hidden');
    }
</script>

<script>
function openMaleRechargeModal() {
    document.getElementById('MalerechargeModal').classList.remove('hidden');
}

function closeMaleRechargeModal() {
    document.getElementById('MalerechargeModal').classList.add('hidden');
}
</script>



</body>

</html>
