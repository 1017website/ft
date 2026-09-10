<section class="cta">
  <div class="container cta-box">
    <img src="{{ asset($content['cta']['fields']['field_1']) }}" alt="{{ $content['cta']['fields']['field_2'] }}">
    <div class="cta-content">
      <div class="eyebrow" style="color:#e5c878">{{ $content['cta']['fields']['field_3'] }}</div>
      <h2 style="margin-top:16px">{!! nl2br(e($content['cta']['fields']['field_4'])) !!}</h2>
      <p>{{ $content['cta']['fields']['field_5'] }}</p>
      <button class="btn gold openQuote" style="margin-top:18px">{{ $content['cta']['fields']['field_6'] }}</button>
    </div>
  </div>
</section>
