<?php

namespace App\Models;

use App\Support\Models\HasDataTableFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Indication
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Indication filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Indication query()
 * @method static \Illuminate\Database\Eloquent\Builder|Indication sort(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Indication whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Indication extends Model
{
    use HasFactory;
    use HasDataTableFilter;

    protected $fillable = ['code', 'name'];

    public function problems()
    {
        return $this->belongsToMany(Problem::class, IndicationProblem::class, 'indication_code', 'problem_code', 'code', 'code');
    }
}
