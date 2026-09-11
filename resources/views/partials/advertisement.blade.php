@if($content['integrations']['fields']['adsense'] && $content['integrations']['fields']['ad_slot'])
<aside class="ad-placement container" aria-label="Iklan"><small>Iklan</small>
@if(!empty($cmsPreview))<div style="padding:40px;text-align:center;background:#f0f0ec;border:1px dashed #999">Area iklan AdSense</div>
@else<ins class="adsbygoogle" style="display:block" data-ad-client="{{ $content['integrations']['fields']['adsense'] }}" data-ad-slot="{{ $content['integrations']['fields']['ad_slot'] }}" data-ad-format="auto" data-full-width-responsive="true"></ins>@endif
</aside>
@endif
