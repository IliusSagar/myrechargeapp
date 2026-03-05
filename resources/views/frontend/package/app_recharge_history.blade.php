<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recharge History</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
/* Orange Toastr Overrides */
.toast-success {
    background-color: #f97316 !important; /* Tailwind orange-500 */
    color: white !important;
}
.toast-error {
    background-color: #f97316 !important; /* Tailwind orange-500 */
    color: white !important;
}
.toast-info {
    background-color: #fb923c !important; /* Tailwind orange-400 */
    color: white !important;
}
.toast-warning {
    background-color: #f59e0b !important; /* Tailwind yellow-500 */
    color: white !important;
}
</style>
</head>

<body class="bg-orange-50 min-h-screen font-sans">

<!-- ================= NAVBAR ================= -->
<header class="bg-gradient-to-r from-orange-600 to-orange-700 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">Recharge History</h1>

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
       class="inline-flex items-center gap-2 bg-white hover:bg-orange-100 
              px-3 py-2 rounded-xl font-semibold shadow transition text-orange-600 text-sm">
        ← Back
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto mt-6 space-y-4 px-4 pb-8">

@forelse($packages as $key => $package)

    <div class="bg-white shadow-lg rounded-2xl border border-orange-100 p-4 
                transition hover:shadow-xl hover:-translate-y-1 duration-300">

        <!-- Top Info -->
        <div class="flex justify-between items-center text-xs text-orange-500">
            <span>SL: {{ $key + 1 }}</span>
            <span>{{ \Carbon\Carbon::parse($package->created_at)->format('d M Y, h:i A') }}</span>
        </div>

        <!-- Middle Content -->
        <div class="flex items-center gap-4 mt-3">

            @php
                $packageId = $package->package_id;
                $packageDetail = DB::table('package_details')->where('id', $packageId)->first();
                $pack = DB::table('packages')->where('id', $packageDetail->package_id)->first();
            @endphp

            @if($pack->image_icon)
                <img src="{{ asset('storage/' . $pack->image_icon) }}"
                     alt="{{ $pack->name }}"
                     class="w-16 h-16 rounded-xl object-cover shadow">
            @else
                <div class="w-16 h-16 bg-gray-200 rounded-xl flex items-center justify-center text-gray-400 text-xs">
                    No Image
                </div>
            @endif

            <div class="flex-1">
                <h3 class="text-sm font-semibold text-orange-900">
                    {{ $package->package_name }}
                </h3>

                <p class="text-xs text-orange-500">
                    Number: {{ $package->number }}
                </p>

                <p class="text-sm font-bold text-orange-600 mt-1">
                    {{ number_format($package->amount, 2) }}
                </p>
            </div>
        </div>

        <!-- Status -->
        <div class="mt-3">
            @if($package->status === 'pending')
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                    Pending
                </span>
            @elseif($package->status === 'approved')
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                    Success
                </span>
            @else
                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                    Rejected
                </span>
            @endif
        </div>

    </div>

@empty

    <div class="bg-white rounded-2xl shadow p-6 text-center text-orange-500">
        <div class="text-3xl mb-2">📦</div>
        No recharge history found.
    </div>

@endforelse

</main>

<div class="h-20"></div>

<!-- ================= TOASTR ================= -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
@if(session('success'))
    toastr.success("{{ session('success') }}");
@endif

@if(session('error'))
    toastr.error("{{ session('error') }}");
@endif
</script>

</body>
</html>