<?php
function FormatRupiah($nominal)
{
    // Pastikan bahwa $nominal dikonversi ke float
    return "Rp " . number_format((float)$nominal, 0, ',', '.');
}
?>