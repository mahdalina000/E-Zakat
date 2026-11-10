#!/usr/bin/env python3
"""
Generate audio hadis (opsi A) menggunakan ElevenLabs.
Teks hadis (Arab + arti Indonesia) dikirim sekali, hasil disimpan sebagai MP3
statis di public/audio/hadits/hNN.mp3. Setelah file ada, halaman welcome
memutar file ini; tanpa file, tamp fallback ke Web Speech API.

Pemakaian:
    python generate_hadith_audio.py --api-key <KEY>
    python generate_hadith_audio.py --api-key <KEY> --voice <VOICE_ID> --output-dir public/audio/hadits
"""

import argparse
import json
import requests
import sys
from pathlib import Path

# Daftar hadis — harus sinkron dgn array `hadiths` di resources/views/welcome.blade.php
HADITHS = [
    ("بُنِيَ الْإِسْلَامُ عَلَى خَمْسٍ ... وَإِيتَاءِ الزَّكَاةِ", "Islam dibangun di atas lima perkara: syahadat, shalat, zakat, puasa Ramadhan, dan haji."),
    ("مَا نَقَصَتْ صَدَقَةٌ مِنْ مَالٍ", "Sedekah tidak akan mengurangi harta."),
    ("حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ", "Bentengilah hartamu dengan zakat."),
    ("مَنْ أَدَّى زَكَاةَ مَالِهِ فَقَدْ ذَهَبَ عَنْهُ شَرُّهُ", "Barangsiapa menunaikan zakat hartanya, maka hilanglah keburukan hartanya."),
    ("إِنَّ اللَّهَ فَرَضَ عَلَيْهِمْ صَدَقَةً تُؤْخَذُ مِنْ أَغْنِيَائِهِمْ", "Sesungguhnya Allah mewajibkan sedekah (zakat) yang diambil dari orang kaya mereka."),
    ("وَفِي أَمْوَالِهِمْ حَقٌّ لِلسَّائِلِ وَالْمَحْرُومِ", "Dan pada harta mereka ada hak untuk orang miskin yang meminta dan yang tidak meminta."),
    ("خُذْ مِنْ أَمْوَالِهِمْ صَدَقَةً تُطَهِّرُهُمْ", "Ambillah zakat dari sebagian harta mereka, dengan zakat itu kamu membersihkan mereka."),
    ("مَا مَنَعَ قَوْمٌ الزَّكَاةَ إِلَّا ابْتَلَاهُمُ اللَّهُ بِالسِّنِينَ", "Tidaklah suatu kaum enggan membayar zakat melainkan Allah akan menimpakan paceklik."),
    ("تَهَادَوْا وَتَصَدَّقُوا", "Saling memberi hadiahlah dan bersedekahlah."),
    ("الصَّدَقَةُ تُطْفِئُ الْخَطِيئَةَ كَمَا يُطْفِئُ الْمَاءُ النَّارَ", "Sedekah memadamkan kesalahan sebagaimana air memadamkan api."),
    ("دَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", "Obatilah orang sakit di antara kalian dengan sedekah."),
    ("إِنَّ الصَّدَقَةَ لَتُطْفِئُ غَضَبَ الرَّبِّ", "Sesungguhnya sedekah benar-benar memadamkan kemurkaan Allah."),
    ("مَا مِنْ يَوْمٍ يُصْبِحُ الْعِبَادُ فِيهِ إِلَّا مَلَكَانِ يَنْزِلَانِ", "Tidak ada hari kecuali dua malaikat turun dan mendoakan orang yang berinfak."),
    ("أَنْفِقْ يَا ابْنَ آدَمَ أُنْفِقْ عَلَيْكَ", "Berinfaklah wahai anak Adam, niscaya Aku akan berinfak kepadamu."),
    ("الْيَدُ الْعُلْيَا خَيْرٌ مِنَ الْيَدِ السُّفْلَى", "Tangan di atas lebih baik daripada tangan di bawah."),
    ("اتَّقُوا النَّارَ وَلَوْ بِشِقِّ تَمْرَةٍ", "Jagalah diri kalian dari api neraka walau dengan separuh kurma."),
    ("كُلُّ امْرِئٍ فِي ظِلِّ صَدَقَتِهِ حَتَّى يُفْصَلَ بَيْنَ النَّاسِ", "Setiap orang berada di bawah naungan sedekahnya hingga diputuskan perkara manusia."),
    ("إِذَا مَاتَ ابْنُ آدَمَ انْقَطَعَ عَمَلُهُ إِلَّا مِنْ ثَلَاثٍ ... صَدَقَةٍ جَارِيَةٍ", "Jika anak Adam meninggal, terputus amalnya kecuali tiga: sedekah jariyah..."),
    ("حَصِّنُوا أَمْوَالَكُمْ بِالزَّكَاةِ وَدَاوُوا مَرْضَاكُمْ بِالصَّدَقَةِ", "Jagalah hartamu dengan zakat dan obati sakitmu dengan sedekah."),
    ("لَنْ تَنَالُوا الْبِرَّ حَتَّى تُنْفِقُوا مِمَّا تُحِبُّونَ", "Kamu tidak akan memperoleh kebajikan hingga kamu menginfakkan sebagian harta yang kamu cintai."),
]

VOICE_ID_DEFAULT = "21m00Tcm4TlvDq8ikWm"  # Rachel (Inggris). Ganti dgn voice id lain bila perlu.


def generate_one(api_key, voice_id, arab, indo, out_path: Path):
    # Kombinasikan teks: bacaan Arab, jeda, kemudian arti dalam bahasa Indonesia
    text = f"{arab}. Artinya: {indo}"
    url = f"https://api.elevenlabs.io/v1/text-to-speech/{voice_id}"
    headers = {
        "Accept": "audio/mpeg",
        "Content-Type": "application/json",
        "xi-api-key": api_key,
    }
    payload = {
        "text": text,
        "model_id": "eleven_multilingual_v2",
        "voice_settings": {"stability": 0.5, "similarity_boost": 0.75},
    }
    r = requests.post(url, headers=headers, json=payload, timeout=120)
    if r.status_code != 200:
        raise RuntimeError(f"ElevenLabs HTTP {r.status_code}: {r.text[:200]}")
    out_path.write_bytes(r.content)


def main():
    ap = argparse.ArgumentParser()
    ap.add_argument("--api-key", required=True, help="ElevenLabs API key")
    ap.add_argument("--voice", default=VOICE_ID_DEFAULT, help="Voice ID")
    ap.add_argument("--output-dir", default="public/audio/hadits", help="Folder output MP3")
    args = ap.parse_args()

    out_dir = Path(args.output_dir)
    out_dir.mkdir(parents=True, exist_ok=True)

    print(f"Menyiapkan {len(HADITHS)} hadis -> {out_dir.resolve()}")
    for i, (arab, indo) in enumerate(HADITHS, start=1):
        fname = f"h{i:02d}.mp3"
        out_path = out_dir / fname
        generate_one(args.api_key, args.voice, arab, indo, out_path)
        print(f"  OK {fname} ({out_path.stat().st_size} bytes)")

    print("\nSelesai. Semua MP3 tersimpan. Jalankan 'php artisan view:cache' bila perlu.")


if __name__ == "__main__":
    main()
