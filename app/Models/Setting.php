<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    /**
     * Mengambil nilai pengaturan berdasarkan key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function ambil($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Menyimpan atau memperbarui pengaturan.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    public static function simpan($key, $value, $type = 'text', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description
            ]
        );
    }
}