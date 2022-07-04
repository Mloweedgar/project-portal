<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Newsletter extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'email'];

    protected static $logAttributes = ['name', 'email'];


    protected $table="newsletters";

    public function isConfirmed()
    {
        if ($this->token === null) {
            return true;
        }

        return false;
    }
}
