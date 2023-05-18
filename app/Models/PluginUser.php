<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginUser extends Model
{
    use HasFactory;

    public const ACTIVE = 1;
    public const INACTIVE = 2;
    public const UNINSTALL = 3;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'version',
        'website',
        'plugins',
        'server',
        'status',
        'activated_at',
        'deactivated_at',
        'uninstalled_at'
    ];
    protected $casts = [
        'plugins' => 'array',
        'server' => 'array'
    ];

    public function getStatusAttribute($status): string
    {
        return match ($status) {
            self::ACTIVE => 'activate',
            self::INACTIVE => 'deactivate',
            default => 'uninstalled',
        };
    }
}
