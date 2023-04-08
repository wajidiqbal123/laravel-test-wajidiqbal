<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {
         Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('shows', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movie_id');
            $table->unsignedBigInteger('room_id');
            $table->dateTime('start_time');
            $table->timestamps();

            $table->foreign('movie_id')->references('id')->on('movies');
            $table->foreign('room_id')->references('id')->on('rooms');
        });

        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->string('name');
            $table->string('type');
            $table->timestamps();
            $table->foreign('room_id')->references('id')->on('rooms');
        });

        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_id');
            $table->unsignedDecimal('amount', 8, 2);
            $table->timestamps();

            $table->foreign('show_id')->references('id')->on('shows');
        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('show_id');
            $table->unsignedBigInteger('seat_id');
            $table->timestamps();
            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('seat_id')->references('id')->on('seats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('prices');
        Schema::dropIfExists('seats');
        Schema::dropIfExists('shows');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('movies');

    }
}
