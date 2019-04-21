<?php
namespace App\Policies;
use App\{User, Comment};
use Illuminate\Auth\Access\HandlesAuthorization;
class CommentPolicy
{
    use HandlesAuthorization;
    public function accept(User $user, Comment $comment)
    {
        // owns - posee
        return $user->owns($comment->post);
    }
}
