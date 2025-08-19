<?php
// 代码生成时间: 2025-08-20 02:26:49
// 引入必要的命名空间
use Illuminate\Database\Eloquent\Model;

/**
 * User 模型
 *
 * 代表用户数据模型
 */
class User extends Model
{
    /**
     * 模型对应的数据库表
     *
     * @var string
     */
    protected \$table = 'users';

    /**
     * 模型的主键
     *
     * @var string
     */
    protected \$primaryKey = 'id';

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected \$fillable = ['name', 'email', 'password'];

    /**
     * 用户不可被批量赋值的属性
     *
     * @var array
     */
    protected \$guarded = ['password'];
}

/**
 * Post 模型
 *
 * 代表文章数据模型
 */
class Post extends Model
{
    /**
     * 模型对应的数据库表
     *
     * @var string
     */
    protected \$table = 'posts';

    /**
     * 模型的主键
     *
     * @var string
     */
    protected \$primaryKey = 'id';

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected \$fillable = ['title', 'body', 'user_id'];

    /**
     * 获取文章的所有者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return \$this->belongsTo(User::class);
    }
}

/**
 * Comment 模型
 *
 * 代表评论数据模型
 */
class Comment extends Model
{
    /**
     * 模型对应的数据库表
     *
     * @var string
     */
    protected \$table = 'comments';

    /**
     * 模型的主键
     *
     * @var string
     */
    protected \$primaryKey = 'id';

    /**
     * 可以被批量赋值的属性
     *
     * @var array
     */
    protected \$fillable = ['comment', 'post_id', 'user_id'];

    /**
     * 获取评论所属的文章
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return \$this->belongsTo(Post::class);
    }

    /**
     * 获取评论的所有者
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return \$this->belongsTo(User::class);
    }
}
