<div class="col">
    <a href="{{ $ad['link_url'] }}" class="ad_single" target="_blank" rel="noopener" platform="{{ $ad['type'] }}">
        <div class="ad_img-box">
            <div class="ad_icon-box">
                <img src="{{ asset('/assets/images/ad.png') }}" class="ad_icon" />
            </div>
            <div class="ad_img">
                <img src="{{ $ad['image_link'] }}" loading="lazy" alt="{{ $ad['title'] }}" class="w-100">
            </div>
            <div class="ad_content">
                <h5 class="ad_title text-white"><span>{{ $ad['title'] }}</span></h5>
                <p class="ad_description">{{ $ad['description'] }}</p>
            </div>
        </div>
    </a>
</div>
