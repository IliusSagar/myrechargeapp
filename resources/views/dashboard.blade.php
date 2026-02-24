<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
@keyframes marquee {
    0%   { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}

.animate-marquee {
    display: inline-block;
    min-width: 100%;
    animation: marquee 20s linear infinite;
}
</style>


</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
 <nav class="bg-indigo-600 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

        <!-- Left Side -->
        <div>
            <h1 class="text-xl font-bold">
                Welcome: {{ Auth::user()->name }}
            </h1>

            <p class="text-sm text-indigo-100 mt-1">
                User ID: 
                <span class="bg-white text-indigo-600 px-2 py-1 rounded-md font-semibold">
                    {{ Auth::user()->account->account_number ?? 'N/A' }}
                </span>
            </p>
        </div>

        <!-- Right Side -->
        <div class="flex gap-3">
            <button onclick="openPasswordModal()"
                class="bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg font-semibold transition">
                My Account
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-semibold transition">
                    Logout
                </button>
            </form>
        </div>

    </div>
</nav>

<div id="passwordModal"
     class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 p-4">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

        <!-- Close -->
        <button onclick="closePasswordModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">
            ✕
        </button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Change Account
        </h2>

        <form method="POST" action="{{ route('password.change') }}">
            @csrf

             <!-- Name -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Name
    </label>
    <input type="text" 
           name="name" 
           value="{{ Auth::user()->name }}" 
           required
           class="w-full border rounded-lg px-3 py-2 mb-4
                  focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <!-- Phone -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Phone
    </label>
    <input type="text" 
           name="phone" 
           value="{{ Auth::user()->phone }}" 
           required
           class="w-full border rounded-lg px-3 py-2 mb-4
                  focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <!-- Email -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Email
    </label>
    <input type="email" 
           name="email" 
           value="{{ Auth::user()->email }}" 
           required
           class="w-full border rounded-lg px-3 py-2 mb-4
                  focus:outline-none focus:ring-2 focus:ring-indigo-500">

    <!-- Divider -->
    <hr class="my-4">

           

        

            <!-- Confirm Password -->
            <label class="block text-sm font-medium text-gray-600 mb-1">
                Change Password
            </label>
            <input type="password" name="password" 
                class="w-full border rounded-lg px-3 py-2 mb-5
                       focus:outline-none focus:ring-2 focus:ring-indigo-500">

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closePasswordModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">
                    Cancel
                </button>

                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 font-semibold">
                    Update Account
                </button>
            </div>
        </form>

    </div>
</div>


    <!-- Main Content -->
    <main class="max-w-5xl mx-auto mt-10 px-4">

    <!-- Notification Marquee -->
<div class="relative overflow-hidden rounded-2xl shadow-lg mb-6">

    <!-- Gradient Background -->
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 p-4">

        <div class="flex items-center gap-3">

            <!-- Icon -->
            <div class="bg-white/20 backdrop-blur-md p-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M13 16h-1v-4h-1m1-4h.01" />
                </svg>
            </div>

            <!-- Marquee Container -->
            <div class="relative w-full overflow-hidden">

                @php
                $appNote = DB::table('app_setups')->where('id', 1)->first();
                @endphp

                <div class="whitespace-nowrap animate-marquee text-white font-semibold text-sm md:text-base hover:[animation-play-state:paused]">
                    {!! $appNote->marquee !!}
                </div>

            </div>
        </div>

    </div>
</div>


      <!-- Optional Stats / Info -->
       <!-- // need margin-bottom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 mb-10">

            <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-4">
    <!-- Icon -->
    <div class="bg-indigo-100 text-indigo-600 p-3 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2m-2-2v4m0 6v2" />
        </svg>
    </div>

    <!-- Content -->
    <div>
        <p class="text-gray-500 text-sm">Current Balance</p>
        <h3 class="text-2xl font-bold text-gray-800">
            <span class="text-sm font-semibold text-gray-500">MVR</span>
            {{ Auth::user()->account->balance ?? 0 }}
        </h3>
    </div>
</div>


        <div class="bg-white rounded-2xl shadow-lg p-6 flex items-center gap-4">
    <!-- Icon -->
    <div class="bg-green-100 text-green-600 p-3 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4" />
        </svg>
    </div>

    <!-- Content -->
    <div>
        <p class="text-gray-500 text-sm">Total Deposit</p>
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


            
        </div>

       <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <!-- Deposit Card -->
  

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
        

        <div class="flex gap-3">
    <a onclick="openBalanceModal()"
            class="bg-green-600 text-white text-sm px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 transition cursor-pointer">
            Add Balance
</a>

    <!-- Package History Button -->
    <a href="{{ route('balance.history') }}" 
       class="bg-emerald-600 text-white text-sm px-3 py-1.5 rounded-lg font-semibold hover:bg-green-700 transition">
       Deposit History
    </a>
</div>
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
        class="bg-purple-600 text-white  px-4 py-2 rounded-lg font-semibold hover:bg-purple-700 transition text-sm">
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

<!-- Mobile Banking Card -->
<div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">

    <!-- Icon -->
    <div class="absolute -top-6 left-6 bg-orange-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-6v-6H10v6H4a1 1 0 01-1-1V10z" />
        </svg>
    </div>

    <!-- Content -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Mobile Banking</h2>
        <p class="text-gray-600 mb-4">
            Pay bills, transfer money, and manage your mobile banking services.
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between gap-4 mt-4">
       <a href="javascript:void(0)" 
   onclick="showMobileBankingTable()" 
   class="bg-orange-600 text-white text-sm px-3 py-1.5 rounded-lg font-semibold hover:bg-orange-700 transition">
   View Mobile Banking
</a>

        <a href="{{ route('mobile.banking.history') }}"
            class="bg-amber-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-amber-700 transition text-sm">
            Mobile Banking History
        </a>

        
    </div>

</div>


<!-- iBanking Card -->
<div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition relative">

    <!-- Icon -->
    <div class="absolute -top-6 left-6 bg-indigo-600 text-white w-12 h-12 flex items-center justify-center rounded-full shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-6v-6H10v6H4a1 1 0 01-1-1V10z" />
        </svg>
    </div>

    <!-- Content -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-2">iBanking</h2>
        <p class="text-gray-600 mb-4">
            Secure online banking services and transactions.
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between gap-4 mt-4">
        <button onclick="openIBankingModal()"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition text-sm">
            View iBanking
        </button>

        <a href="{{ route('ibanking.history') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition text-sm">
            iBanking History
        </a>
    </div>

</div>

@include('frontend.popup.iBanking')






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
            <label class="block text-sm font-medium text-gray-600 mb-1">Payment Proof (Screenshot)</label>
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

<!-- Mobile Banking Table -->
<div id="mobileBankingTable" class="hidden mt-10 max-w-6xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Mobile Banking Services</h2>
       
        <button onclick="backToDashboard()"
            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-xl font-semibold transition">
            Back
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        @php
        $mobileBankings = \App\Models\MobileBanking::where('status', 'active')->get();
        @endphp

        @forelse($mobileBankings as $banking)
        <div class="relative bg-white rounded-3xl shadow-lg p-6 flex flex-col items-center text-center hover:shadow-2xl hover:-translate-y-1 transition transform">

            <!-- Glow Effect -->
            <div class="absolute -top-10 w-40 h-40 rounded-full bg-gradient-to-tr from-orange-400 via-amber-400 to-yellow-400 blur-2xl opacity-30"></div>

            <!-- Banking Logo -->
            @if($banking->image_icon)
            <div class="relative z-10">
                <img src="{{ asset('storage/'.$banking->image_icon) }}" 
                     alt="{{ $banking->name }}" 
                     class="w-28 h-28 object-cover rounded-full mb-4 shadow-lg">
            </div>
            @else
            <div class="relative z-10 w-28 h-28 bg-gray-200 flex items-center justify-center rounded-full mb-4 text-gray-500 shadow-inner">
                No Logo
            </div>
            @endif

            <!-- Info -->
            <h3 class="text-lg font-bold text-gray-800 mb-2 z-10">{{ $banking->name }}</h3>


            <!-- Action Button -->
            <button onclick="openMobileBankingModal({{ $banking->id }}, {{ $banking->rate }})"
                class="z-10 mt-2 px-5 py-2 bg-orange-600 text-white font-semibold rounded-xl hover:bg-orange-700 transition">
                Use Service
            </button>
        </div>
        @empty
        <p class="col-span-3 text-center text-gray-500 mt-4 text-lg">
            No mobile banking services available.
        </p>
        @endforelse

    </div>
</div>

<!-- Mobile Banking Modal -->
<div id="mobileBankingModal"
    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">

    <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl relative">

        <h2 class="text-xl font-bold mb-4 text-gray-800">
            Mobile Banking Request
        </h2>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 text-red-600 text-sm bg-red-100 p-3 rounded-lg">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form id="mobileBankingForm" method="POST"
            action="{{ route('mobile.banking.store') }}">
            @csrf

             <!-- Total Amount Display -->
            <p class="text-gray-700 mb-4 flex items-center justify-between bg-orange-50 border border-orange-200 rounded-lg px-4 py-2 shadow-sm">
    <span class="font-medium">BDT Converted:</span>
    <span id="totalAmount" class="font-bold text-orange-600 text-lg">0</span>
</p>

            <!-- Hidden Banking ID -->
            <input type="hidden" name="mobile_banking_id" id="mobile_banking_id">
            <input type="hidden" name="rate_calculation" id="rateCalculationInput">

            

            <!-- Mobile Number -->
            <label class="block text-sm font-medium mb-1">
                Mobile Number
            </label>
            <input type="text"
                name="number"
                maxlength="15"
                required
                class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring-2 focus:ring-orange-500"
                placeholder="Enter mobile number">

            <!-- Amount -->
            <label class="block text-sm font-medium mb-1">
                Amount (MVR)
            </label>
            <input type="number"
                name="amount"
                id="amountInput"
                required
                min="1"
                class="w-full border rounded-lg px-3 py-2 mb-2 focus:ring-2 focus:ring-orange-500"
                placeholder="Enter amount">

           

            <!-- Money Status Radio -->
            <label class="block text-sm font-medium mb-2">
                Select Account Type
            </label>

            <div class="flex gap-6 mb-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio"
                        name="money_status"
                        value="personal"
                        checked
                        required
                        class="text-orange-600 focus:ring-orange-500">
                    <span class="text-gray-700">Personal</span>
                </label>

                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio"
                        name="money_status"
                        value="agent"
                        class="text-orange-600 focus:ring-orange-500">
                    <span class="text-gray-700">Agent</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <button type="button"
                    onclick="closeMobileBankingModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Cancel
                </button>

                <button type="submit"
                    id="submitBtn"
                    class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                    Confirm
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

<script>
function openPasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}
</script>

<script>
let currentRate = 0; // global rate

function showMobileBankingTable() {
    document.querySelector('main').classList.add('hidden');
    document.getElementById('depositTable').classList.add('hidden');
    document.getElementById('packagesTable').classList.add('hidden');
    document.getElementById('mobileBankingTable').classList.remove('hidden');
}

function backToDashboard() {
    document.querySelector('main').classList.remove('hidden');
    document.getElementById('depositTable').classList.add('hidden');
    document.getElementById('packagesTable').classList.add('hidden');
    document.getElementById('mobileBankingTable').classList.add('hidden');
}

function openMobileBankingModal(id, rate) {
    document.getElementById('mobile_banking_id').value = id;
    currentRate = rate;

    document.getElementById('mobileBankingModal').classList.remove('hidden');
    document.getElementById('mobileBankingModal').classList.add('flex');

    // Reset inputs
    document.getElementById('amountInput').value = '';
    document.getElementById('totalAmount').innerText = '0';
}

function closeMobileBankingModal() {
    let modal = document.getElementById('mobileBankingModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Live total calculation
document.getElementById('amountInput').addEventListener('input', function() {
    let amount = parseFloat(this.value) || 0;
    let total = amount * currentRate;
    document.getElementById('totalAmount').innerText = total.toFixed(2);
});

// Loading state on submit
document.getElementById('mobileBankingForm').addEventListener('submit', function () {
    let btn = document.getElementById('submitBtn');
    btn.innerText = 'Processing...';
    btn.disabled = true;
});

// Live total calculation
document.getElementById('amountInput').addEventListener('input', function() {
    let amount = parseFloat(this.value) || 0;
    let total = amount * currentRate;

    // Show in modal
    document.getElementById('totalAmount').innerText = total.toFixed(2);

    // Update hidden input for backend
    document.getElementById('rateCalculationInput').value = total.toFixed(2);
});

</script>





</body>

</html>
