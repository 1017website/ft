<section class="network" id="network">
  <div class="container network-grid">
    <div>
      <div class="eyebrow" style="color:#e4c476">{{ $content['network']['fields']['field_1'] }}</div>
      <h2 style="margin-top:16px;color:#fff">{!! nl2br(e($content['network']['fields']['field_2'])) !!}</h2>
      <p>{{ $content['network']['fields']['field_3'] }}</p>
      <div class="city-list" id="cityList">
        @foreach ($content['network']['groups']['cities'] as $item)
<button data-city="{{ $item['field_2'] }}" data-region="{{ $item['field_3'] }}" data-lat="{{ $item['field_4'] }}" data-lng="{{ $item['field_5'] }}">{{ $item['field_1'] }}</button>@endforeach

        
        
        
      </div>
    </div>
    <div id="map"></div>
  </div>
</section>
