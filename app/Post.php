<?php

namespace App;


class Post extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'posts';
    protected $fillable = array('id', 'title', 'discription', 'content', 'blog', 'created_at_ip', 'updated_at_ip');
}
