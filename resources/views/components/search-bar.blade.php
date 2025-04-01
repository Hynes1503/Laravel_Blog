<form method="GET" action="{{ route('search') }}" class="relative w-full w-[700px] mr-10">
    <div class="relative">
        <input type="text" name="query" placeholder="Search..."
            class="px-4 py-2 border rounded-lg w-full pr-16 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <button type="submit" class="absolute inset-y-0 right-4 px-4 py-1 bg-transparent text-gray-600 hover:text-black">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
</form>
