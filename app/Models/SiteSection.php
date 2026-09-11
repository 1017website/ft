<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSection extends Model
{
    protected $primaryKey = 'key';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['key', 'content'];

    protected $casts = ['content' => 'array'];

    public function version(): string
    {
        return hash('sha256', json_encode($this->content));
    }

    public static function websiteContent(): array
    {
        $saved = static::all()->keyBy('key');

        return collect(config('cms'))->map(function ($definition, $key) use ($saved) {
            $content = $saved->get($key)?->content ?? [];

            return [
                'fields' => array_replace($definition['defaults']['fields'], $content['fields'] ?? []),
                'groups' => array_replace($definition['defaults']['groups'], $content['groups'] ?? []),
            ];
        })->all();
    }
}
