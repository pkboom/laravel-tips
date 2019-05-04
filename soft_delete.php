<?php
Schema::table('posts', function (Blueprint $table) {
    // set a custom column name <- Do we need to name this? Because we provide the name in Model.
    $table->softDeletes('archived_at');
});

class Post extends Model
{
    use SoftDeletes {
        restore as unarchive;
        trashed as archived;
    }

    const DELETED_AT = 'archived_at';

    public function archive()
    {
        return $this-delete();
    }
}

$post->archive();
$post->unarchive();
if ($post->archived()) {
    //
}
