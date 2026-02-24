<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>iBanking History</title>

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
        <h1 class="text-lg font-bold">iBanking History</h1>
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
        $bankName = DB::table('bank_names')->where('id', $package->bank_name_id)->first();
    @endphp

    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 space-y-3 hover:shadow-lg transition">
        <!-- Top Row: Bank & Account -->
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ $bankName->bank_name ?? '-' }}</p>
                <p class="text-xs text-gray-500">{{ $package->account_no }}</p>
            </div>
            <div class="text-right">
                <p class="text-indigo-600 font-bold text-sm">MVR {{ $package->amount }}</p>
                <p class="text-gray-500 text-xs">BDT {{ $package->bdt_amount ?? 0 }}</p>
            </div>
        </div>

        <!-- View Slip Button -->
        <div>
            @if($package->upload_slip)
            <button onclick="openSlipModal('{{ asset('storage/'.$package->upload_slip) }}')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-1.5 rounded-xl text-xs shadow flex items-center gap-2">
                <i class="fas fa-file-invoice"></i> View Slip
            </button>
            @else
            <span class="text-gray-400 text-xs">No Slip</span>
            @endif
        </div>

        <!-- Status & Date -->
        <div class="flex justify-between items-center mt-1">
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
        <p>No iBanking history found.</p>
    </div>
    @endforelse

</main>

<!-- ================= SLIP MODAL ================= -->
<div id="slipModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 relative">
        <button onclick="closeSlipModal()"
                class="absolute top-3 right-3 text-gray-500 hover:text-red-500 text-xl">
            ✕
        </button>
        <h3 class="text-lg font-semibold mb-4">Payment Slip</h3>
        <div class="flex justify-center">
            <img id="slipImage" src="" class="max-h-[400px] rounded-xl shadow border">
        </div>
    </div>
</div>

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

<!-- ================= SLIP MODAL JS ================= -->
<script>
    function openSlipModal(imageUrl) {
        document.getElementById('slipImage').src = imageUrl;
        document.getElementById('slipModal').classList.remove('hidden');
        document.getElementById('slipModal').classList.add('flex');
    }
    function closeSlipModal() {
        document.getElementById('slipModal').classList.add('hidden');
        document.getElementById('slipModal').classList.remove('flex');
    }
</script>

</body>
</html>