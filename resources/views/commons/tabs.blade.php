<ul class="nav nav-tabs nav-justified mt-5 mb-2">
    <li class="nav-item nav-link h3 {{ Request::is('/') ? 'active' : '' }}"><a href="./" class="">Users</a></li>
    <li class="nav-item nav-link h3 {{ Request::is('movies') ? 'active' : '' }}"><a href="{{ route('movies.index') }}" class="">Movies</a></li>
</ul>
