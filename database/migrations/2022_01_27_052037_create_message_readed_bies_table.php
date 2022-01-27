<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Message;
use App\Models\User;

class CreateMessageReadedBiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_readed_bies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Message::class, 'message_id')
                    ->constrained('messages')
                    ->cascadeOnDelete()
                    ->comment('FK with messages');
            $table->foreignIdFor(User::class, 'user_id')
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
        Schema::dropIfExists('message_readed_bies');
    }
}
