<section class="services" id="services">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="eyebrow">{{ $content['services']['fields']['field_1'] }}</div>
        <h2 style="margin-top:16px">{!! nl2br(e($content['services']['fields']['field_2'])) !!}</h2>
      </div>
      <p>{{ $content['services']['fields']['field_3'] }}</p>
    </div>

    <div class="service-list">
      @foreach ($content['services']['groups']['items'] as $item)
<div class="service-row"><div class="num">{{ sprintf('%02d', $loop->iteration) }}</div><h3>{{ $item['field_1'] }}</h3><p>{{ $item['field_2'] }}</p><span>↗</span></div>@endforeach

      
      
      
      
    </div>
  </div>
</section>
