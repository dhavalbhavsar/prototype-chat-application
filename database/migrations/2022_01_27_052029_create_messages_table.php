<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Group;
use App\Models\User;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Group::class, 'group_id')
                    ->constrained('groups')
                    ->cascadeOnDelete()
                    ->comment('FK with groups');
            $table->text('message');
            $table->foreignIdFor(User::class, 'created_by')
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
        Schema::dropIfExists('messages');
    }
}
