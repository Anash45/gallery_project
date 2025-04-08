<div class="col">
    <a href="/image/{{ $item->slug }}" class="project-one__single">
        <div class="project-one__img-box">
            <div class="project-one__img">
                <img src="{{ $item->database->base_url }}upload/thumbs/{{ $item->image_thumb }}" loading="lazy"
                    alt="{{ $item->image_name }}" class="w-100">
            </div>
        </div>
    </a>
</div>