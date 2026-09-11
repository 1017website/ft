(() => {
    const element = document.getElementById('marketingSettings');
    if (!element) return;
    const config = JSON.parse(element.dataset.settings);
    let loaded = false;
    const script = (src) => { const node = document.createElement('script'); node.src = src; node.async = true; document.head.append(node); };
    function activate() {
        if (loaded) return;
        loaded = true;
        const lead = element.dataset.lead;
        if (config.gtm || config.ga4 || config.google_ads) window.dataLayer = window.dataLayer || [];
        if (config.gtm) {
            window.dataLayer.push({'gtm.start': Date.now(), event:'gtm.js'});
            script('https://www.googletagmanager.com/gtm.js?id='+encodeURIComponent(config.gtm));
        }
        if (config.ga4 || config.google_ads) {
            window.gtag = function(){window.dataLayer.push(arguments);};
            window.gtag('js', new Date());
            script('https://www.googletagmanager.com/gtag/js?id='+encodeURIComponent(config.ga4 || config.google_ads));
            if (config.ga4) window.gtag('config', config.ga4);
            if (config.google_ads) window.gtag('config', config.google_ads);
            if (lead && config.ga4) window.gtag('event','generate_lead',{send_to:config.ga4});
            if (lead && config.google_ads && config.ads_label) window.gtag('event','conversion',{send_to:config.google_ads+'/'+config.ads_label, transaction_id:lead});
        }
        if (config.meta_pixel) {
            if (!window.fbq) {
                const fbq = window.fbq = function(){fbq.callMethod ? fbq.callMethod.apply(fbq,arguments) : fbq.queue.push(arguments);};
                window._fbq = window._fbq || fbq; fbq.push=fbq; fbq.loaded=true; fbq.version='2.0'; fbq.queue=[];
                script('https://connect.facebook.net/en_US/fbevents.js');
            }
            window.fbq('init',config.meta_pixel); window.fbq('track','PageView');
            if (lead) window.fbq('track','Lead',{}, {eventID:lead});
        }
        if (config.clarity) {
            window.clarity = window.clarity || function(){(window.clarity.q=window.clarity.q||[]).push(arguments);};
            script('https://www.clarity.ms/tag/'+encodeURIComponent(config.clarity));
        }
        if (config.adsense && config.ad_position !== 'off' && config.ad_slot) {
            const tag = document.createElement('script'); tag.async=true; tag.crossOrigin='anonymous';
            tag.src='https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client='+encodeURIComponent(config.adsense); document.head.append(tag);
            document.querySelectorAll('ins.adsbygoogle').forEach(() => {(window.adsbygoogle=window.adsbygoogle||[]).push({});});
        }
        if (lead && config.gtm) window.dataLayer.push({event:'quotation_submitted',transaction_id:lead});
    }
    const banner=document.getElementById('trackingConsent');
    const preferences=document.getElementById('trackingPreferences');
    function remember(choice) { try { localStorage.setItem('ft-marketing-consent',choice); } catch (_) {} }
    function choice(){ try { return localStorage.getItem('ft-marketing-consent'); } catch (_) { return null; } }
    document.getElementById('consentAccept').addEventListener('click',()=>{remember('yes');banner.hidden=true;activate();});
    document.getElementById('consentReject').addEventListener('click',()=>{remember('no');banner.hidden=true;if(loaded)window.location.reload();});
    preferences.addEventListener('click',()=>{banner.hidden=false;document.getElementById('consentReject').focus();});
    if (config.consent === 'immediate') activate();
    else {preferences.hidden=false;if(choice()==='yes')activate();else if(choice()!=='no')banner.hidden=false;}
})();
