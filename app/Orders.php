<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $connection = 'bringo';

    protected $table = 'Order';
}
