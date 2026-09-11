(() => {
    const section = document.getElementById('cmsPreviewContext').dataset.section;
    const selectors = {header:'header',footer:'footer',branding:'header',settings:'.hero',integrations:'.ad-placement'};
    function highlight() {
        const target = document.querySelector(selectors[section] || 'section.'+section);
        if (target) {
            target.style.outline='4px solid #dfb958';
            target.style.outlineOffset='-4px';
            target.style.scrollMarginTop='90px';
            if (!['header','branding'].includes(section)) target.scrollIntoView({block:'start',behavior:'instant'});
        }
        window.parent.postMessage({type:'cms-preview-ready'},'*');
    }
    document.addEventListener('submit',event=>event.preventDefault(),true);
    document.addEventListener('click',event=>{
        const link=event.target.closest('a');
        if(link && !link.getAttribute('href')?.startsWith('#'))event.preventDefault();
    },true);
    window.addEventListener('load',highlight);
    highlight();
})();
