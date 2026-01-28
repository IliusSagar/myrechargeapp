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
                <a href="#add-balance" class="self-start bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition">
                    Add Balance
                </a>
            </div>

        </div>

        <!-- Optional Stats / Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-10">
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Current Balance</p>
                <h3 class="text-2xl font-bold text-gray-800">$1,250</h3>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Total Deposit</p>
                <h3 class="text-2xl font-bold text-gray-800">$4,500</h3>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-6 text-center">
                <p class="text-gray-500">Pending Approval</p>
                <h3 class="text-2xl font-bold text-gray-800">2</h3>
            </div>
        </div>
    </main>

</body>
</html>
