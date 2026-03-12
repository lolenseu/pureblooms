<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group'];

    public function getValueAttribute($value)
    {
        if ($this->type === 'boolean') {
            return (bool) $value;
        } elseif ($this->type === 'integer') {
            return (int) $value;
        } elseif ($this->type === 'float') {
            return (float) $value;
        } elseif ($this->type === 'array') {
            return \json_decode($value, true);
        }
        
        return $value;
    }

    public function setValueAttribute($value)
    {
        if ($this->type === 'boolean') {
            $value = $value ? '1' : '0';
        } elseif ($this->type === 'array') {
            $value = \json_encode($value);
        }
        
        $this->attributes['value'] = $value;
    }

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group]
        );
    }

    public static function allAsArray()
    {
        return Cache::remember('settings', 3600, function () {
            $settings = [];
            foreach (static::all() as $setting) {
                $settings[$setting->key] = $setting->value;
            }
            return $settings;
        });
    }
}