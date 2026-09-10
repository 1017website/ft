<section class="fleet" id="fleet">
  <div class="container">
    <div class="section-head">
      <div>
        <div class="eyebrow">{{ $content['fleet']['fields']['field_1'] }}</div>
        <h2 style="margin-top:16px">{!! nl2br(e($content['fleet']['fields']['field_2'])) !!}</h2>
      </div>
      <p>{{ $content['fleet']['fields']['field_3'] }}</p>
    </div>

    <div class="fleet-grid">
      <article class="fleet-main">
        <img src="{{ asset($content['fleet']['fields']['field_4']) }}" alt="{{ $content['fleet']['fields']['field_5'] }}">
        <div class="fleet-caption"><small>{{ $content['fleet']['fields']['field_6'] }}</small><h3>{{ $content['fleet']['fields']['field_7'] }}</h3></div>
      </article>
      <div class="fleet-side">
        @foreach ($content['fleet']['groups']['items'] as $item)
<article class="fleet-card"><img src="{{ asset($item['field_1']) }}" alt="{{ $item['field_2'] }}"><div class="fleet-caption"><small>{{ $item['field_3'] }}</small><h3>{{ $item['field_4'] }}</h3></div></article>@endforeach

        
        
        
      </div>
    </div>
  </div>
</section>
