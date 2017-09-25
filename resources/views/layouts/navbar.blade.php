<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/VirtualExbo/public">VirtualExbo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            @if(Auth::guest() || Auth::user()->hasRole('normalUser'))
            <li class="nav-item"><a class="nav-link" href="/VirtualExbo/public/event">Events</a></li>
            @elseif(Auth::user()->hasRole('Admin'))
            <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" role="button" aria-expanded="false">My Events<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li class="nav-item">
                        <a class="dropdown-item" href="/VirtualExbo/public/myEvents/create">Create a new event</a>
                        <a class="dropdown-item" href="/VirtualExbo/public/myEvents">Show my events</a>
                        <a class="dropdown-item" href="/VirtualExbo/public/stand/create">Create Stand</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
        <ul class="navbar-nav navbar-right">
            <!-- Authentication Links -->
            @if (Auth::guest())
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
            @else
            <li class="dropdown nav-item">
                <a class="nav-link dropdown-toggle" href="#"  data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ (Auth::user()->name)." ".(Auth::user()->roles->pluck('name'))}} <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">{{ csrf_field() }}</form>
                    </li>
                    
                </ul>
            </li>
            
            @endif
        </ul>
    </div>
</nav>