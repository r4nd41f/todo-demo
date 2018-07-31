<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Task extends Model
{
    protected $table = 'task';

    /**
     * Scope a query to only include incomplete tasks.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed_date', null)->orderBy('due_date');
    }

    public function scopeDueDateBetween($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('due_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
    }

    public function scopeDueDateOn($query, Carbon $date)
    {
        return $query->where('due_date', $date->format('Y-m-d'));
    }

    public function scopeByUser($query, $id)
    {
        return $query->where('user_id', $id);
    }
}
