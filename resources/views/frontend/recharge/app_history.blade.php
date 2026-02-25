<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BD Recharge History</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-blue-50 min-h-screen font-sans">

<!-- ================= NAVBAR ================= -->
<header class="bg-blue-600 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">BD Recharge History</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg text-sm font-semibold transition shadow">
                Logout
            </button>
        </form>
    </div>
</header>

<!-- ================= BACK BUTTON ================= -->
<div class="max-w-md mx-auto px-4 mt-4">
    <a href="{{ route('app_dashboard') }}"
       class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 px-3 py-2 rounded-xl font-semibold shadow transition">
        ← Back
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto mt-6 space-y-4">

    @forelse($recharges as $key => $recharge)
    <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-4 flex flex-col space-y-2">
        
        <!-- Header: SL & Date -->
        <div class="flex justify-between items-center text-sm text-gray-500 font-medium">
            <span>SL: {{ $key + 1 }}</span>
            <span>{{ $recharge->created_at->format('d M Y H:i') }}</span>
        </div>

        <!-- Recharge Info -->
        <div class="flex justify-between items-center mt-2">
            <!-- Mobile & Amount -->
            <div class="flex-1">
                <h3 class="text-gray-900 font-semibold text-sm">Mobile: {{ $recharge->mobile }}</h3>
                <p class="text-gray-700 font-medium text-sm">Amount: ${{ number_format($recharge->amount, 2) }}</p>
            </div>

            <!-- Status Badge -->
            <div>
                @if($recharge->status === 'pending')
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                @elseif($recharge->status === 'approved')
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Approved</span>
                @else
                    <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Rejected</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white shadow-lg rounded-2xl border border-gray-100 p-6 text-center text-gray-500">
        No recharge history available.
    </div>
    @endforelse

</main>

<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if(session('info'))
        toastr.info("{{ session('info') }}");
    @endif

    @if(session('warning'))
        toastr.warning("{{ session('warning') }}");
    @endif

    // Optional: Toastr options
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "3000",
    };
</script>
</body>
</html>