<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Zakat Banjarbaru — Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&family=Amiri:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>
        tailwind.config={theme:{extend:{colors:{cream:'#F5EAD8',cream2:'#FFF8EC',cream3:'#EDE0CC',olive:'#5A6B33',olive2:'#4A5A2B',oliveDark:'#3D4A24',earth:'#C5A880'},fontFamily:{poppins:['Poppins','sans-serif'],amiri:['Amiri','serif']}}}}
    </script>
    <style>body{font-family:'Poppins',sans-serif}</style>
</head>
<body class="bg-cream2 min-h-screen flex flex-col">
<header class="bg-olive text-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 h-[56px] flex items-center justify-between">
        <!-- Logo Baru E-Zakat -->
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-xl bg-white p-1 flex items-center justify-center ring-2 ring-white/80 shadow-md transition-transform group-hover:scale-105 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" 
                     alt="E-Zakat Logo" 
                     class="w-full h-full object-contain">
            </div>
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide text-white">E-ZAKAT</div>
                <div class="text-[10px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
            </div>
        </a>
        <span class="hidden sm:inline text-xs bg-white/15 px-3 py-1.5 rounded-full"><i class="fa-solid fa-location-dot mr-1"></i> Kota Banjarbaru, Kalimantan Selatan</span>
    </div>
</header>
<section class="flex-1 flex flex-col">
    <div class="bg-cream flex-1 flex flex-col items-center justify-center px-4 py-10 lg:py-14 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle at 1px 1px, #5A6B33 1px, transparent 0); background-size: 28px 28px;"></div>
        <div class="relative text-center max-w-3xl">
            <div class="inline-flex items-center gap-2 bg-white border border-cream3 px-4 py-1.5 rounded-full text-xs font-semibold text-olive tracking-wide shadow-sm">
                <i class="fa-solid fa-star-and-crescent"></i> PLATFORM ZAKAT DIGITAL TERPERCAYA
            </div>
            <h1 class="mt-5 font-black text-oliveDark leading-[0.95] text-[32px] sm:text-[42px] lg:text-[56px]">
                Selamat Datang<br>
                <span class="text-olive">di E-Zakat</span>
            </h1>
            <p class="mt-3 text-olive/70 text-sm lg:text-base max-w-xl mx-auto">Tunaikan kewajiban, raih keberkahan. Platform digital untuk menghitung, menyalurkan, dan memahami zakat sesuai syariat — khusus untuk warga Banjarbaru.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3 text-xs">
                <span class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive"><i class="fa-solid fa-circle-check text-olive mr-1"></i> Sesuai Syariat</span>
                <span class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive"><i class="fa-solid fa-shield-halved text-olive mr-1"></i> Amanah & Transparan</span>
                <span class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive"><i class="fa-solid fa-hand-holding-heart text-olive mr-1"></i> Untuk Banjarbaru</span>
            </div>
        </div>
    </div>
    <div class="bg-olive text-white flex-1 flex flex-col items-center justify-center px-4 py-8 lg:py-10 relative overflow-hidden">
        <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 28px 28px;"></div>
        <div class="relative w-full max-w-3xl">
            <div class="text-center mb-4">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1 rounded-full text-[11px] tracking-[0.14em] font-semibold">HADIS TENTANG ZAKAT</div>
                <p class="text-xs text-cream/70 mt-2">Geser otomatis • klik panah atau titik untuk navigasi</p>
            </div>
            <div class="bg-cream2 rounded-[20px] p-5 lg:p-7 shadow-xl relative">
                <div class="absolute -top-3 -right-3 w-10 h-10 bg-earth rounded-full flex items-center justify-center text-white shadow"><i class="fa-solid fa-quote-right"></i></div>
                <div id="hadithCard" class="min-h-[180px] flex flex-col justify-center"></div>
                <div class="flex items-center justify-between mt-5 pt-4 border-t border-cream3">
                    <div class="flex items-center gap-2">
                        <button id="prevBtn" class="w-9 h-9 rounded-full bg-olive text-white flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                        <button id="nextBtn" class="w-9 h-9 rounded-full bg-olive text-white flex items-center justify-center hover:bg-olive2 transition"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                        <button id="pauseBtn" class="w-9 h-9 rounded-full bg-white border border-cream3 text-olive flex items-center justify-center hover:bg-cream transition ml-1" title="Jeda / Lanjutkan"><i id="pauseIcon" class="fa-solid fa-pause text-xs"></i></button>
                    </div>
                    <div class="text-xs text-olive/60"><span id="idxLabel">1</span> / 20</div>
                </div>
                <div id="dots" class="flex justify-center gap-1.5 mt-3 flex-wrap"></div>
            </div>
            <div class="text-center mt-7">
                <a href="{{ url('/beranda') }}" class="inline-flex items-center gap-3 bg-cream text-oliveDark font-bold px-8 py-3.5 rounded-full shadow-lg hover:bg-white hover:shadow-xl transition text-sm lg:text-base">
                    Masuk ke Beranda <i class="fa-solid fa-arrow-right"></i>
                </a>
                <p class="text-xs text-cream/60 mt-3">Mulai hitung zakat, lihat direktori, dan pelajari panduan</p>
            </div>
        </div>
    </div>
</section>
<footer class="bg-oliveDark text-cream/60 text-center text-xs py-3">© {{ date('Y') }} E-Zakat Banjarbaru — Amanah, Transparan, Berkah</footer>
<script>
const hadiths = [
    {arab:"بُنِيَ الْإِسْلَامُ عَلَى خَمْسٍ ... وَإِيتَاءِ الزَّكَاةِ", indo:"Islam dibangun di atas lima perkara: syahadat, shalat, zakat, puasa Ramadhan, dan haji.", sumber:"HR. Bukhari & Muslim"},
    {arab:"مَا نَقَصَتْ صَدَقَةٌ مِنْ مَالٍ", indo:"Sedekah tidak akan mengurangi harta.", sumber:"HR. Muslim No. 2588"},
    {arab:"حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ", indo:"Bentengilah hartamu dengan zakat.", sumber:"HR. Thabrani — Hasan"},
    {arab:"مَنْ أَدَّى زَكَاةَ مَالِهِ فَقَدْ ذَهَبَ عَنْهُ شَرُّهُ", indo:"Barangsiapa menunaikan zakat hartanya, maka hilanglah keburukan hartanya.", sumber:"HR. Thabrani"},
    {arab:"إِنَّ اللَّهَ فَرَضَ عَلَيْهِمْ صَدَقَةً تُؤْخَذُ مِنْ أَغْنِيَائِهِمْ", indo:"Sesungguhnya Allah mewajibkan sedekah (zakat) yang diambil dari orang kaya mereka.", sumber:"HR. Bukhari"},
    {arab:"وَفِي أَمْوَالِهِمْ حَقٌّ لِلسَّائِلِ وَالْمَحْرُومِ", indo:"Dan pada harta mereka ada hak untuk orang miskin yang meminta dan yang tidak meminta.", sumber:"QS. Adz-Dzariyat: 19"},
    {arab:"خُذْ مِنْ أَمْوَالِهِمْ صَدَقَةً تُطَهِّرُهُمْ", indo:"Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan mereka.", sumber:"QS. At-Taubah: 103"},
    {arab:"مَا مَنَعَ قَوْمٌ الزَّكَاةَ إِلَّا ابْتَلَاهُمُ اللَّهُ بِالسِّنِينَ", indo:"Tidaklah suatu kaum enggan membayar zakat melainkan Allah akan menimpakan paceklik.", sumber:"HR. Thabrani"},
    {arab:"تَهَادَوْا وَتَصَدَّقُوا", indo:"Saling memberi hadiahlah dan bersedekahlah.", sumber:"HR. Bukhari (Adabul Mufrad)"},
    {arab:"الصَّدَقَةُ تُطْفِئُ الْخَطِيئَةَ كَمَا يُطْفِئُ الْمَاءُ النَّارَ", indo:"Sedekah memadamkan kesalahan sebagaimana air memadamkan api.", sumber:"HR. Tirmidzi No. 614"},
    {arab:"دَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", indo:"Obatilah orang sakit di antara kalian dengan sedekah.", sumber:"HR. Baihaqi — Hasan"},
    {arab:"إِنَّ الصَّدَقَةَ لَتُطْفِئُ غَضَبَ الرَّبِّ", indo:"Sesungguhnya sedekah benar-benar memadamkan kemurkaan Allah.", sumber:"HR. Tirmidzi"},
    {arab:"مَا مِنْ يَوْمٍ يُصْبِحُ الْعِبَادُ فِيهِ إِلَّا مَلَكَانِ يَنْزِلَانِ", indo:"Tidak ada hari kecuali dua malaikat turun dan mendoakan orang yang berinfak.", sumber:"HR. Bukhari & Muslim"},
    {arab:"أَنْفِقْ يَا ابْنَ آدَمَ أُنْفِقْ عَلَيْكَ", indo:"Berinfaklah wahai anak Adam, niscaya Aku akan berinfak kepadamu.", sumber:"HR. Bukhari & Muslim"},
    {arab:"الْيَدُ الْعُلْيَا خَيْرٌ مِنَ الْيَدِ السُّفْلَى", indo:"Tangan di atas lebih baik daripada tangan di bawah.", sumber:"HR. Bukhari & Muslim"},
    {arab:"اتَّقُوا النَّارَ وَلَوْ بِشِقِّ تَمْرَةٍ", indo:"Jagalah diri kalian dari api neraka walau dengan separuh kurma.", sumber:"HR. Bukhari & Muslim"},
    {arab:"كُلُّ امْرِئٍ فِي ظِلِّ صَدَقَتِهِ حَتَّى يُفْصَلَ بَيْنَ النَّاسِ", indo:"Setiap orang berada di bawah naungan sedekahnya hingga diputuskan perkara manusia.", sumber:"HR. Ahmad"},
    {arab:"إِذَا مَاتَ ابْنُ آدَمَ انْقَطَعَ عَمَلُهُ إِلَّا مِنْ ثَلَاثٍ ... صَدَقَةٍ جَارِيَةٍ", indo:"Jika anak Adam meninggal, terputus amalnya kecuali tiga: sedekah jariyah...", sumber:"HR. Muslim"},
    {arab:"حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ وَدَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", indo:"Jagalah hartamu dengan zakat dan obati sakitmu dengan sedekah.", sumber:"HR. Abu Dawud"},
    {arab:"لَنْ تَنَالُوا الْبِرَّ حَتَّى تُنْفِقُوا مِمَّا تُحِبُّونَ", indo:"Kamu tidak akan memperoleh kebajikan hingga kamu menginfakkan sebagian harta yang kamu cintai.", sumber:"QS. Ali Imran: 92"},
];
let idx=0,timer=null,paused=false;
const card=document.getElementById('hadithCard'), idxLabel=document.getElementById('idxLabel'), dots=document.getElementById('dots');
function render(){
    const h=hadiths[idx];
    card.innerHTML=`<div class="text-center"><div class="font-amiri text-olive text-lg lg:text-xl leading-relaxed">${h.arab}</div><p class="mt-3 text-oliveDark text-sm lg:text-[15px] leading-relaxed">"${h.indo}"</p><div class="mt-3 inline-flex items-center gap-2 bg-olive text-cream text-xs px-3 py-1.5 rounded-full"><i class="fa-solid fa-book-open"></i> ${h.sumber}</div></div>`;
    idxLabel.textContent=idx+1;
    [...dots.children].forEach((d,i)=> d.className=i===idx?'w-6 h-2 rounded-full bg-olive transition-all':'w-2 h-2 rounded-full bg-cream3 transition-all');
}
function next(){idx=(idx+1)%hadiths.length;render();}
function prev(){idx=(idx-1+hadiths.length)%hadiths.length;render();}
function startTimer(){clearInterval(timer);timer=setInterval(()=>{if(!paused)next();},4200);}
hadiths.forEach((_,i)=>{const b=document.createElement('button');b.addEventListener('click',()=>{idx=i;render();startTimer();});dots.appendChild(b);});
document.getElementById('nextBtn').addEventListener('click',()=>{next();startTimer();});
document.getElementById('prevBtn').addEventListener('click',()=>{prev();startTimer();});
document.getElementById('pauseBtn').addEventListener('click',()=>{paused=!paused;document.getElementById('pauseIcon').className=paused?'fa-solid fa-play text-xs':'fa-solid fa-pause text-xs';});
render();startTimer();
document.addEventListener('keydown',e=>{if(e.key==='ArrowRight'){next();startTimer();} if(e.key==='ArrowLeft'){prev();startTimer();}});
</script>
</body>
</html>