<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    private static $orderIndex = -1;
    private static $customers = array();
    private static $orders = array();
    private static $menus = array();
    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'user_id' => $this->getUser(),
            'plat_id' => $this->getMenu(),
            'commande_id' => $this->getOrder(),
            'quantite' => random_int(1, 3),
            'status' => true, // peut changer à faux
        ];
    }

    // Retourner un utilisateur aléatoire
    private function getUser() {
        if (sizeof(self::$customers) == 0) {
            $users = User::all();
            foreach ($users as $user) {
                if ($user->role == 'customer')
                    array_push(self::$customers, $user->id);
            }
        }
        $rand = array_rand(self::$customers);
        return self::$customers[$rand];
    }

    private function getOrder() {
        if (sizeof(self::$orders) == 0) {
            $orders = Order::all();
            foreach ($orders as $order) {
                array_push(self::$orders, $order->id);
            }
        }
        self::$orderIndex++;
        if (self::$orderIndex >= sizeof(self::$orders))
            self::$orderIndex = 0;
        return self::$orders[self::$orderIndex];
    }

    private function getMenu() {
        if (sizeof(self::$menus) == 0) {
            $menus = Menu::all();
            foreach ($menus as $menu) {
                array_push(self::$menus, $menu->id);
            }
        }
        $rand = array_rand(self::$menus);
        return self::$menus[$rand];
    }
}
