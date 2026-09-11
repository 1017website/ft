<section class="gallery" id="gallery">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="eyebrow">{{ $content['gallery']['fields']['field_1'] }}</div>
        <h2 style="margin-top:16px">{!! nl2br(e($content['gallery']['fields']['field_2'])) !!}</h2>
      </div>
      <p>{{ $content['gallery']['fields']['field_3'] }}</p>
    </div>

    <div class="gallery-tabs">
      <button class="gallery-tab active" data-gallery="photos">{{ $content['gallery']['fields']['field_4'] }}</button>
      <button class="gallery-tab" data-gallery="videos">{{ $content['gallery']['fields']['field_5'] }}</button>
    </div>

    <div class="gallery-panel active" id="photos">
      <div class="photo-grid">
        @foreach (array_slice($content['gallery']['groups']['photos'], 0, (int)$content['gallery']['fields']['photo_limit'] ?: null) as $item)
<article class="photo-item"><img src="{{ asset($item['field_1']) }}" alt="{{ $item['field_2'] }}"><div class="photo-info"><small>{{ $item['field_3'] }}</small><strong>{{ $item['field_4'] }}</strong></div></article>@endforeach

        
        
        
        
      </div>
    </div>

    <div class="gallery-panel" id="videos">
      <div class="video-grid">
        @foreach (array_slice($content['gallery']['groups']['videos'], 0, (int)$content['gallery']['fields']['video_limit'] ?: null) as $item)
<article class="video-card" data-title="{{ $item['field_4'] }}" data-poster="{{ asset($item['field_1']) }}" data-video="{{ $item['field_5'] }}"><img src="{{ asset($item['field_1']) }}" alt="{{ $item['field_2'] }}"><div class="play">▶</div><div class="video-info"><small>{{ $item['field_3'] }}</small><strong>{{ $item['field_4'] }}</strong></div></article>@endforeach

        
        
      </div>
    </div>
  </div>
</section>
