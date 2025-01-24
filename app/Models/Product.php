<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_category_id',
        'name',
        'image',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();

        // Automatically set user_id when creating a product for store role
        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->role === 'store') {
                $model->user_id = Auth::id();
            }
            $model->slug = Str::slug($model->name); // Generate slug when creating
        });

        // Automatically update slug and user_id when updating a product
        static::updating(function ($model) {
            if (Auth::check() && Auth::user()->role === 'store') {
                $model->user_id = Auth::id();
            }
            $model->slug = Str::slug($model->name); // Update slug when name changes
        });
    }

        /**
     * Generate a unique slug for the product
     *
     * @param string $name
     * @param int|null $excludeId
     * @return string
     */
    // protected static function generateUniqueSlug($name, $excludeId = null)
    // {
    //     $slug = Str::slug($name);
    //     $originalSlug = $slug;
    //     $counter = 1;

    //     // Check if the slug already exists
    //     while (self::where('slug', $slug)
    //         ->when($excludeId, fn($query) => $query->where('id', '!=', $excludeId))
    //         ->exists()) {
    //         $slug = "{$originalSlug}-{$counter}";
    //         $counter++;
    //     }

    //     return $slug;
    // }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with ProductCategory
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
