<?php

if (!function_exists('fresh_sales')) {
    
    function fresh_sales()
    {
        return app(\Mannysoft\FreshSales\Api::class);
    }
}
