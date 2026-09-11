if (window.L && document.getElementById('map')) {
const cities=[...document.querySelectorAll('#cityList button')].map((button, index) => {
  const city = {key:String(index),city:button.dataset.city,region:button.dataset.region,lat:Number(button.dataset.lat),lng:Number(button.dataset.lng)};
  button.dataset.city = String(index);
  return city;
});
const map=L.map("map",{zoomControl:true,scrollWheelZoom:true,minZoom:4,maxZoom:13}).setView([-2.7,118.1],5);
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{maxZoom:19,attribution:"&copy; OpenStreetMap contributors"}).addTo(map);
const icon=L.divIcon({className:"",html:'<div class="ft-marker"></div>',iconSize:[18,18],iconAnchor:[9,9]});
const markers={};
cities.forEach(c=>{
  const popup=document.createElement('div');
  const name=document.createElement('b'); name.textContent=c.city;
  popup.append(name,document.createElement('br'),document.createTextNode(c.region),document.createElement('br'),document.createTextNode('FT Logistik Coverage'));
  markers[c.key]=L.marker([c.lat,c.lng],{icon}).addTo(map).bindPopup(popup);
});
document.querySelectorAll("#cityList button").forEach(btn=>btn.addEventListener("click",()=>{
  document.querySelectorAll("#cityList button").forEach(x=>x.classList.remove("active"));
  btn.classList.add("active");
  const m=markers[btn.dataset.city];
  if(m){map.flyTo(m.getLatLng(),8,{duration:.8});setTimeout(()=>m.openPopup(),450);}
}));
window.addEventListener("load",()=>setTimeout(()=>map.invalidateSize(),180));
} else if (document.getElementById('map')) {
  document.getElementById('map').textContent = 'Peta tidak dapat dimuat. Periksa koneksi internet Anda.';
}

document.querySelectorAll(".gallery-tab").forEach(tab=>tab.addEventListener("click",()=>{
  document.querySelectorAll(".gallery-tab").forEach(x=>x.classList.remove("active"));
  document.querySelectorAll(".gallery-panel").forEach(x=>x.classList.remove("active"));
  tab.classList.add("active");
  document.getElementById(tab.dataset.gallery).classList.add("active");
}));

const lightbox=document.getElementById("lightbox");
const lightboxImage=document.getElementById("lightboxImage");
document.querySelectorAll(".photo-item img").forEach(img=>img.parentElement.addEventListener("click",()=>{
  lightboxImage.src=img.src; lightbox.classList.add("show");
}));
document.getElementById("lightboxClose").addEventListener("click",()=>lightbox.classList.remove("show"));
lightbox.addEventListener("click",e=>{if(e.target===lightbox)lightbox.classList.remove("show")});

const videoModal=document.getElementById("videoModal");
document.querySelectorAll(".video-card").forEach(card=>card.addEventListener("click",()=>{
  document.getElementById("videoPoster").src=card.dataset.poster;
  document.getElementById("videoTitle").textContent=card.dataset.title;
  const player=document.getElementById('videoPlayer'); player.replaceChildren();
  const poster=document.getElementById('videoPoster'); poster.hidden=false;
  const message=document.getElementById('videoMessage'); message.hidden=false;
  if(card.dataset.video) {
    try {
      const url=new URL(card.dataset.video);
      if (!['http:', 'https:'].includes(url.protocol)) throw new Error('Unsupported URL');
      let videoId='';
      if (['youtube.com','www.youtube.com','m.youtube.com'].includes(url.hostname)) videoId=url.searchParams.get('v') || url.pathname.match(/^\/(?:embed|shorts)\/([\w-]+)/)?.[1] || '';
      if(url.hostname==='youtu.be') videoId=url.pathname.slice(1);
      if (/^[\w-]{11}$/.test(videoId)) {
        const frame=document.createElement('iframe'); frame.src='https://www.youtube-nocookie.com/embed/'+videoId; frame.title=card.dataset.title; frame.allowFullscreen=true; player.append(frame);
      } else if (/\.mp4$/i.test(url.pathname)) {
        const video=document.createElement('video'); video.src=url.href; video.controls=true; video.poster=card.dataset.poster; player.append(video);
      } else {
        const link=document.createElement('a'); link.href=url.href; link.textContent='Buka video'; link.target='_blank'; link.rel='noopener noreferrer'; player.append(link);
      }
      poster.hidden=player.querySelector('iframe,video')!==null; message.hidden=true;
    } catch (_) { message.textContent='Link video tidak dapat dibuka.'; }
  }
  videoModal.classList.add("show");
}));
function closeVideo(){videoModal.classList.remove('show');document.getElementById('videoPlayer').replaceChildren();}
document.getElementById("videoClose").addEventListener("click",closeVideo);
videoModal.addEventListener("click",e=>{if(e.target===videoModal)closeVideo()});

const modal=document.getElementById("quoteModal");
document.querySelectorAll(".openQuote").forEach(x=>x.addEventListener("click",e=>{e.preventDefault();modal.classList.add("show")}));
document.getElementById("closeModal").addEventListener("click",()=>modal.classList.remove("show"));
modal.addEventListener("click",e=>{if(e.target===modal)modal.classList.remove("show")});

document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeVideo();modal.classList.remove('show');lightbox.classList.remove('show');}});
document.querySelectorAll('a[href^="#"]').forEach(link=>{const target=link.getAttribute('href');if(target.length>1 && !document.getElementById(target.slice(1)))link.hidden=true;});
