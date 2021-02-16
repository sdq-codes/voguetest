<?php
namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model {
    use UuidGenerator;
    protected $fillable = [
        "id",
        'user_id',
        "permission_id"
    ];

    public function permission() {
        return $this->belongsTo(Permission::class);
    }
}
