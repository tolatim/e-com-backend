<aside class="w-64 h-screen sticky top-0 bg-slate-800 text-white flex flex-col flex-shrink-0">

    <div class="p-6 border-b border-slate-700">
        <h1 class="text-2xl font-bold">
            Admin
        </h1>
    </div>

    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

        <a href="{{ route('admin.dashboard') }}"
           class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700' }}">
            Categories
        </a>

        <a href="{{route('admin.products.index')}}"
           class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700' }}">
            Products
        </a>

        <a href="{{ route('admin.orders.index') }}"
           class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700' }}">
            Orders
        </a>

        <a href="{{route('admin.users.index')}}"
           class="block rounded-lg px-4 py-2 transition {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white' : 'hover:bg-slate-700' }}">
            Users
        </a>

    </nav>

    <div class="p-4 border-t border-slate-700">

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="w-full rounded-lg bg-red-600 py-2 hover:bg-red-700 transition">
                Logout
            </button>
        </form>

    </div>

</aside>