<?php
namespace App\Helpers;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class HistoryEntry
{

    protected $key;
    protected $old_value;
    protected $new_value;

    protected $entry = [];

    protected static $cache = [];
    protected static $labels = [];
    protected static $models = [
        'technician_id' => 'User'
    ];

    /**
     * @var Builder
     */
    protected $query;

    public function __construct($key, $old_value, $new_value)
    {
        $this->key = $key;
        $this->old_value = $old_value;
        $this->new_value = $new_value;

        $this->generate();
    }

    private function generate()
    {
        $this->entry['label'] = $this->fetchLabel();
        $this->entry['old_value'] = $this->fetchOldValue();
        $this->entry['new_value'] = $this->fetchNewValue();
    }

    function __get($name)
    {
        if (isset($this->entry[$name])) {
            return $this->entry[$name];
        }

        return '';
    }

    protected function fetchOldValue()
    {
        return $this->fetchValue($this->old_value);
    }

    protected function fetchNewValue()
    {
        return $this->fetchValue($this->new_value);
    }

    protected function fetchValue($value)
    {
        if (strpos($this->key, '_id') !== false) {
            if (!intval($value)) {
                return 'None';
            }

            if (isset(self::$cache[$this->key][$value])) {
                return self::$cache[$this->key][$value];
            }

            $query = $this->fetchQuery();
            if (!$query) {
                return 'None';
            }

            $obj = $query->find($value);
            return $this->cache($value, $obj->name);
        }

        if (is_array($value)) {
            return implode(',', $value);
        }

        return $value;
    }

    protected function fetchLabel()
    {
        if (isset(self::$labels[$this->key])) {
            return self::$labels[$this->key];
        }

        $key = str_replace('_id', '', $this->key);
        return Str::ucfirst(str_replace('_', ' ', Str::snake($key)));
    }

    protected function cache($key, $value)
    {
        if (empty(self::$cache[$this->key])) {
            self::$cache[$this->key] = [];
        }

        self::$cache[$this->key][$key] = $value;

        return $value;
    }

    /**
     * @return Builder
     */
    protected function fetchQuery()
    {
        $model = 'App\\';

        if (isset(self::$models[$this->key])) {
            $model .= self::$models[$this->key];
        } else {
            $model .= Str::studly(str_replace('_id', '', $this->key));
        }

        return app($model)->newQuery();
    }
}