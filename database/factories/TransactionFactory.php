<?php


namespace Database\Factories;

use App\Models\Discount;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $order = Order::factory()->times(1)->create()->first();
        return [
            'commande_id' => $order->id,
            'remise_id' => $this->getDiscount(),
            'somme_finale' => $this->faker->randomFloat(2, 1, 999),
            'created_at' => $order->dateTime,
        ];
    }

    private function getDiscount() {
        if (rand(0, 1)) {
            $count = 0;
            $numDiscounts = Discount::count();
            while (true) {
                if ($count > $numDiscounts * 2)
                    return null;
                $count++;
                $index = $this->faker->numberBetween(1, $numDiscounts);
                if (Discount::find($index) != null)
                    return $index;
            }
        } else
            return null;
    }
}
