@if ($menu->children->count() == 0)
    <li class="{{ url($menu->action_url) == url()->current()?'active':'' }}">
        <a href="{{($menu->action_url == '#')?'#':url($menu->action_url)}}" title="">{!!$menu->icon!!} <span>{{$menu->name}}</span></a>
    </li>
@else
    <li class="">
        <a href="{{($menu->action_url == '#')?'#':url($menu->action_url)}}" title="">{!!$menu->icon!!} <span>{{$menu->name}}</span></a>
        <ul class="submenu2">
            @foreach($menu->children as $menu)
                @if(in_array(collect($menu->actions)->firstWhere('action_type', 'READ')['id'], collect(Auth::user()->userGroup->menuActions)->pluck('id')->toArray()))
                    @include('layouts.menu2', $menu)
                @else
                    @include('layouts.menu', $menu)
                @endif
            @endforeach
        </ul>
    </li>
@endif