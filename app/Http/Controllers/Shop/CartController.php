<?php


namespace App\Http\Controllers\Shop;


use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;


class CartController extends Controller
{
    public function add(Post $post, $count = 1)
    {


        $cart = session('cart', []);

        // delete
        if ($count <= 0) {
            if (Arr::exists($cart, $post->id)) {
                unset($cart[$post->id]);
                session(['cart' => $cart]);
            }
            $this->saveDB($cart);
            return redirect()->back();
        }

        // add
        if (Arr::exists($cart, $post->id)) {
            $cart[$post->id][1] = $count;
        } else {
            $cart[$post->id] = [$post, $count];
        }
        $this->saveDB($cart);
        // set en la sesion
        session(['cart' => $cart]);
        return redirect()->back();
        // dd($cart);
    }

    public function index()
    {
        return inertia('Shop/Index');
    }

    public function saveDB($cart)
    {
      
        if (auth()->check()) {
            $control = time();

            foreach ($cart as $c) {
    
                ShoppingCart::updateOrCreate(
                    [
                        'post_id' => $c[0]->id,
                        'user_id' => auth()->id(),
                    ],
                    [
                        'post_id' => $c[0]->id,
                        'count' => $c[1],
                        'user_id' => auth()->id(),
                        'control' => $control,
                    ]
                );
            }

            //*** BORRAR */

            ShoppingCart::whereNot('control', $control)->where('user_id', auth()->id())->delete();
        }
    }


}