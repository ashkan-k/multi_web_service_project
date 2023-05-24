<?php

use App\Enums\EnumHelpers;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ticket_category_id')->constrained('ticket_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ticket_frequently_asked_id')->constrained('ticket_frequently_asked_questions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('ticket_subject_id')->constrained('ticket_subjects')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title');
            $table->text('text');
            $table->text('file')->nullable();
            $table->enum('status', EnumHelpers::$TicketStatusEnum)->default('waiting');
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
        Schema::dropIfExists('tickets');
    }
};
