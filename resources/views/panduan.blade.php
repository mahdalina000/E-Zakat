@extends('layouts.app')
@section('title','Panduan Zakat — E-Zakat')
@section('content')
<div class="max-w-7xl mx-auto px-4 lg:px-6 py-6">
    <div class="bg-cream rounded-[20px] p-5 lg:p-6 border border-cream3">
        <h1 class="font-extrabold text-oliveDark text-xl lg:text-2xl"><i class="fa-solid fa-book-open text-olive mr-2"></i> Panduan Zakat Lengkap</h1>
        <p class="text-sm text-olive/60 mt-1">Pahami niat, syarat, waktu, besaran, 8 asnaf, dalil, dan tanya jawab — ringkas dan sesuai rujukan syariat.</p>
        <div class="mt-4 flex flex-wrap gap-2 text-xs">
            <a href="#niat" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Niat</a>
            <a href="#fitrah" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Zakat Fitrah</a>
            <a href="#maal" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Zakat Maal</a>
            <a href="#fidyah" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">Fidyah</a>
            <a href="#asnaf" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">8 Asnaf</a>
            <a href="#faq" class="bg-white border border-cream3 px-3 py-1.5 rounded-full text-olive hover:bg-cream">FAQ</a>
        </div>
    </div>

    <div class="mt-6 grid lg:grid-cols-[1fr_300px] gap-6">
        <div class="space-y-6">
            {{-- Niat --}}
            <div id="niat" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">1</span> Niat Zakat</h2>
                <p class="text-xs text-olive/60 mt-1">Niat di dalam hati; melafalkan membantu menguatkan. Berikut lafal yang umum diajarkan ulama.</p>
                <div class="mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT FITRAH UNTUK DIRI SENDIRI</div>
                        <div class="font-amiri text-oliveDark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَنْ نَفْسِي فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-oliveDark mt-2 italic">"Nawaitu an ukhrija zakatal fitri 'an nafsi fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Artinya: Aku niat mengeluarkan zakat fitrah untuk diriku sendiri, fardu karena Allah Ta'ala.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT FITRAH UNTUK KELUARGA</div>
                        <div class="font-amiri text-oliveDark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ الْفِطْرِ عَنِّي وَعَنْ جَمِيعِ مَنْ تَلْزَمُنِي نَفَقَتُهُ فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-oliveDark mt-2 italic">"Nawaitu an ukhrija zakatal fitri 'anni wa 'an jami'i man talzamuni nafaqatuhu fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Untuk kepala keluarga yang menanggung istri/anak.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT ZAKAT MAAL</div>
                        <div class="font-amiri text-oliveDark text-base mt-2 leading-relaxed" dir="rtl">نَوَيْتُ أَنْ أُخْرِجَ زَكَاةَ مَالِي فَرْضًا لِلَّهِ تَعَالَى</div>
                        <div class="text-sm text-oliveDark mt-2 italic">"Nawaitu an ukhrija zakata mali fardhan lillahi ta'ala"</div>
                        <div class="text-xs text-olive/60 mt-1">Aku niat mengeluarkan zakat hartaku fardu karena Allah Ta'ala.</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="text-xs font-bold tracking-wide text-olive">NIAT MEWAKILKAN (LEWAT AMIL)</div>
                        <div class="text-sm text-oliveDark mt-2">Cukup niat di hati saat menyerahkan. Amil akan mendoakan: <span class="italic">"Ajarakallahu fima a'thaita..."</span> — Semoga Allah memberi pahala atas apa yang engkau berikan.</div>
                        <div class="text-xs text-olive/60 mt-2">Tidak wajib melafalkan di depan amil; keikhlasan hati yang utama.</div>
                    </div>
                </div>
            </div>

            {{-- Zakat Fitrah --}}
            <div id="fitrah" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">2</span> Zakat Fitrah</h2>
                <div class="mt-4 grid md:grid-cols-2 gap-4 text-sm">
                    <div class="space-y-3">
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-oliveDark">Hukum</div><div class="text-olive/70 text-xs mt-1">Wajib bagi setiap muslim — laki/perempuan, dewasa/anak, merdeka/budak — yang memiliki kelebihan makanan pokok di malam & hari Id.</div></div>
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-oliveDark">Besaran</div><div class="text-olive/70 text-xs mt-1">1 sha' = <b>2,5 kg beras</b> (atau 3,5 liter) per jiwa. Di Banjarbaru default <b>Beras Banjar</b>; boleh beras lain dengan harga setara.</div></div>
                        <div class="bg-cream rounded-xl p-3"><div class="font-semibold text-oliveDark">Waktu</div><div class="text-olive/70 text-xs mt-1">Terbaik: akhir Ramadhan hingga sebelum shalat Id. Boleh sejak awal Ramadhan. Makruh setelah shalat Id (terhitung sedekah biasa).</div></div>
                    </div>
                    <div class="space-y-3">
                        <div class="bg-olive text-white rounded-xl p-4">
                            <div class="text-xs text-cream/80">CONTOH CEPAT</div>
                            <div class="font-bold mt-1">Keluarga 4 jiwa × Beras Banjar Rp16.000/kg</div>
                            <div class="text-cream/80 text-xs mt-1">4 × 2,5 kg × Rp16.000 = <b class="text-white">Rp160.000</b> atau 10 kg beras.</div>
                            <a href="{{ url('/kalkulator') }}" class="inline-block mt-3 bg-white text-olive text-xs font-semibold px-4 py-1.5 rounded-full">Hitung di Kalkulator →</a>
                        </div>
                        <div class="bg-cream rounded-xl p-3 border border-cream3"><div class="font-semibold text-oliveDark text-xs">Boleh uang?</div><div class="text-olive/70 text-xs mt-1">Mayoritas ulama membolehkan dengan nilai setara beras. Di Indonesia, BAZNAS memfasilitasi konversi uang.</div></div>
                    </div>
                </div>
            </div>

            {{-- Zakat Maal --}}
            <div id="maal" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">3</span> Zakat Maal (Harta)</h2>
                <div class="mt-4 text-sm text-olive/70 leading-relaxed">
                    <p>Zakat maal wajib atas harta yang memenuhi <b class="text-oliveDark">nisab & haul</b>. Jenis: emas-perak, uang/tabungan, perdagangan, pertanian, ternak, rikaz, dll. Kadar umum <b class="text-oliveDark">2,5%</b>.</p>
                    <div class="mt-4 grid md:grid-cols-3 gap-3">
                        <div class="bg-cream rounded-xl p-3 border border-cream3"><div class="font-bold text-oliveDark">Nisab</div><div class="text-xs mt-1">Setara <b>85 gram emas</b>. Mis. emas Rp1.300.000/gr → nisab Rp110.500.000.</div></div>
                        <div class="bg-cream rounded-xl p-3 border border-cream3"><div class="font-bold text-oliveDark">Haul</div><div class="text-xs mt-1">Harta bertahan <b>1 tahun hijriah</b> di atas nisab. Jika di bawah nisab, tidak wajib.</div></div>
                        <div class="bg-cream rounded-xl p-3 border border-cream3"><div class="font-bold text-oliveDark">Kadar</div><div class="text-xs mt-1"><b>2,5%</b> dari total harta yang wajib dizakati (setelah dikurangi hutang jatuh tempo).</div></div>
                    </div>
                    <div class="mt-4 bg-cream rounded-xl p-3 border border-cream3 text-xs"><i class="fa-solid fa-lightbulb text-earth mr-1"></i> Tip: Gunakan kalkulator Zakat Maal di halaman Kalkulator untuk simulasi otomatis.</div>
                </div>
            </div>

            {{-- Fidyah --}}
            <div id="fidyah" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">4</span> Fidyah Puasa</h2>
                <p class="text-sm text-olive/70 mt-2">Bagi yang tidak mampu berpuasa dan tidak ada harapan sembuh (lansia, sakit menahun) atau hamil/menyusui dengan kekhawatiran — wajib fidyah sebagai pengganti.</p>
                <div class="mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="font-semibold text-oliveDark text-sm">Besaran</div>
                        <ul class="text-xs text-olive/70 mt-2 space-y-1 list-disc list-inside">
                            <li><b>1 hari = 1 mud</b> ≈ 0,75 kg beras, atau</li>
                            <li><b>1 porsi makan</b> lengkap dengan lauk (estimasi Banjarbaru Rp35–55rb).</li>
                            <li>Boleh diberikan sekaligus untuk beberapa hari kepada satu/sejumlah fakir miskin.</li>
                        </ul>
                    </div>
                    <div class="bg-olive text-white rounded-xl p-4">
                        <div class="text-xs text-cream/80">CONTOH</div>
                        <div class="font-bold mt-1">Tinggalkan 10 hari × Rp45.000</div>
                        <div class="text-cream/80 text-xs mt-1">= <b class="text-white">Rp450.000</b> atau 7,5 kg beras.</div>
                        <div class="text-xs text-cream/60 mt-2">Lebih utama memberi makan langsung daripada uang, tapi uang yang dibelikan makanan juga sah.</div>
                    </div>
                </div>
            </div>

            {{-- 8 Asnaf --}}
            <div id="asnaf" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">5</span> 8 Asnaf Penerima Zakat</h2>
                <p class="text-xs text-olive/60 mt-1">QS. At-Taubah: 60 — Sesungguhnya zakat itu hanyalah untuk...</p>
                <div class="mt-4 grid sm:grid-cols-2 gap-3 text-sm">
                    @php $asnafs = [
                        ['Fakir','Tidak punya harta & penghasilan, atau sangat tidak mencukupi.','fa-person-circle-question'],
                        ['Miskin','Punya penghasilan tapi tidak cukup untuk kebutuhan pokok.','fa-hand-holding-heart'],
                        ['Amil','Pengelola zakat yang ditunjuk.','fa-people-group'],
                        ['Muallaf','Yang dijinakkan hatinya (baru masuk Islam).','fa-heart'],
                        ['Riqab','Budak/hamba sahaya (konteks modern: memerdekakan dari jeratan).','fa-link-slash'],
                        ['Gharimin','Berhutang untuk kebutuhan pokok & tidak mampu membayar.','fa-scale-balanced'],
                        ['Fisabilillah','Di jalan Allah (dakwah, jihad, kepentingan umum syar\'i).','fa-mosque'],
                        ['Ibnu Sabil','Musafir kehabisan bekal.','fa-person-walking-luggage'],
                    ]; @endphp
                    @foreach($asnafs as $i=>$a)
                    <div class="bg-cream rounded-xl p-3 border border-cream3 flex gap-3">
                        <div class="w-9 h-9 bg-white border border-cream3 rounded-lg flex items-center justify-center text-olive flex-shrink-0"><i class="fa-solid {{ $a[2] }} text-xs"></i></div>
                        <div><div class="font-bold text-oliveDark text-sm">{{ $i+1 }}. {{ $a[0] }}</div><div class="text-xs text-olive/60 mt-0.5">{{ $a[1] }}</div></div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Dalil & Keutamaan --}}
            <div class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-earth text-white rounded-lg inline-flex items-center justify-center text-sm mr-2"><i class="fa-solid fa-book-quran"></i></span> Dalil & Keutamaan</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="font-amiri text-olive text-base" dir="rtl">وَأَقِيمُوا الصَّلَاةَ وَآتُوا الزَّكَاةَ</div>
                        <div class="text-xs text-olive/60 mt-1">“Dan dirikanlah shalat dan tunaikanlah zakat.” — QS. Al-Baqarah: 43 (diulang >30 kali bersama shalat)</div>
                    </div>
                    <div class="bg-cream rounded-xl p-4 border border-cream3">
                        <div class="font-semibold text-oliveDark text-xs">Keutamaan</div>
                        <ul class="text-xs text-olive/70 mt-2 space-y-1 list-disc list-inside">
                            <li>Membersihkan harta & jiwa (QS. At-Taubah: 103)</li>
                            <li>Mengundang keberkahan & menolak bala</li>
                            <li>Menjadi naungan di hari kiamat (HR. Ahmad)</li>
                            <li>Menyempurnakan rukun Islam</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- FAQ --}}
            <div id="faq" class="bg-white rounded-[20px] border border-cream3 p-5 lg:p-6">
                <h2 class="font-bold text-oliveDark text-lg"><span class="w-8 h-8 bg-olive text-white rounded-lg inline-flex items-center justify-center text-sm mr-2">?</span> Tanya Jawab</h2>
                <div class="mt-4 space-y-2" id="faqBox">
                    @php $faqs=[
                        ['Bolehkah zakat fitrah dengan uang?','Boleh — dengan nilai setara 2,5 kg beras lokal. BAZNAS memfasilitasi konversi uang agar praktis.'],
                        ['Kapan batas akhir zakat fitrah?','Sebelum shalat Id. Jika terlewat, tetap wajib dikeluarkan tapi terhitung sedekah biasa.'],
                        ['Apakah zakat maal dipotong hutang?','Ya, hutang jatuh tempo yang mengikat boleh mengurangi harta kena zakat sebelum hitung nisab.'],
                        ['Fidyah boleh dicicil?','Boleh. Boleh diberikan harian, mingguan, atau sekaligus kepada fakir miskin.'],
                        ['Ke mana menyalurkan di Banjarbaru?','BAZNAS Kota, UPZ/masjid terdekat, atau warga dhuafa — lihat Direktori Maps.'],
                        ['Apakah beras harus Beras Banjar?','Tidak wajib. Beras Banjar adalah opsi default lokal; boleh beras lain dengan harga setara.'],
                    ]; @endphp
                    @foreach($faqs as $f)
                    <details class="bg-cream rounded-xl border border-cream3 px-4 py-3 group">
                        <summary class="font-semibold text-oliveDark text-sm cursor-pointer list-none flex justify-between items-center">{{ $f[0] }} <i class="fa-solid fa-chevron-down text-xs text-olive/50 group-open:rotate-180 transition"></i></summary>
                        <p class="text-xs text-olive/70 mt-2 leading-relaxed">{{ $f[1] }}</p>
                    </details>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sidebar sticky --}}
        <div class="space-y-4">
            <div class="bg-olive rounded-[20px] p-5 text-white lg:sticky lg:top-[76px]">
                <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center"><i class="fa-solid fa-lightbulb"></i></div>
                <div class="font-bold mt-3">Butuh Hitung Cepat?</div>
                <p class="text-xs text-cream/70 mt-1">Buka kalkulator untuk simulasi zakat fitrah, maal, dan fidyah otomatis.</p>
                <a href="{{ url('/kalkulator') }}" class="mt-4 block text-center bg-cream text-oliveDark font-bold py-2.5 rounded-full text-sm hover:bg-white transition">Buka Kalkulator <i class="fa-solid fa-arrow-right ml-1"></i></a>
                <a href="{{ url('/direktori') }}" class="mt-2 block text-center bg-white/10 text-white font-semibold py-2.5 rounded-full text-sm hover:bg-white/15 transition border border-white/20">Lihat Peta Penyaluran</a>
            </div>
            <div class="bg-white rounded-[20px] border border-cream3 p-4">
                <div class="font-bold text-oliveDark text-sm">Rujukan</div>
                <ul class="text-xs text-olive/60 mt-2 space-y-1 list-disc list-inside">
                    <li>Al-Qur'an & Hadis</li>
                    <li>Fatwa MUI & BAZNAS RI</li>
                    <li>Kitab Fiqh Zakat — Yusuf Qaradawi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
