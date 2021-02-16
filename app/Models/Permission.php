<?php
namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model {
    use UuidGenerator;

    protected $fillable = [
        "id", "name"
    ];

}
