<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /**
    # Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different locations

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
        //throw new \Exception('implement in coding task 4, you can ignore this exception if you are just running the initial migrations.');
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('movieId');
            $table->string('title')->unique();
            $table->string('description')->nullable();
            $table->timestamp('duration')->nullable();
            $table->string('language');
            $table->string('country');
            $table->timestamps();
        });

        Schema::create('show', function (Blueprint $table) {
            $table->id('showId')->autoIncrement()->unique();
            $table->date('date');
            $table->timestamp('starttime')->nullable();
            $table->timestamp('endtime')->nullable();
            $table->id('cinemaHallId');
            $table->id('movieId');
        });

        Schema::create('booking', function (Blueprint $table) {
            $table->id('bookingId')->autoIncrement();
            $table->date('date');
            $table->integer('numberOfSeat')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->id('status');
            $table->id('UserId');
            $table->id('showId');
            $table->timestamps();
        });

        Schema::create('User', function (Blueprint $table) {
            $table->id('UserId')->autoIncrement();
            $table->string('name');
            $table->string('password')->nullable();
            $table->string('email')->unique();
            $table->string('phone');
            $table->timestamps();
        });

        Schema::create('Cinema', function (Blueprint $table) {
            $table->id('CinemaId')->autoIncrement();
            $table->string('name');
            $table->integer('totalCinemaHall');
            $table->id('CityId');
        });

        Schema::create('Cinema_Hall', function (Blueprint $table) {
            $table->id('CinemaHallId')->autoIncrement();
            $table->string('name');
            $table->integer('totalSeat');
            $table->id('CinemaId');
        });

        Schema::create('Show_Seat', function (Blueprint $table) {
            $table->id('showSeatId')->autoIncrement();
            $table->string('status');
            $table->integer('price');
            $table->id('CinemaSeatId');
            $table->id('BookingId');
        });

        Schema::create('Payment', function (Blueprint $table) {
            $table->id('PaymentId')->autoIncrement();
            $table->integer('amount');
            $table->timestamp('timestamp');
            $table->string('RemoteTransactionId');
            $table->string('PaymentMethodtype');
            $table->id('BookingId');
        });

        Schema::create('City', function (Blueprint $table) {
            $table->id('CityId')->autoIncrement();
            $table->string('name');
            $table->string('state');
            $table->string('zipCode');
        });

        Schema::create('Cinema_Seat', function (Blueprint $table) {
            $table->id('CinemaSeatId')->autoIncrement();
            $table->string('SeatNumber');
            $table->string('type');
            $table->id('CinemaHallId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
        Schema::dropIfExists('show');
        Schema::dropIfExists('booking');
        Schema::dropIfExists('User');
        Schema::dropIfExists('Cinema');
        Schema::dropIfExists('Cinema_Hall');
        Schema::dropIfExists('Show_Seat');
        Schema::dropIfExists('Payment');
        Schema::dropIfExists('City');
        Schema::dropIfExists('Cinema_Seat');
    }
}
