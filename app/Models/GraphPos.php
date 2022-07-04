<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class GraphPos extends Model
{
    use LogsActivity;

    protected $fillable = ['graph_id','pos_group','pos'];

    protected static $logAttributes = ['graph_id','pos_group','pos'];


    public function graph()
    {
        return $this->hasOne(Graph::class, 'id', 'graph_id');
    }

}
