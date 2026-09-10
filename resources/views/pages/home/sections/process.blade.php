<section class="process" id="process">
  <div class="container process-grid">
    <div>
      <div class="eyebrow">{{ $content['process']['fields']['field_1'] }}</div>
      <h2 style="margin-top:16px">{!! nl2br(e($content['process']['fields']['field_2'])) !!}</h2>
    </div>
    <div class="steps">
      @foreach ($content['process']['groups']['items'] as $item)
<div class="step"><div class="num">{{ sprintf('%02d', $loop->iteration) }}</div><div><h3>{{ $item['field_1'] }}</h3><p>{{ $item['field_2'] }}</p></div><span>{{ $item['field_3'] }}</span></div>@endforeach

      
      
      
      
    </div>
  </div>
</section>
