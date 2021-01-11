@if($breadcrumb)
    <ol class="breadcrumb">
        @foreach($breadcrumb->getItems() as $item)
            <li class="breadcrumb-item">
                @if($item->hasUrl())
                    <a href="{{ $item->getUrl() }}">{{ $item->getAnchor() }}</a>
                @else
                    {{ $item->getAnchor() }}
                @endif
            </li>
        @endforeach
    </ol>
@endif
