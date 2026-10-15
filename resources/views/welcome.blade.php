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
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: '#EAEAEA',       /* Background dasar light gray */
                        cream2: '#F4F4F4',      /* Off-white */
                        cream3: '#D6D6D6',      /* Border */
                        olive: '#4B8B3B',       /* Hijau utama */
                        olive2: '#3D7330',      /* Hijau gelap hover */
                        olive3: '#A8D5BA',      /* Hijau mint / sage */
                        oliveDark: '#001F3F',   /* Navy gelap */
                        earth: '#F2C94C',       /* Kuning emas */
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                        amiri: ['Amiri', 'serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            overflow: hidden; /* Mencegah Scroll / Pas 1 Layar */
            background-color: #EAEAEA;
        }
        
        img { max-width: 100%; height: auto; }

        /* Animasi Ultra Smooth Reveal */
        @keyframes zyraSmoothWelcome {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.98);
                filter: blur(5px);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0);
            }
        }

        .anim-welcome {
            animation: zyraSmoothWelcome 0.85s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .turbolinks-progress-bar { display: none !important; }
    </style>
</head>
<body class="h-screen w-screen flex flex-col justify-between p-3 lg:p-5 box-border relative overflow-hidden">

    <!-- GAMBAR ILUSTRASI SEBAGAI BACKGROUND UTAMA LAYAR (TANPA KOTAK PUTIH) -->
    <!-- GAMBAR ILUSTRASI BACKGROUND DENGAN EFEK BLUR -->
<div class="fixed inset-0 w-full h-full opacity-20 pointer-events-none z-0 overflow-hidden flex items-center justify-center">
    <img src="{{ asset('images/e-zakat.jpg') }}" 
         alt="E-Zakat Ramadan Illustration Background" 
         class="w-full h-full object-cover object-center scale-105 blur-[6px]">
</div>

    <!-- FLOATING HEADER -->
    <header class="bg-olive text-white rounded-full max-w-7xl mx-auto w-full px-6 h-[56px] flex items-center justify-between shadow-md shrink-0 border border-white/10 relative z-10">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="w-9 h-9 rounded-full bg-white p-1 flex items-center justify-center shadow-sm transition-transform group-hover:scale-105 shrink-0 overflow-hidden">
                <img src="{{ asset('images/logo.png') }}" alt="E-Zakat Logo" class="w-full h-full object-contain">
            </div>
            <div class="leading-tight">
                <div class="font-extrabold text-sm tracking-wide text-white">E-ZAKAT</div>
                <div class="text-[9px] tracking-[0.18em] text-cream/80 -mt-0.5">BANJARBARU</div>
            </div>
        </a>

        <a href="{{ url('/beranda') }}" class="bg-earth hover:bg-yellow-400 text-oliveDark text-xs font-bold px-5 py-2 rounded-full transition shadow-md flex items-center gap-1.5">
            <span>Masuk Web</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </header>

    <!-- MAIN CONTAINER (LANGSUNG DILUAR TANPA CARD PUTIH) -->
    <main class="max-w-7xl mx-auto w-full my-auto space-y-4 flex-1 flex flex-col justify-center anim-welcome relative z-10 px-2">

        <!-- HERO SECTION 2 KOLOM -->
        <div class="grid lg:grid-cols-12 gap-8 items-center w-full my-auto">
            
            <!-- KOLOM KIRI: UCAPAN SELAMAT DATANG (LANGSUNG DI ATAS BACKGROUND) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="inline-flex items-center gap-2 bg-white/80 backdrop-blur-md border border-cream3/80 px-3.5 py-1 rounded-full text-xs font-bold text-olive shadow-sm">
                    <i class="fa-solid fa-star-and-crescent text-earth"></i> PLATFORM ZAKAT DIGITAL TERPERCAYA
                </div>

                <h1 class="font-black text-oliveDark leading-[0.98] text-[36px] sm:text-[48px] lg:text-[58px] tracking-tight drop-shadow-sm">
                    Selamat Datang<br>
                    <span class="text-olive">di E-Zakat</span>
                </h1>

                <p class="text-oliveDark/90 text-xs sm:text-sm lg:text-base max-w-lg leading-relaxed font-semibold drop-shadow-sm">
                    Tunaikan kewajiban, raih keberkahan. Platform digital untuk menghitung, menyalurkan, dan memahami zakat sesuai syariat — khusus warga Banjarbaru.
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="{{ url('/beranda') }}" class="bg-olive hover:bg-olive2 text-white font-bold px-7 py-3 rounded-full text-xs lg:text-sm shadow-md transition flex items-center gap-2">
                        Mulai Sekarang <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                    <span class="text-xs text-olive font-semibold bg-white/90 backdrop-blur-md border border-cream3 px-4 py-2.5 rounded-full shadow-sm">
                        <i class="fa-solid fa-shield-halved text-earth mr-1"></i> 100% Sesuai Syariat
                    </span>
                </div>
            </div>

            <!-- KOLOM KANAN: HADIS SLIDER (HIJAU OLIVE CARD) -->
            <div class="lg:col-span-5 flex justify-center lg:justify-end">
                <div class="w-full bg-olive text-white p-6 rounded-3xl shadow-2xl relative border border-white/20 flex flex-col justify-between min-h-[260px] backdrop-blur-sm">
                    
                    <!-- Badge Hadis -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-earth text-oliveDark text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                            <i class="fa-solid fa-quote-left mr-1"></i> Hadis Zakat
                        </span>
                        <span class="text-xs text-cream/90 font-bold"><span id="idxLabel">1</span> / 20</span>
                    </div>

                    <!-- Content Hadis -->
                    <div id="hadithCard" class="my-auto py-2"></div>

                    <!-- Navigasi Slider -->
                    <div class="flex items-center justify-between pt-3 border-t border-white/20">
                        <div class="flex items-center gap-2">
                            <button id="prevBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-earth hover:text-oliveDark text-white transition flex items-center justify-center text-xs"><i class="fa-solid fa-chevron-left"></i></button>
                            <button id="nextBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-earth hover:text-oliveDark text-white transition flex items-center justify-center text-xs"><i class="fa-solid fa-chevron-right"></i></button>
                            <button id="pauseBtn" class="w-7 h-7 rounded-full bg-white/20 hover:bg-earth hover:text-oliveDark text-white transition flex items-center justify-center text-xs ml-1"><i id="pauseIcon" class="fa-solid fa-pause"></i></button>
                        </div>
                        <div id="dots" class="flex gap-1"></div>
                    </div>
                </div>
            </div>

        </div>

        <!-- QUICK ACTION FLOATING BAR (BAGIAN BAWAH) -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl p-3 border border-cream3 shadow-lg grid md:grid-cols-3 gap-3 items-center shrink-0">
            <div class="flex items-center gap-3 px-3 py-1 md:border-r border-cream3">
                <i class="fa-solid fa-calculator text-olive text-lg shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-oliveDark">Kalkulator Zakat</div>
                    <div class="text-[10px] text-oliveDark/60">Hitung Fitrah, Maal & Fidyah</div>
                </div>
            </div>
            <div class="flex items-center gap-3 px-3 py-1 md:border-r border-cream3">
                <i class="fa-solid fa-map-location-dot text-earth text-lg shrink-0"></i>
                <div>
                    <div class="text-xs font-bold text-oliveDark">Direktori Maps</div>
                    <div class="text-[10px] text-oliveDark/60">Peta amil zakat Banjarbaru</div>
                </div>
            </div>
            <div class="flex items-center justify-between px-3 py-1">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-book-quran text-olive text-lg shrink-0"></i>
                    <div>
                        <div class="text-xs font-bold text-oliveDark">Panduan Syariat</div>
                        <div class="text-[10px] text-oliveDark/60">Nisab, syarat & 8 asnaf</div>
                    </div>
                </div>
                <a href="{{ url('/panduan') }}" class="bg-olive3/30 hover:bg-olive hover:text-white text-olive w-7 h-7 rounded-full flex items-center justify-center transition shrink-0">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </main>

    <!-- FOOTER SIMPLE -->
    <footer class="max-w-7xl mx-auto w-full text-center text-[11px] text-oliveDark/70 py-1 shrink-0 relative z-10 font-medium">
        © {{ date('Y') }} E-Zakat Banjarbaru — Amanah, Transparan, Berkah
    </footer>

    <!-- SCRIPT HADIS SLIDER -->
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
        if(!card) return;
        const h=hadiths[idx];
        card.innerHTML=`<div class="text-left space-y-1"><div class="font-amiri text-earth text-base lg:text-lg font-bold leading-snug">${h.arab}</div><p class="text-white/95 text-xs leading-relaxed font-normal">"${h.indo}"</p><div class="text-[10px] text-cream/80 font-semibold pt-1"><i class="fa-solid fa-book-open mr-1 text-earth"></i> ${h.sumber}</div></div>`;
        idxLabel.textContent=idx+1;
        [...dots.children].forEach((d,i)=> d.className=i===idx?'w-4 h-1 rounded-full bg-earth transition-all':'w-1 h-1 rounded-full bg-white/30 transition-all');
    }
    function next(){idx=(idx+1)%hadiths.length;render();}
    function prev(){idx=(idx-1+hadiths.length)%hadiths.length;render();}
    function startTimer(){clearInterval(timer);timer=setInterval(()=>{if(!paused)next();},4200);}
    hadiths.forEach((_,i)=>{const b=document.createElement('button');b.addEventListener('click',()=>{idx=i;render();startTimer();});dots.appendChild(b);});
    document.getElementById('nextBtn')?.addEventListener('click',()=>{next();startTimer();});
    document.getElementById('prevBtn')?.addEventListener('click',()=>{prev();startTimer();});
    document.getElementById('pauseBtn')?.addEventListener('click',()=>{paused=!paused;document.getElementById('pauseIcon').className=paused?'fa-solid fa-play text-[10px]':'fa-solid fa-pause text-[10px]';});
    render();startTimer();
    document.addEventListener('keydown',e=>{if(e.key==='ArrowRight'){next();startTimer();} if(e.key==='ArrowLeft'){prev();startTimer();}});
    </script>
</body>
</html>