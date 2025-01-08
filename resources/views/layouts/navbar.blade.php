@if(Auth::user()->role === 'admin')
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('milestones.*') ? 'active' : '' }}" 
           href="{{ route('milestones.index') }}">
            Milestones
        </a>
    </li>
@endif 