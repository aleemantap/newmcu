@if ($menu->children->count() == 0)
    <li class="dd-item" data-id="{{$menu->id}}">
        <div class="dd-handle">
            {!! $menu->icon !!} {{ $menu->name }}

            <!-- Button -->
            <div class="btn-container">
                <button class="btn btn-warning btn-xs btn-edit" data-id="{{$menu->id}}"><i class="fa fa-fw fa-pencil"></i> @lang('general.edit')</button>
                <button class="btn btn-danger btn-xs btn-delete" data-id="{{$menu->id}}"><i class="fa fa-fw fa-trash"></i> @lang('general.delete')</button>
            </div>
            <!-- /Button -->
        </div>
    </li>
@else
    <li class="dd-item" data-id="{{$menu->id}}">
        <div class="dd-handle">
            {!! $menu->icon !!} {{ $menu->name }}

            <!-- Button -->
            <div class="btn-container pull-right">
                <button class="btn btn-warning btn-xs btn-edit" data-id="{{$menu->id}}"><i class="fa fa-fw fa-pencil"></i> @lang('general.edit')</button>
                <button class="btn btn-danger btn-xs btn-delete" data-id="{{$menu->id}}"><i class="fa fa-fw fa-trash"></i> @lang('general.delete')</button>
            </div>
            <!-- /Button -->

        </div>

            <ol>
                @foreach($menu->children as $menu)
                @include('pages.menu.menu', $menu)
                @endforeach
            </ol>

    </li>
@endif
