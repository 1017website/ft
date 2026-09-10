<div class="modal {{ $errors->any() || session('quotation_success') ? 'show' : '' }}" id="quoteModal" role="dialog" aria-modal="true" aria-labelledby="quoteTitle">
  <div class="modal-box">
    <button class="close" id="closeModal">×</button>
    <div class="eyebrow">Request Quotation</div>
    <h3 id="quoteTitle" style="font-size:36px;margin-top:10px">Tell us about your shipment.</h3>
    @if(session('quotation_success'))<p role="status">{{ session('quotation_success') }}</p>@endif
    @if($errors->any())<ul role="alert">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form class="form" method="post" action="{{ route('quotation.store') }}">
      @csrf
      <input name="company" placeholder="Company Name" aria-label="Company Name" value="{{ old('company') }}" maxlength="255" required>
      <input name="contact" placeholder="Contact Person" aria-label="Contact Person" value="{{ old('contact') }}" maxlength="255" required>
      <input name="email" type="email" placeholder="Email" aria-label="Email" value="{{ old('email') }}" maxlength="255" required>
      <input name="phone" type="tel" placeholder="Phone / WhatsApp" aria-label="Phone / WhatsApp" value="{{ old('phone') }}" maxlength="40" required>
      <input name="pickup" placeholder="Pickup City" aria-label="Pickup City" value="{{ old('pickup') }}" maxlength="255" required>
      <input name="destination" placeholder="Destination City" aria-label="Destination City" value="{{ old('destination') }}" maxlength="255" required>
      <select name="fleet" aria-label="Select Fleet" required>
        <option value="">Select Fleet</option>
        @foreach(array_merge([$content['fleet']['fields']['field_7']], array_column($content['fleet']['groups']['items'], 'field_4')) as $fleetName)
        <option value="{{ $fleetName }}" @selected(old('fleet') === $fleetName)>{{ $fleetName }}</option>
        @endforeach
      </select>
      <input name="weight" placeholder="Cargo Weight / Volume" aria-label="Cargo Weight / Volume" value="{{ old('weight') }}" maxlength="255">
      <textarea name="details" class="full" placeholder="Shipment details" aria-label="Shipment details" maxlength="5000">{{ old('details') }}</textarea>
      <button class="btn dark full" type="submit">Send Request</button>
    </form>
  </div>
</div>
