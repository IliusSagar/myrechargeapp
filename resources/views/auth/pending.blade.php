<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Pending</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600">

    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-10 max-w-md text-center">
        
        <!-- Icon -->
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
        </div>

        <!-- Username -->
        <p class="text-lg font-semibold text-gray-800 mb-2">Welcome! {{ Auth::user()->name ?? 'Guest' }}</p>

         @php
                $appSetup = DB::table('app_setups')->first();
            @endphp
           

        <!-- Heading & Message -->
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Please Pay Register Amount!!!</h1>
        <p class="text-gray-600 mb-6"> {!! $appSetup->registered_balance_content !!}</p>

        <!-- Buttons -->
        <div class="flex flex-col gap-4">

            <!-- Register Payment Button -->
            <button onclick="openBalanceModal()"
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-lg transition duration-300">
                Register Payment
            </button>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-lg transition duration-300">
                    Logout
                </button>
            </form>

        </div>

    </div>

    <!-- Payment Modal -->
    <div id="balanceModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md relative">

            <!-- Close Button -->
            <button onclick="closeBalanceModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl font-bold">
                &times;
            </button>

            <!-- Modal Heading -->
            <h2 class="text-xl font-bold text-gray-800 mb-4">Register Payment</h2>

            <!-- Payment Form -->
            <form method="POST" action="" enctype="multipart/form-data">
                @csrf

                <!-- Amount Field -->
                <label class="block text-sm font-medium text-orange-700 mb-1">Amount (MVR)</label>
                <div class="flex items-center border-2 border-orange-300 rounded-lg overflow-hidden mb-4 shadow-sm">
                    <span class="px-3 bg-orange-100 text-orange-700 font-semibold">MVR</span>
                    <input type="number" name="amount" required min="1" placeholder="Enter amount"
                        class="w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400 rounded-r-lg">
                </div>

                <!-- Payment Proof Field -->
                <label class="block text-sm font-medium text-orange-700 mb-1">Payment Proof (Screenshot)</label>
                <input type="file" name="file_upload" required accept="image/*,.pdf"
                    class="w-full border-2 border-orange-300 rounded-lg px-3 py-2 mb-5
                           file:bg-orange-600 file:text-white file:px-4 file:py-2 file:rounded-lg file:border-0 file:cursor-pointer">

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeBalanceModal()"
                        class="px-4 py-2 rounded-lg bg-orange-200 text-orange-800 hover:bg-orange-300 font-semibold transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-orange-600 text-white hover:bg-orange-700 font-semibold transition">
                        Submit Request
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- Modal JS -->
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