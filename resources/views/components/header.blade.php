<header class="w-full flex justify-between px-3 items-center h-16 border-b-2 border-b-black">
    <nav class="flex gap-5 items-center">
        <h2 class="text-lg">Wheely good cars!</h2>
        <a href="{{ route("cars.index") }}">Alle auto's</a>
        <a href="{{ route("cars.myListings") }}">Mijn aanbod</a>
        <a href="{{ route("cars.create") }}">Aanbod plaatsen</a>
    </nav>
    @if (Auth::check())
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="px-4 py-2 hover:cursor-pointer">Uitloggen</button>
    </form>
    @else
    <a href="{{ route('login') }}" class="px-4 py-2">Login</a>
    @endif
</header>