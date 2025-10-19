@if ($menu->children->count() == 0)
    <div class="row menu-no-child">
        <div class="col-md-12">
            {!! $menu->icon !!} {{ $menu->name }}
            <small>{{ $menu->description }}</small>
            
            @foreach($menu->actions as $a)
            <div class="checkbox">
                <label><input name="action[]" type="checkbox" id="checkbox-{{ $a->id }}" value="{{ $a->id }}">{{ $a->action_type }}</label>
            </div>
            @endforeach
            
        </div>
    </div>
@else
    <div class="row menu-parent">
        <div class="col-md-12">
            {!! $menu->icon !!} {{ $menu->name }}
            <small>{{ $menu->description }}</small>
            
            @foreach($menu->actions as $a)
            <div class="checkbox">
                <label><input name="action[]" type="checkbox" id="checkbox-{{ $a->id }}" value="{{ $a->id }}">{{ $a->action_type }}</label>
            </div>
            @endforeach
            
        </div>
        
        <div class="col-md-12">
            <div>
                @foreach($menu->children as $menu)
                    @include('pages.user-group.privileges-menu-item', $menu)
                @endforeach
            </div>
        </div>
    </div>
@endif