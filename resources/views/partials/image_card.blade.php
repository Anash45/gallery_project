<div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
    <div class="project-one__single">
        <div class="project-one__img-box">
            <div class="project-one__img">
                <img src="{{ $item->database->base_url }}upload/thumbs/{{ $item->image_thumb }}" loading="lazy"
                    alt="{{ $item->image_name }}" class="w-100">
            </div>
            <div class="project-one__content">
                <div class="project-one__title-box">
                    <h3 class="project-one__title"><a href="/image/{{ $item->slug }}">{{ $item->image_name }}</a></h3>
                </div>
            </div>
        </div>
    </div>
</div>