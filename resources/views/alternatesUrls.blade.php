@foreach($urls as $locale => $url)
    <link rel="alternate" href="{{ $url }}" hreflang="{{ $locale }}"/>
@endforeach
