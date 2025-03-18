<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create("query_submissions", function (Blueprint $table) {
			$table->bigIncrements("id");
			$table->string("name");
			$table->string("email");
			$table->unsignedBigInteger("query_type");
			$table->unsignedBigInteger("query_for");
			$table->unsignedBigInteger("query_to");
			$table->text("query_content");
			$table->unsignedBigInteger("stage");
			$table->timestamp('created_at')->useCurrent();
			$table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
			$table->foreign("query_type")->references("id")->on("departments")->onDelete('cascade');
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists("query_submissions");
	}
};
