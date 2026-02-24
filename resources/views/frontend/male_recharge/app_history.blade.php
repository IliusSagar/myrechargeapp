<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Male Recharge History</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="bg-gray-50 min-h-screen font-sans">

<!-- ================= APP HEADER ================= -->
<header class="bg-blue-600 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">Male Recharge History</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg text-sm font-semibold transition shadow">
                Logout
            </button>
        </form>
    </div>
</header>


<div class="max-w-md mx-auto px-4 mt-4">
    <a href="{{ route('app_dashboard') }}"
       class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 px-3 py-2 rounded-xl font-semibold shadow transition">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<main class="max-w-md mx-auto px-4 mt-6 space-y-4 pb-10">

    @forelse($recharges as $key => $recharge)

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">

        <!-- Top Row -->
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center gap-3">
                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-full">
                    <i class="fas fa-mobile-alt text-sm"></i>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $recharge->mobile }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $recharge->created_at->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>

            <div class="text-right">
                <p class="text-indigo-600 font-bold text-sm">
                    MVR {{ number_format($recharge->amount, 2) }}
                </p>
            </div>
        </div>

        <!-- Status -->
        <div>
            @if($recharge->status === 'pending')
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">
                    <i class="fas fa-clock mr-1"></i> Pending
                </span>
            @elseif($recharge->status === 'approved')
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                    <i class="fas fa-check-circle mr-1"></i> Approved
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                    <i class="fas fa-times-circle mr-1"></i> Rejected
                </span>
            @endif
        </div>

    </div>

    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">
        <i class="fas fa-folder-open text-3xl mb-3 text-gray-300"></i>
        <p>No recharge history found.</p>
    </div>
    @endforelse

</main>

<!-- ================= TOASTR ================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        timeOut: 3000,
        positionClass: "toast-top-right"
    };

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

</body>
</html>