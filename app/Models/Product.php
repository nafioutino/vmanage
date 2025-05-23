<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'sku', 'description', 'price', 'cost_price',
        'quantity', 'category_id', 'image', 'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    // Méthode pour obtenir le stock dans un point de vente spécifique
    public function getStockInPointOfSale($pointOfSaleId): int
    {
        $stock = $this->stocks()->where('point_of_sale_id', $pointOfSaleId)->first();
        return $stock ? $stock->quantity : 0;
    }
}