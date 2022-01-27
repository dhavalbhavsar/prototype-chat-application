<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Group;
use App\Models\User;

class CreateGroupUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class, 'group_id')
                    ->constrained('groups')
                    ->cascadeOnDelete()
                    ->comment('FK with groups');
            $table->foreignIdFor(User::class, 'user_id')
                    ->constrained('users')
                    ->cascadeOnDelete()
                    ->comment('FK with users');
            $table->tinyInteger('is_admin')->default(0);
            $table->foreignIdFor(User::class, 'added_by')
                    ->constrained('users')
                    ->comment('FK with users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_users');
    }
}
