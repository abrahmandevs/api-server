<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable =['title','description','status','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class, 'user_id')->select('id', 'name', 'email');
    }

    public function scopeFilter(Builder $builder,  QueryFilter $filters)
    {
        $filters->apply($builder);
    }
}
