<?php

if (! function_exists('mask_sensitive')) {
    /**
     * Mask nilai sensitif untuk ditampilkan, mis. 3201********0001.
     */
    function mask_sensitive($value): string
    {
        if ($value === null || $value === '') {
            return '';
        }

        $s = (string) $value;
        $len = mb_strlen($s);

        if ($len <= 4) {
            return str_repeat('*', $len);
        }

        $front = 4;
        $back = 4;
        if ($len < $front + $back + 1) {
            $front = 2;
            $back = 2;
        }

        return mb_substr($s, 0, $front)
            . str_repeat('*', max(1, $len - $front - $back))
            . mb_substr($s, -$back);
    }
}
