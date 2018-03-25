@php $isButton = !isset($class) || $class === 'btn'; @endphp

<ul class="list-inline no-margin-bottom">
    <li>
        <a class="{{ $isButton ? 'btn btn-xs bg-navy' : 'inline-show' }}"
           href="{{ route(implode('.', [$resource, 'show']), $id)  }}">
           <i class="fa fa-search"></i> Show
        </a>
    </li>
    @if(Sentinel::hasAccess('members.update'))
        <li>
            <a class="{{ $isButton ? 'btn btn-xs bg-olive' : 'inline-edit' }}"
            href="{{ route(implode('.', [$resource, 'edit']), $id)  }}">            
                <i class="fa fa-pencil-square-o"></i> Edit
            </a>
        </li>
    @endif
    @if(Sentinel::hasAccess('members.delete'))
        <li>       
            <a href="{{ route(implode('.', [$resource, 'delete']), $id)  }}" class="{{ $isButton ? 'btn btn-xs btn-danger destroy' : 'inline-delete' }}"
                    onclick="return confirm('Confirm Delete?')">
                <i class="fa fa-trash"></i> Delete
            </a>       
        </li>
    @endif
</ul>