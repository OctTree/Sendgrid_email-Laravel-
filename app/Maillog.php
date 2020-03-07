<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maillog extends Model
{

    protected $fillable = [
        's_email', 'r_email', 'subject', 'message', 'status', 'u_id', 'c_id', 'msg_id'
    ];
}
