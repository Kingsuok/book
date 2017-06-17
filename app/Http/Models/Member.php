<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Member extends Model
{
    use Billable;
    protected $table = 'member';
    protected $primaryKey = 'id';
}
