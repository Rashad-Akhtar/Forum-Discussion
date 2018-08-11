<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $fillable = ['user_id','channel_id','title','content','slug'];

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function replies()
    {
        return $this->hasMany('App\Reply');
    }

    public function watchers()
    {
        return $this->hasMany('App\Watcher');
    }

    public function is_watched_by_auth_user()
    {
        $id = Auth::id();

        $watcher_ids = array();

        foreach($this->watchers as $w):
            array_push($watcher_ids , $w->user_id);

        endforeach;
        
        if(in_array($id,$watcher_ids))
        {
          
            return true;

        }
        else {
            return false;
        }
    }

    public function hasBestAnswer()
    {
        $result = false;

        foreach($this->replies as $r):
        {
            if($r->best_answer)
            {
                $result = true;
                break;
            }

        }
        endforeach;
        
        return $result;
    }
}
