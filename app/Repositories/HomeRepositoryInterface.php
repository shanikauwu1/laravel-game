<?php
/**
 * User: user
 * Date: 1/6/18
 * Time: 10:58 AM
 */

namespace App\Repositories;

interface HomeRepositoryInterface
{
    public function saveGameData($request);
    public function getGameData($id);
}