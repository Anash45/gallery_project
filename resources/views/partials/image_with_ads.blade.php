@php
    $adInsertInterval = $adInterval ?? 6;
    $adIndex = 0;
    $adsArray = $recentAds ?? []; // Get the 'ads' array
    $adsCount = count($adsArray);
@endphp

@foreach($recentImages as $index => $item)
    @include('partials.image_card', ['item' => $item])

    @if(($index + 1) % $adInsertInterval === 0 && $adsCount > 0)
        @php
            $ad = $adsArray[$adIndex % $adsCount];
            $adIndex++;
        @endphp
        @include('partials.ad_card', ['ad' => $ad])
    @endif
@endforeach
