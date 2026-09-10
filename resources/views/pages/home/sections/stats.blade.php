<section class="stats">
  <div class="container stats-grid">
    @foreach ($content['stats']['groups']['items'] as $item)
<div class="stat"><strong>{{ $item['field_1'] }}</strong><span>{{ $item['field_2'] }}</span></div>@endforeach

    
    
    
  </div>
</section>
