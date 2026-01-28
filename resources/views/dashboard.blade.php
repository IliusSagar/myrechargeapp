<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-indigo-600 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">

            <!-- User Welcome -->
            <div>
                <h1 class="text-xl font-bold">
                    Welcome, {{ Auth::user()->name }}
                </h1>
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg font-semibold transition">
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
                <a href="#deposit" class="self-start bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
                    View Deposit
                </a>
            </div>

            <!-- Add Balance Card -->
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col justify-between hover:shadow-xl transition">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Add Balance</h2>
                    <p class="text-gray-600 mb-4">Add funds to your account quickly and securely.</p>
                </div>
                <a href="#add-balance"
                    onclick="openBalanceModal()"
                    class="self-start bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition cursor-pointer">
                    Add Balance
                </a>

            </div>

        </div>

        <!-- Optional Stats / Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Current Balance</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    <span class="text-sm font-semibold text-gray-500">MVR</span> 1,250
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Total Deposit</p>
                <h3 class="text-2xl font-bold text-gray-800">
                    <span class="text-sm font-semibold text-gray-500">MVR</span> 4,500
                </h3>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Pending Approval</p>
                <h3 class="text-2xl font-bold text-gray-800">2</h3>
            </div>
        </div>

    </main>

    <!-- Add Balance Modal -->
<div id="balanceModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative">

        <!-- Close Button -->
        <button onclick="closeBalanceModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl">
            ✕
        </button>

        <h2 class="text-xl font-bold text-gray-800 mb-4">Add Balance</h2>

       <form method="POST" action="{{ route('balance.add') }}" enctype="multipart/form-data">
    @csrf

    <!-- Amount -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Amount (MVR)
    </label>

    <div class="flex items-center border rounded-lg overflow-hidden mb-4">
        <span class="px-3 bg-gray-100 text-gray-600 font-semibold">MVR</span>
        <input type="number"
               name="amount"
               required
               min="1"
               placeholder="Enter amount"
               class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
    </div>

    <!-- Transaction ID -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Transaction ID
    </label>

    <input type="text"
           name="transaction_id"
           required
           placeholder="Enter transaction ID"
           class="w-full border rounded-lg px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-green-500">

    <!-- File Upload -->
    <label class="block text-sm font-medium text-gray-600 mb-1">
        Payment Proof (Screenshot / PDF)
    </label>

    <input type="file"
           name="payment_proof"
           required
           accept="image/*,.pdf"
           class="w-full border rounded-lg px-3 py-2 mb-5 file:bg-green-600 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0 file:cursor-pointer">

    <!-- Actions -->
    <div class="flex justify-end gap-3">
        <button type="button"
                onclick="closeBalanceModal()"
                class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 font-semibold">
            Cancel
        </button>

        <button type="submit"
                class="px-4 py-2 rounded-lg bg-green-600 text-white hover:bg-green-700 font-semibold">
            Submit Request
        </button>
    </div>
</form>

      
    </div>
</div>


<script>
    function openBalanceModal() {
        document.getElementById('balanceModal').classList.remove('hidden');
    }

    function closeBalanceModal() {
        document.getElementById('balanceModal').classList.add('hidden');
    }
</script>


</body>

</html>