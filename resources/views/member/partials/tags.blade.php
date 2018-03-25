
<ul class="list-inline no-margin-bottom">
    <li>
        @foreach($tags as $key)
            @if(!empty($key->tag))
                <a href="{{url('tag/'.$key->tag->id.'/show')}}">{{$key->tag->name}}</a>
            @endif
        @endforeach
    </li>
</ul>
