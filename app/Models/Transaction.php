<?php
namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    use UuidGenerator;

    protected $guarded = [
    ];

}
