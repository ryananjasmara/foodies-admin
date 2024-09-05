<?php

if (!function_exists('formatRupiah')) {
    function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('formatDate')) {
    function formatDate($dateString)
    {
        $date = new DateTime($dateString);
        return $date->format('d M Y');
    }
}

?>