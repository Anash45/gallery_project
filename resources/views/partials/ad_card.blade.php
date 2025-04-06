<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
    <a href="{{ $ad->link }}" class="ad_single">
        <div class="ad_img-box">
            <div class="ad_icon-box">
                <img src="{{ asset("/assets/images/ad.png") }}" class="ad_icon" />
            </div>
            <div class="ad_img">
                <img src="{{ $ad->image_path }}" loading="lazy" alt="{{ $ad->title }}" class="w-100">
            </div>
            <div class="ad_content">
                <h5 class="ad_title text-white"><span>{{ $ad->title }}</span></h5>
                <p class="ad_description">{{ $ad->description }}</p>
            </div>
        </div>
    </a>
</div>