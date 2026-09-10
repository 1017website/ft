<section class="about" id="about">
  <div class="container about-grid">
    <div>
      <div class="eyebrow">{{ $content['about']['fields']['field_1'] }}</div>
      <h2 style="margin-top:16px">{!! nl2br(e($content['about']['fields']['field_2'])) !!}</h2>
    </div>
    <div class="about-copy">
      <p>{{ $content['about']['fields']['field_3'] }}</p>
      <div class="features">
        @foreach ($content['about']['groups']['features'] as $item)
<div class="feature"><strong>{{ $item['field_1'] }}</strong><span>{{ $item['field_2'] }}</span></div>@endforeach

        
        
        
      </div>
    </div>
  </div>
</section>
