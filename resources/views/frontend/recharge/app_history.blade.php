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

<style>
/* Orange Toastr Custom */
.toast-success { background-color: #f97316 !important; }
.toast-error { background-color: #dc2626 !important; }
.toast-info { background-color: #fb923c !important; }
.toast-warning { background-color: #ea580c !important; }
</style>

</head>

<body class="bg-orange-50 min-h-screen font-sans">

<!-- ================= NAVBAR ================= -->
<header class="bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg">
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
       class="inline-flex items-center gap-2 bg-white hover:bg-orange-100 px-3 py-2 rounded-xl font-semibold shadow transition border border-orange-200">
        ← Back
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto mt-6 space-y-4">

    @forelse($recharges as $key => $recharge)
    <div class="bg-white shadow-xl rounded-2xl border border-orange-100 p-4 flex flex-col space-y-2 transition hover:shadow-2xl">
        
        <!-- Header -->
        <div class="flex justify-between items-center text-sm text-orange-500 font-medium">
            <span>SL: {{ $key + 1 }}</span>
            <span>{{ $recharge->created_at->format('d M Y H:i') }}</span>
        </div>

        <!-- Recharge Info -->
        <div class="flex justify-between items-center mt-2">
            <div class="flex-1">
                <h3 class="text-gray-900 font-semibold text-sm">
                    Mobile: {{ $recharge->mobile }}
                </h3>
                <p class="text-orange-600 font-semibold text-sm">
                    Amount: ${{ number_format($recharge->amount, 2) }}
                </p>
            </div>

            <!-- Status Badge -->
            <div>
                @if($recharge->status === 'pending')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                        Pending
                    </span>
                @elseif($recharge->status === 'approved')
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                        Approved
                    </span>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                        Rejected
                    </span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white shadow-xl rounded-2xl border border-orange-100 p-6 text-center text-orange-400">
        No recharge history available.
    </div>
    @endforelse

</main>

<script>
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "3000",
    };

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
</script>

</body>
</html>