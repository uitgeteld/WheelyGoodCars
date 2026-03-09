<header class="w-full flex justify-between px-3 items-center h-16 border-b-2 border-b-black">
    <nav class="flex gap-5 items-center">
        <h2 class="text-xl">Wheely good cars!</h2>
        <a href="">Alle auto's</a>
        <a href="">Mijn aanbod</a>
        <a href="">Aanbod plaatsen</a>
    </nav>
    @if (Auth::check())
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="px-4 py-2">Uitloggen</button>
    </form>
    @else
    <a href="{{ route('login') }}" class="px-4 py-2">Login</a>
    @endif
</header>