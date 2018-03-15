<?php

namespace App;


class Post extends BaseModel
{
    protected $fillable = array(
        'id',
        'title',
        'description',
        'content',
        'image',
        'blog',
        'created_at_ip',
        'updated_at_ip');

    public static function prevBlogPostUrl($id){
        $blog = static::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return $blog ? $blog->url : '#';
    }

    public function tags(){
        return $this->belongsToMany(
            'App\BlogTag', 'blog_post_tags', 'post_id', 'tag_id');
    }
}
