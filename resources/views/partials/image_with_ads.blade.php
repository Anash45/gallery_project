@php
    $adInsertInterval = 5;
    $adIndex = 0;
    $adsCount = $recentAds->count();
@endphp

@foreach($recentImages as $index => $item)
    @include('partials.image_card', ['item' => $item])

    @if(($index + 1) % $adInsertInterval === 0 && $adsCount > 0)
        @php
            $ad = $recentAds[$adIndex % $adsCount];
            $adIndex++;
        @endphp
        @include('partials.ad_card', ['ad' => $ad])
    @endif
@endforeach
