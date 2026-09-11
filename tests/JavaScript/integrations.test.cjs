const { test } = require('node:test');
const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const vm = require('node:vm');
const code = readFileSync('public/assets/ft/js/integrations.js', 'utf8');

function setup(overrides = {}, storedChoice = null) {
    const scripts = [], listeners = {}, storage = new Map();
    if (storedChoice) storage.set('ft-marketing-consent', storedChoice);
    const settings = { consent: 'ask', ga4: 'G-TEST1234', google_ads: 'AW-123456', ads_label: 'test_label', meta_pixel: '123456789', gtm: '', clarity: '', adsense: '', ...overrides };
    const elements = Object.fromEntries(['marketingSettings', 'trackingConsent', 'trackingPreferences', 'consentAccept', 'consentReject'].map(id => [id, {
        hidden: true, dataset: {}, focus() {}, addEventListener(event, callback) { listeners[id] = callback; },
    }]));
    elements.marketingSettings.dataset = { settings: JSON.stringify(settings), lead: 'quote-99' };
    const window = { location: { reload() { window.reloaded = true; } } };
    const context = { window, document: {
        getElementById(id) { return elements[id]; },
        createElement() { return {}; },
        head: { append(node) { scripts.push(node); } },
        querySelectorAll() { return [{}]; },
    }, localStorage: { getItem(key) { return storage.get(key) ?? null; }, setItem(key, value) { storage.set(key, value); } } };
    vm.runInNewContext(code, context);
    return { scripts, elements, window, listeners, storage };
}

test('tracking waits for consent and sends configured lead events only once', () => {
    const app = setup();
    assert.equal(app.scripts.length, 0);
    assert.equal(app.elements.trackingConsent.hidden, false);
    app.listeners.consentAccept();
    assert.equal(app.scripts.length, 2);
    assert.equal(app.storage.get('ft-marketing-consent'), 'yes');
    assert.equal(app.elements.trackingConsent.hidden, true);
    const events = app.window.dataLayer.map(args => Array.from(args));
    assert.ok(events.some(event => event[1] === 'generate_lead'));
    assert.ok(events.some(event => event[1] === 'conversion' && event[2].send_to === 'AW-123456/test_label' && event[2].transaction_id === 'quote-99'));
    assert.ok(app.window.fbq.queue.some(args => args[1] === 'Lead' && args[3].eventID === 'quote-99'));
    app.listeners.consentAccept();
    assert.equal(app.scripts.length, 2);
});

test('rejection persists without loading tags, and withdrawal reloads the page', () => {
    const rejected = setup({}, 'no');
    assert.equal(rejected.scripts.length, 0);
    assert.equal(rejected.elements.trackingConsent.hidden, true);
    rejected.listeners.trackingPreferences();
    assert.equal(rejected.elements.trackingConsent.hidden, false);
    rejected.listeners.consentReject();
    assert.equal(rejected.scripts.length, 0);
    const accepted = setup({}, 'yes');
    accepted.listeners.consentReject();
    assert.equal(accepted.window.reloaded, true);
    assert.equal(accepted.storage.get('ft-marketing-consent'), 'no');
});

test('GTM, Clarity and AdSense initialize from configured IDs after consent', () => {
    const app = setup({ ga4: '', google_ads: '', meta_pixel: '', gtm: 'GTM-TEST123', clarity: 'abc123', adsense: 'ca-pub-1234567890123456', ad_position: 'after_hero', ad_slot: '12345' });
    assert.equal(app.scripts.length, 0);
    app.listeners.consentAccept();
    assert.equal(app.scripts.length, 3);
    assert.ok(app.scripts.some(tag => tag.src.includes('GTM-TEST123')));
    assert.ok(app.scripts.some(tag => tag.src.includes('clarity.ms/tag/abc123')));
    assert.equal(app.window.adsbygoogle.length, 1);
    assert.ok(app.window.dataLayer.some(event => event.event === 'quotation_submitted'));
});
