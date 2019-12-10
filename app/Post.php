<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    public $primaryKey = 'id';
    protected $table = 'posts';
    protected $guarded = ['id'];
    protected $fillable = [
        'title', 'content', 'created_by', 'updated_by', 'deleted_at'
    ];
    
    protected $dates =['deleted_at'];
}
