<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Packages</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 min-h-screen font-sans">

<!-- ================= NAVBAR ================= -->
<header class="bg-orange-600 text-white shadow-md">
    <div class="max-w-md mx-auto flex justify-between items-center px-4 py-4">
        <h1 class="text-lg font-bold">Packages</h1>
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
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<!-- ================= MAIN CONTENT ================= -->
<main class="max-w-md mx-auto mt-6 space-y-4">

    @php
        $packages = \App\Models\Package::where('status', 'active')->get();
    @endphp

    @foreach($packages as $key => $package)
    <div class="bg-white shadow-lg rounded-2xl border border-orange-100 p-4 flex flex-col space-y-2">
        <div class="flex justify-between items-center">
            <span class="text-sm text-orange-500 font-medium">SL: {{ $key + 1 }}</span>
            <span class="text-sm text-orange-400">{{ $package->created_at->format('d M Y') }}</span>
        </div>

        <div class="flex justify-between items-center mt-2">
            <!-- Package Image -->
            <div>
                @if($package->image_icon)
                <img src="{{ asset('storage/'.$package->image_icon) }}" alt="{{ $package->name }}"
                     class="w-20 h-20 object-cover rounded-xl shadow-sm">
                @else
                <div class="w-20 h-20 bg-orange-100 flex items-center justify-center rounded-xl text-orange-400 shadow-inner">
                    No Image
                </div>
                @endif
            </div>

            <!-- Package Info -->
            <div class="flex-1 ml-4">
                <h3 class="text-orange-900 font-semibold text-sm">{{ $package->name }}</h3>
                @if($package->price)
                <p class="text-orange-700 font-medium text-sm">Price: ${{ $package->price }}</p>
                @endif
                @if($package->description)
                <p class="text-orange-500 text-xs truncate">{{ Str::limit($package->description, 80) }}</p>
                @endif
            </div>
        </div>

        <!-- Optional Status Badge -->
        @if($package->status)
        <div class="flex justify-start items-center gap-2 mt-2">
            <span class="px-2 py-1 rounded-full text-xs font-semibold
                 @if($package->status === 'active') bg-orange-100 text-orange-800
                 @else bg-gray-100 text-gray-600
                 @endif">
                 {{ ucfirst($package->status) }}
            </span>
        </div>
        @endif

        <!-- View Package Button -->
        <a href="{{ route('app.package.show', $package->id) }}"
           class="mt-2 px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg hover:bg-orange-700 transition text-center">
           View Package
        </a>
    </div>
    @endforeach

    @if($packages->isEmpty())
        <div class="bg-white shadow-lg rounded-2xl border border-orange-100 p-6 text-center text-orange-500">
            No packages available.
        </div>
    @endif

</main>
</body>
</html>