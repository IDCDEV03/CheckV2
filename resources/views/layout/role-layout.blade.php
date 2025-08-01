@switch(Auth::user()->role->value)
    @case('admin')
        @extends('layout.LayoutAdmin')
        @break
    @case('manager')
        @extends('layout.manager')
        @break
    @case('agency')
        @extends('layout.agency')
        @break
    @default
        @extends('layout.app')
@endswitch