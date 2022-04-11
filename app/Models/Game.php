<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'prize_id',
        'account',
        'revealed_at',
        'spins_limit',
        'spins_count',
        'total_points'
    ];
    protected $visible = [
        'id',
        'campaign_id',
        'prize_id',
        'account',
        'revealed_at',
        'spins_limit',
        'spins_count',
        'total_points',
        'spin_history'
    ];

    protected $casts = [
        'spin_history' => 'array',
    ];

    protected $dates = [
        'revealed_at',
    ];

    public static function filter()
    {
        $data = Validator::validate(request()->all(), [
            'account' => 'nullable|string|exists:games,account',
            'prize' => 'nullable|integer',
            'time_start' => 'nullable|date_format:H:i',
            'time_end' => 'nullable|date_format:H:i|after:time_start',
            'date_start' => 'nullable|date_format:Y-m-d|before:tomorrow',
            'date_end' => 'nullable|date_format:Y-m-d|after:date_start',
        ]);

        $query = self::query();
        $campaign = Campaign::find(session('activeCampaign'));

        if ($data = request('account')) {
            $query->where('account', 'like', $data . '%');
        }

        if ($data = request('prize')) {
            $query->where('prize_id', $data);
        }

        if ($data = request('time_start')) {
            $time_start = Carbon::parse($data);
            $query->whereTime('revealed_at', '>=', $time_start);
        }

        if ($data = request('time_end')) {
            $time_end = Carbon::parse($data);
            $query->whereTime('revealed_at', '<=', $time_end);
        }

        if ($data = request('date_start')) {
            $data = Carbon::parse($data);
            $query->whereDate('revealed_at', '>=', $data);
        }

        if ($data = request('date_end')) {
            $data = Carbon::parse($data);
            $query->whereDate('revealed_at', '<=', $data);
        }

        $query->leftJoin('prizes', 'prizes.id', '=', 'games.prize_id')
        ->select(
            'games.id',
            'account',
            'prize_id',
            'revealed_at',
            'prizes.name',
            'total_points',
            // 'spins_history'
        )
            ->where('games.campaign_id', $campaign->id);

        return $query;
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function prize()
    {
        return $this->belongsTo(Prize::class);
    }
}
