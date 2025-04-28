<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($items as $item)
            <li class="breadcrumb-item {{ is_null($item['url']) ? 'active' : '' }}" {{ is_null($item['url']) ? 'aria-current="page"' : '' }} >
                @if($item['url'])
                    <a href="{{ $item['url'] }}" class="breadcrumd">{{ $item['title'] }}</a>
                @else
                    {{ $item['title'] }}
                @endif
            </li>
        @endforeach
    </ol>
</nav>
