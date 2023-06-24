<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Book $book)
    {
        // Update $user authorization to view $book here.
        return true;
    }

    public function create(User $user, Book $book)
    {
        // Update $user authorization to create $book here.
        return true;
    }

    public function update(User $user, Book $book)
    {
        // Update $user authorization to update $book here.
        return true;
    }

    public function delete(User $user, Book $book)
    {
        // Update $user authorization to delete $book here.
        return true;
    }
}
