<?php

namespace App\Services;

class WarisService
{
    /**
     * Hitung pembagian waris berdasarkan hukum Islam (Faraid).
     * 
     * Input:
     * - estateValue: Total harta warisan (Rp)
     * - heirs: Array of ['name' => '', 'relation' => 'wife|husband|son|daughter|father|mother|grandfather|grandmother', 'count' => int]
     * 
     * Output: Array pembagian harta per ahli waris.
     */
    public function calculate(float $estateValue, array $heirs): array
    {
        if (empty($heirs) || $estateValue <= 0) {
            return ['error' => 'Data tidak valid', 'breakdown' => []];
        }

        // Kelompokkan ahli waris per hubungan
        $relations = [];
        foreach ($heirs as $heir) {
            $rel = $heir['relation'];
            $count = (int) ($heir['count'] ?? 1);
            if ($count < 1) continue;
            $relations[$rel] = ($relations[$rel] ?? 0) + $count;
        }

        // Cek apakah ada suami/istri (mengurangi porsi lainnya)
        $hasHusband = isset($relations['husband']);
        $hasWife = isset($relations['wife']);

        // Hitung porsi berdasarkan hukum Faraid
        $shares = [];
        
        // 1. Suami: 1/2 jika tidak ada anak, 1/4 jika ada anak
        if ($hasHusband) {
            $hasDescendant = isset($relations['son']) || isset($relations['daughter']);
            $shares['husband'] = $hasDescendant ? 0.25 : 0.5;
        }

        // 2. Istri: 1/4 jika tidak ada anak, 1/8 jika ada anak
        if ($hasWife) {
            $hasDescendant = isset($relations['son']) || isset($relations['daughter']);
            $shares['wife'] = $hasDescendant ? 0.125 : 0.25;
        }

        // 3. Anak: Bagi sisa setelah spouse, laki-laki 2x perempuan
        $hasDescendant = isset($relations['son']) || isset($relations['daughter']);
        if ($hasDescendant) {
            $sons = $relations['son'] ?? 0;
            $daughters = $relations['daughter'] ?? 0;
            $totalUnits = ($sons * 2) + $daughters;
            if ($totalUnits > 0) {
                $remainingAfterSpouse = 1.0 - (isset($shares['husband']) ? $shares['husband'] : 0) - (isset($shares['wife']) ? $shares['wife'] : 0);
                $sonShare = 2 / $totalUnits;
                $daughterShare = 1 / $totalUnits;
                $shares['son'] = $remainingAfterSpouse * $sonShare;
                $shares['daughter'] = $remainingAfterSpouse * $daughterShare;
            }
        }

        // 4. Orang tua: Ayah 1/6 jika ada anak, Ibu 1/6 jika ada anak
        $hasChild = isset($relations['son']) || isset($relations['daughter']);
        if (isset($relations['father'])) {
            $shares['father'] = $hasChild ? 1/6 : 1/6; // Ayah selalu 1/6
        }
        if (isset($relations['mother'])) {
            $shares['mother'] = 1/6; // Ibu selalu 1/6
        }

        // 5. Kakek/Kembah: 1/6 jika ada, tapi ayah yang lebih dekat
        if (!isset($shares['father']) && isset($relations['grandfather'])) {
            $shares['grandfather'] = 1/6;
        }
        if (!isset($shares['mother']) && isset($relations['grandmother'])) {
            $shares['grandmother'] = 1/6;
        }

        // Sisa (ashobah): Dibagi rata antar ahli waris terdekat
        $totalAssigned = array_sum($shares);
        $remaining = max(0, 1.0 - $totalAssigned);
        
        if ($remaining > 0.001) {
            // Ashobah - bagi rata
            $ashobahRelations = [];
            if (isset($relations['son'])) $ashobahRelations['son'] = $relations['son'];
            if (isset($relations['daughter'])) $ashobahRelations['daughter'] = $relations['daughter'];
            if (isset($relations['brother'])) $ashobahRelations['brother'] = $relations['brother'];
            if (isset($relations['sister'])) $ashobahRelations['sister'] = $relations['sister'];
            if (isset($relations['brother_maternal'])) $ashobahRelations['brother_maternal'] = $relations['brother_maternal'];
            if (isset($relations['sister_maternal'])) $ashobahRelations['sister_maternal'] = $relations['sister_maternal'];

            if (!empty($ashobahRelations)) {
                $totalAshobahUnits = 0;
                foreach ($ashobahRelations as $rel => $count) {
                    $maleFactor = in_array($rel, ['son', 'brother', 'brother_paternal', 'brother_maternal']) ? 2 : 1;
                    $totalAshobahUnits += $count * $maleFactor;
                }
                foreach ($ashobahRelations as $rel => $count) {
                    if (isset($shares[$rel])) continue; // Sudah dapat porsi tetap
                    $maleFactor = in_array($rel, ['son', 'brother', 'brother_paternal', 'brother_maternal']) ? 2 : 1;
                    $shares[$rel] = ($count * $maleFactor) / $totalAshobahUnits * $remaining;
                }
            }
        }

        // Hitung nilai per orang
        $breakdown = [];
        foreach ($heirs as $heir) {
            $rel = $heir['relation'];
            $count = (int) ($heir['count'] ?? 1);
            $totalShare = ($shares[$rel] ?? 0);
            $perPerson = $totalShare / $count;
            
            $breakdown[] = [
                'name' => $heir['name'] ?? ucfirst($rel),
                'relation' => $rel,
                'count' => $count,
                'share_percentage' => round($totalShare * 100, 2),
                'share_value' => round($estateValue * $perPerson, 2),
            ];
        }

        return [
            'error' => null,
            'breakdown' => $breakdown,
            'total_estate' => $estateValue,
            'total_distributed' => round(array_sum(array_column($breakdown, 'share_value')), 2),
            'calculation_date' => now()->toIso8601String(),
        ];
    }

    /**
     * Validasi input ahli waris.
     */
    public function validateHeirs(array $heirs): array
    {
        $errors = [];
        $validRelations = ['husband', 'wife', 'son', 'daughter', 'father', 'mother', 'grandfather', 'grandmother', 'brother', 'sister', 'brother_maternal', 'sister_maternal'];
        
        foreach ($heirs as $i => $heir) {
            if (!in_array($heir['relation'] ?? '', $validRelations)) {
                $errors[] = "Hubungan ahli waris ke-{$i} tidak valid";
            }
            if ((int) ($heir['count'] ?? 0) < 1) {
                $errors[] = "Jumlah ahli waris ke-{$i} harus minimal 1";
            }
        }

        return $errors;
    }
}
