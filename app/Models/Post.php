<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ['title', 'description', 'content', 'image', 'category_id', 'user_id'];

    public function scopeSelection($query)
    {
        return $query->select('id', 'title', 'description', 'content', 'image', 'category_id', 'user_id');
    }

    /////Biiiiiig errrrror لازم تكون نفس اسم الصوره يعنى لو ف الداتا بيز image لازم تكون getImageAttribute
    // public function getPhotoAttribute($val){
    //     return ($val !== null) ? asset('uploads/Posts/' . $val) : "";
    // }

    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset('uploads/Posts/' . $val) : "";
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function hasTag($tagId)
    // {
    //     return $this->tags()->where('tags.id', $tagId)->exists();
    // }

    public function hasTag($tagId)
    {
        return $this->tags->contains('id', $tagId);
    }

    // public function hasTag($tagId)
    // {
    //     return in_array($tagId, $this->tags->pluck('id')->toArray());
    // }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
