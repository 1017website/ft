const editor = document.querySelector('[data-editor]');
let dirty = false;
function markDirty() {
    dirty = true;
    editor?.classList.add('is-dirty');
    const status = document.querySelector('[data-save-status]');
    if (status) status.textContent = 'Ada perubahan yang belum disimpan.';
}
editor?.addEventListener('input', markDirty);
editor?.addEventListener('change', markDirty);
window.addEventListener('beforeunload', event => { if (dirty) { event.preventDefault(); event.returnValue = ''; } });
editor?.addEventListener('submit', () => {
    dirty = false;
    const button = editor.querySelector('button[type="submit"]');
    button.disabled = true;
    button.textContent = 'Menyimpan…';
});
function refresh(repeater) {
    const items = [...repeater.querySelector('[data-items]').children];
    repeater.querySelector('[data-empty]').hidden = items.length > 0;
    repeater.querySelector('[data-item-count]').textContent = items.length;
    repeater.querySelector('[data-add]').disabled = items.length >= 40;
    items.forEach((item, index) => {
        item.querySelector('[data-number]').textContent = index + 1;
        item.querySelector('[data-move="up"]').disabled = index === 0;
        item.querySelector('[data-move="down"]').disabled = index === items.length - 1;
        item.querySelectorAll('[name]').forEach(input => { input.name = input.name.replace(/(groups\[[^\]]+\]\[)[^\]]+(\])/, `$1${index}$2`); });
    });
}
document.querySelectorAll('[data-repeater]').forEach(repeater => {
    let serial = repeater.querySelector('[data-items]').children.length;
    let removed = null;
    const undo = document.createElement('button');
    undo.type = 'button'; undo.className = 'secondary'; undo.textContent = 'Batalkan penghapusan terakhir'; undo.hidden = true;
    repeater.querySelector('[data-add]').after(undo);
    undo.addEventListener('click', () => {
        if (!removed) return;
        const items = repeater.querySelector('[data-items]');
        if (items.children.length >= 40) return;
        items.insertBefore(removed.item, items.children[removed.index] || null);
        removed = null; undo.hidden = true; refresh(repeater); markDirty();
    });
    refresh(repeater);
    repeater.addEventListener('click', event => {
        const button = event.target.closest('button');
        if (!button) return;
        const items = repeater.querySelector('[data-items]');
        if (button.hasAttribute('data-add') && items.children.length < 40) {
            const fragment = repeater.querySelector('template').content.cloneNode(true);
            const unique = `new${++serial}`;
            fragment.querySelectorAll('[name],[id],[for]').forEach(element => {
                ['name','id','for'].forEach(attr => { if (element.hasAttribute(attr)) element.setAttribute(attr, element.getAttribute(attr).replaceAll('__INDEX__', unique)); });
            });
            items.append(fragment);
            items.lastElementChild.querySelector('input:not([type=hidden]),textarea')?.focus({preventScroll:true});
            items.lastElementChild.scrollIntoView({block:'start',behavior:window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'instant' : 'smooth'});
        } else if (button.hasAttribute('data-remove')) {
            const item = button.closest('[data-item]');
            removed = {item, index: [...items.children].indexOf(item)};
            item.remove(); undo.hidden = false;
        } else if (button.hasAttribute('data-move')) {
            const item = button.closest('[data-item]');
            if (button.dataset.move === 'up' && item.previousElementSibling) items.insertBefore(item, item.previousElementSibling);
            if (button.dataset.move === 'down' && item.nextElementSibling) items.insertBefore(item.nextElementSibling, item);
        } else return;
        markDirty(); refresh(repeater);
    });
});
function resetUpload(upload) {
    const input = upload.querySelector('[data-image-input]');
    const preview = upload.querySelector('.image-preview');
    input.value = '';
    if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
    delete preview.dataset.objectUrl;
    if (preview.dataset.original) preview.src = preview.dataset.original;
    else preview.removeAttribute('src');
    preview.hidden = !preview.dataset.original;
    upload.querySelector('[data-preview-wrap]').hidden = !preview.dataset.original;
    upload.querySelector('[data-upload-reset]').hidden = true;
    upload.querySelector('[data-preview-badge]').textContent = 'Gambar saat ini';
    upload.querySelector('[data-file-info]').textContent = preview.dataset.original ? 'Gambar tersimpan. Pilih file untuk menggantinya.' : 'Belum ada gambar yang dipilih.';
    upload.querySelector('[data-upload-error]').hidden = true;
}
document.addEventListener('change', event => {
    const input = event.target;
    if (!input.matches('[data-image-input]')) return;
    const file = input.files[0];
    if (!file) return;
    const upload = input.closest('[data-upload]');
    if (file.size > 5 * 1024 * 1024 || !['image/jpeg','image/png','image/webp'].includes(file.type)) {
        resetUpload(upload);
        const error = upload.querySelector('[data-upload-error]');
        error.textContent = file.size > 5 * 1024 * 1024 ? 'Gambar terlalu besar. Pilih file maksimal 5 MB.' : 'Format tidak didukung. Pilih JPG, PNG, atau WebP.';
        error.hidden = false;
        return;
    }
    const preview = input.closest('.image-field').querySelector('img');
    if (preview.dataset.objectUrl) URL.revokeObjectURL(preview.dataset.objectUrl);
    preview.dataset.objectUrl = URL.createObjectURL(file);
    preview.src = preview.dataset.objectUrl; preview.hidden = false;
    upload.querySelector('[data-preview-wrap]').hidden = false;
    upload.querySelector('[data-upload-reset]').hidden = false;
    upload.querySelector('[data-upload-error]').hidden = true;
    upload.querySelector('[data-preview-badge]').textContent = 'Preview · belum disimpan';
    upload.querySelector('[data-file-info]').textContent = `${file.name} · ${(file.size / 1024 / 1024).toFixed(2)} MB`;
});
document.addEventListener('click', event => {
    const reset = event.target.closest('[data-upload-reset]');
    if (reset) { resetUpload(reset.closest('[data-upload]')); markDirty(); }
});
['dragenter','dragover','dragleave','drop'].forEach(type => document.addEventListener(type, event => {
    const zone = event.target.closest('[data-dropzone]');
    if (!zone) return;
    event.preventDefault();
    if (type === 'dragenter' || type === 'dragover') zone.classList.add('drag-over');
    if (type === 'dragleave' && !zone.contains(event.relatedTarget)) zone.classList.remove('drag-over');
    if (type === 'drop') {
        zone.classList.remove('drag-over');
        const input = zone.querySelector('[data-image-input]');
        const transfer = new DataTransfer();
        if (event.dataTransfer.files[0]) transfer.items.add(event.dataTransfer.files[0]);
        input.files = transfer.files;
        input.dispatchEvent(new Event('change', {bubbles:true}));
    }
}));
const sidebar = document.querySelector('.sidebar');
const menuToggle = document.querySelector('[data-menu-toggle]');
const mobile = window.matchMedia('(max-width: 980px)');
function setMenu(open, restoreFocus = true) {
    if (!sidebar) return;
    document.body.classList.toggle('menu-open', open);
    document.querySelector('.sidebar-overlay').hidden = !open;
    menuToggle.setAttribute('aria-expanded', String(open));
    sidebar.inert = mobile.matches && !open;
    document.querySelector('.workspace').inert = mobile.matches && open;
    if (open) sidebar.querySelector('[data-menu-close]').focus();
    else if (restoreFocus && mobile.matches) menuToggle.focus();
}
menuToggle?.addEventListener('click', () => setMenu(!document.body.classList.contains('menu-open')));
document.querySelectorAll('[data-menu-close]').forEach(button => button.addEventListener('click', () => setMenu(false)));
mobile.addEventListener('change', () => setMenu(false, false));
setMenu(false, false);
document.addEventListener('keydown', event => {
    if (!document.body.classList.contains('menu-open')) return;
    if (event.key === 'Escape') setMenu(false);
    if (event.key === 'Tab') {
        const focusable = [...sidebar.querySelectorAll('a,button')].filter(element => element.getClientRects().length && !element.disabled);
        const first = focusable[0], last = focusable.at(-1);
        if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last.focus(); }
        else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first.focus(); }
    }
});
document.querySelector('[data-section-search]')?.addEventListener('input', event => {
    const search = event.target.value.trim().toLocaleLowerCase('id');
    let count = 0;
    document.querySelectorAll('[data-section-card]').forEach(card => {
        card.hidden = !card.dataset.sectionCard.includes(search);
        if (!card.hidden) count++;
    });
    document.querySelector('[data-search-empty]').hidden = count > 0;
    document.querySelector('[data-search-status]').textContent = `${count} bagian ditemukan.`;
});
if (editor?.dataset.dirty === 'true') markDirty();
document.querySelector('.error-summary')?.focus();
