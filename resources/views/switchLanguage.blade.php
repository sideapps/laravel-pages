<ul>
    @foreach($urls as $locale => $url)
        <li><a href="{{ $url }}">{{ $locale }}</a></li>
    @endforeach
</ul>
