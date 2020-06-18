<?php

namespace Plugin;

class Notes
{
    const create = 'Create';
    const update = 'Update';
    const delete = 'Delete';
    const error = 'Error';

    public static function create($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::create;
        $log['data'] = $data;
        return $log;
    }

    public static function update($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::update;
        $log['data'] = $data;
        return $log;
    }

    public static function delete($data = null)
    {
        $log['status'] = true;
        $log['form'] = self::delete;
        $log['data'] = $data;
        return $log;
    }

    public static function error($data = null)
    {
        $log['status'] = false;
        $log['form'] = self::error;
        $log['data'] = $data;
        return $log;
    }
}
