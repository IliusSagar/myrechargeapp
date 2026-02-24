<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mobile Banking History</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Font Awesome for icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>
<body class="bg-gray-50 min-h-screen font-sans">

<!-- ================= APP HEADER ================= -->
<header class="bg-blue-600 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">Mobile Banking History</h1>
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
        ← Back
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto px-4 mt-4 space-y-4 pb-10">

    @forelse($packages as $key => $package)
    @php
        $mobileId = $package->mobile_banking_id;
        $mobileDetail = DB::table('mobile_bankings')->where('id', $mobileId)->first();
    @endphp

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 space-y-3 hover:shadow-lg transition">
        <!-- Top Row: Icon + Mobile Banking Name -->
        <div class="flex items-center gap-3">
            <img src="{{ asset('storage/' . $mobileDetail->image_icon) }}" 
                 alt="{{ $mobileDetail->name }}" 
                 class="w-12 h-12 rounded-full shadow">
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $mobileDetail->name ?? '-' }}</p>
                <p class="text-xs text-gray-500">{{ $package->money_status }}</p>
            </div>
        </div>

        <!-- Number & Amount -->
        <div class="flex justify-between items-center text-sm text-gray-700">
            <div>
                <p class="font-medium">Number</p>
                <p>{{ $package->number }}</p>
            </div>
            <div>
                <p class="font-medium">Amount (MVR)</p>
                <p>{{ $package->amount }}</p>
            </div>
            <div>
                <p class="font-medium">Amount (BDT)</p>
                <p>{{ $package->bdt_amount }}</p>
            </div>
        </div>

        <!-- Admin Notes -->
        <div>
            <p class="text-xs font-medium text-gray-500">Admin Notes</p>
            <p class="text-sm text-gray-700">{{ $package->note_admin ?? 'N/A' }}</p>
        </div>

        <!-- Status & Date -->
        <div class="flex justify-between items-center mt-2">
            <div>
                @if($package->status === 'pending')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i> Pending
                    </span>
                @elseif($package->status === 'approved')
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        <i class="fas fa-check-circle mr-1"></i> Approved
                    </span>
                @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fas fa-times-circle mr-1"></i> Rejected
                    </span>
                @endif
            </div>
            <p class="text-gray-400 text-xs">{{ $package->created_at->format('d M Y, h:i A') }}</p>
        </div>
    </div>

    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center text-gray-500">
        <i class="fas fa-folder-open text-3xl mb-3 text-gray-300"></i>
        <p>No Mobile Banking history found.</p>
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