<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name'); // Tên khách hàng
            $table->string('customer_phone'); // SĐT
            $table->string('address'); // Địa chỉ
            $table->text('note')->nullable(); // Ghi chú
            $table->decimal('total_amount', 10, 2); // Tổng số tiền
            $table->string('payment_method'); // Phương thức thanh toán
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
