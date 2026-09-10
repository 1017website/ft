<section class="hero">
  <img src="{{ asset($content['hero']['fields']['field_1']) }}" alt="{{ $content['hero']['fields']['field_2'] }}">
  <div class="hero-badges">
    <div class="badge">{{ $content['hero']['fields']['field_3'] }}</div>
    <div class="badge">{{ $content['hero']['fields']['field_4'] }}</div>
  </div>

  <div class="hero-content">
    <div class="container hero-grid">
      <div>
        <div class="eyebrow" style="color:#e5c878">{{ $content['hero']['fields']['field_5'] }}</div>
        <h1>{{ $content['hero']['fields']['field_6'] }}<br><span>{{ $content['hero']['fields']['field_7'] }}</span></h1>
      </div>
      <div class="hero-copy">
        <p>{{ $content['hero']['fields']['field_8'] }}</p>
        <div class="actions">
          <button class="btn gold openQuote">{{ $content['hero']['fields']['field_9'] }}</button>
          <a href="#fleet" class="btn">{{ $content['hero']['fields']['field_10'] }}</a>
        </div>
      </div>
    </div>
  </div>
</section>
