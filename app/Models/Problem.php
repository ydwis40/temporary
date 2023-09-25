<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Support\Models\HasDataTableFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $solution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $indication_codes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Indication> $indication
 * @property-read int|null $indication_count
 * @method static \Illuminate\Database\Eloquent\Builder|Problem filter(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|Problem sort(\Illuminate\Http\Request $request)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereSolution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Problem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Problem extends Model
{
    use HasFactory;
    use HasDataTableFilter;

    protected $fillable = ['code', 'name', 'solution'];

    public $appends = ['indication_codes'];

    public function indication(): BelongsToMany
    {
        return $this->belongsToMany(Indication::class, IndicationProblem::class, 'problem_code', 'indication_code', 'code', 'code');
    }

    public function getIndicationCodesAttribute(): string
    {
        return $this->indication->join('code', ',');
    }
}
