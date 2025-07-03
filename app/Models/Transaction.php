<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'date_transaction',
        'amount',
        'note',
        'image',
    ];

    /**
     * Relasi ke model Category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope untuk pengeluaran.
     */
    public function scopeExpense($query)
    {
        return $query->whereHas('category', fn($q) => $q->where('is_expense', 1));
    }

    /**
     * Scope untuk pemasukan.
     */
    public function scopeIncome($query)
    {
        return $query->whereHas('category', fn($q) => $q->where('is_expense', 0));
    }
}
