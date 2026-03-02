<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Deposit History</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
/* ================= TOASTR ORANGE THEME ================= */

/* Success → Orange */
#toast-container > .toast-success {
    background: linear-gradient(to right, #f97316, #ea580c) !important; /* orange gradient */
    color: white !important;
    border-left: 5px solid #c2410c !important;
}

/* Error → Red */
#toast-container > .toast-error {
    background: linear-gradient(to right, #dc2626, #b91c1c) !important; /* red gradient */
    color: white !important;
    border-left: 5px solid #7f1d1d !important;
}

/* Info → Blue */
#toast-container > .toast-info {
    background: linear-gradient(to right, #3b82f6, #2563eb) !important; /* blue gradient */
    color: white !important;
    border-left: 5px solid #1e40af !important;
}

/* Warning → Amber */
#toast-container > .toast-warning {
    background: linear-gradient(to right, #f59e0b, #d97706) !important; /* amber gradient */
    color: white !important;
    border-left: 5px solid #b45309 !important;
}

/* Common toast styling */
#toast-container .toast {
    border-radius: 12px !important;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
    font-weight: 600 !important;
    padding: 12px 16px !important;
    font-size: 14px !important;
}
</style>

</head>
<body class="bg-orange-50 min-h-screen font-sans">

<!-- ================= NAVBAR ================= -->
<header class="bg-orange-600 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">Deposit History</h1>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-orange-500 hover:bg-orange-700 px-3 py-1.5 rounded-lg text-sm font-semibold transition shadow">
                Logout
            </button>
        </form>
    </div>
</header>

<!-- ================= BACK BUTTON ================= -->
<div class="max-w-md mx-auto px-4 mt-4">
    <a href="{{ route('app_dashboard') }}"
       class="inline-flex items-center gap-2 bg-white hover:bg-orange-100 px-3 py-2 rounded-xl font-semibold shadow transition text-orange-600">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto mt-6 space-y-4">

    @foreach(Auth::user()->account->transactions as $key => $transaction)
    <div class="bg-white shadow-lg rounded-2xl border border-orange-100 p-4 flex flex-col space-y-2">
        <div class="flex justify-between items-center">
            <span class="text-sm text-orange-500 font-medium">SL: {{ $key + 1 }}</span>
            <span class="text-sm text-orange-400">{{ $transaction->created_at->format('d M Y') }}</span>
        </div>
        <div class="flex justify-between items-center">
            <div>
                <p class="text-orange-900 font-semibold text-sm">Transaction ID:</p>
                <p class="text-orange-700 text-sm">{{ $transaction->transaction_id }}</p>
            </div>
            <div class="text-right">
                <p class="text-orange-900 font-semibold text-sm">Amount</p>
                <p class="text-orange-600 font-bold text-sm">MVR {{ $transaction->amount }}</p>
            </div>
        </div>
        <div class="flex justify-start items-center gap-2 mt-2">
            @if($transaction->status === 'pending')
                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">Pending</span>
            @elseif($transaction->status === 'approved')
                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-orange-200 text-orange-900">Approved</span>
            @else
                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Rejected</span>
            @endif
        </div>
    </div>
    @endforeach

    @if(Auth::user()->account->transactions->isEmpty())
        <div class="bg-white shadow-lg rounded-2xl border border-orange-100 p-6 text-center text-orange-500">
            No deposit history found.
        </div>
    @endif

</main>

<!-- ================= TOASTR JS ================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "timeOut": 4000
};

// Success → Orange
@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif

// Error → Red
@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif

// Laravel validation errors
@if($errors->any())
    @foreach($errors->all() as $error)
        toastr.error("{{ $error }}");
    @endforeach
@endif

// Example function for copy ID with orange toast
function copyUserId() {
    const userId = "{{ Auth::user()->account->account_number ?? '' }}";
    navigator.clipboard.writeText(userId);
    toastr.success("User ID copied!");
}
</script>
</body>
</html>