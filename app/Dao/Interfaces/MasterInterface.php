<?php

namespace App\Dao\Interfaces;

interface MasterInterface
{
    public function dataRepository();

    public function saveRepository($service);

    public function showRepository($id, $relation);

    public function updateRepository($id, $request);

    public function deleteRepository($request);
}
