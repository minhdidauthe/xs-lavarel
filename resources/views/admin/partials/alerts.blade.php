@if (session('success'))
    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-check-circle text-green-500"></i>
        <p class="text-sm text-green-700">{{ session('success') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-circle text-red-500"></i>
        <p class="text-sm text-red-700">{{ session('error') }}</p>
    </div>
@endif

@if (session('warning'))
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl flex items-center gap-3">
        <i class="fas fa-exclamation-triangle text-yellow-500"></i>
        <p class="text-sm text-yellow-700">{{ session('warning') }}</p>
    </div>
@endif
