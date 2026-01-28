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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Deposit Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Deposit</h2>
                    <p class="text-gray-600 mb-4">Check your deposits and manage your funds.</p>
                </div>
                <!-- <a href="#deposit"
                    class="self-start bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    View Deposit
                </a> -->

                <button onclick="showDepositTable()"
    class="self-start bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition cursor-pointer">
    View Deposit
</button>

            </div>

            <!-- Add Balance Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Add Balance</h2>
                    <p class="text-gray-600 mb-4">Add funds to your account quickly and securely.</p>
                </div>
                <button onclick="openBalanceModal()"
                    class="self-start bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition cursor-pointer">
                    Add Balance
                </button>
            </div>

        </div>

        <!-- Optional Stats / Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Current Balance</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    <span class="text-sm font-semibold text-gray-500">MVR</span> {{ Auth::user()->account->balance ?? 0 }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Total Deposit</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    <span class="text-sm font-semibold text-gray-500">MVR</span> {{ Auth::user()->account->balance ?? 0 }}
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Pending For Approval</p>
                @php
                    $pendingCount = \App\Models\Transaction::where('account_id', Auth::user()->account->id)
                        ->where('status', 'pending')
                        ->count();
                @endphp
                <h3 class="text-2xl font-bold text-gray-800">{{ $pendingCount }}</h3>
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
    <div id="balanceModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

            <!-- Close Button -->
            <button onclick="closeBalanceModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">✕</button>

            <h2 class="text-xl font-bold text-gray-800 mb-4">Add Balance</h2>

             <!-- Payment Methods -->
        <div class="bg-gray-50 rounded-lg p-4 mb-4 border-l-4 border-indigo-500">
            <h3 class="font-semibold text-gray-800 mb-2">Mobile Financial Services (MFS)</h3>
            <ul class="list-disc list-inside text-gray-700">
                <li>bKash account no: 01756351556 (Send money only)</li>
                <li>Nagad account no: 01756351556 (Send money only)</li>
                <li>Rocket account no: 01756351556 (Send money only)</li>
                <li>Upay account no: Off now</li>
            </ul>
        </div>

        <!-- Bank Account Details -->
        <div class="bg-gray-50 rounded-lg p-4 mb-4 border-l-4 border-green-500">
            <h3 class="font-semibold text-gray-800 mb-2">Bank Account Details</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>DBBL Account Number: 2381100010503</li>
                <li>Account Name: Digital Flexiload</li>
                <li>Branch: Alenga, Kalihati, Tangail</li>
                <li>Brac Bank Account Number: 1053681080001</li>
                <li>Account Name: HASEBUL HASAN</li>
                <li>Branch: Bashundhara Branch, Dhaka</li>
                <li>Cellfin number: 01705080902</li>
            </ul>
        </div>

        <!-- Important Note -->
        <div class="bg-yellow-100 text-yellow-800 rounded-lg p-4 mb-4 border-l-4 border-yellow-500">
            <h3 class="font-semibold text-gray-800 mb-1">Important Note (বিঃদ্রঃ)</h3>
            <p class="text-sm text-gray-800">
                বাংলা: মেইন ব্যালেন্সটাই শুধু আপনারা ব্যবহার করবেন। মেইন ব্যালেন্স দিয়েই ড্রাইভসহ সকল কিছু ব্যবহার করতে পারবেন।
            </p>
        </div>

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


</body>

</html>
