<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;

class MenuController extends Controller
{
    public function start(Request $request)
    {
        $request->validate(['nama' => 'required|string']);
        session(['nama' => $request->nama]);
        return redirect()->route('menu.index');
    }

    public function index()
    {
        if (!session('nama')) {
            return redirect('/');
        }

        $menus = Menu::with('category')->get();
        $categories = Category::withCount('menus')->get();

        return view('menu.index', compact('menus', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $categoryId = $request->input('category_id');

        $menus = Menu::with('category');

        if ($query) {
            $menus->where('name', 'like', "%{$query}%");
        }

        if ($categoryId) {
            $menus->where('category_id', $categoryId);
        }

        $menus = $menus->get();

        return view('menu.partials.list', compact('menus'))->render();
    }

    public function show($id)
    {
        if (!session('nama')) {
            return redirect('/');
        }
        
        $menu = Menu::findOrFail($id);
        
        $cart = session('cart', []);
        $inCart = isset($cart[$id]);
        $cartItem = $inCart ? $cart[$id] : null;

        return view('menu.show', compact('menu', 'inCart', 'cartItem'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'is_update' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        
        $menuId = $request->menu_id;
        $qty = $request->qty;
        $catatan = $request->catatan;

        if (isset($cart[$menuId])) {
            $cart[$menuId]['qty'] = $qty;
            $cart[$menuId]['catatan'] = $catatan;
        } else {
            $menu = Menu::find($menuId);
            $cart[$menuId] = [
                'name' => $menu->name,
                'price' => $menu->price,
                'qty' => $qty,
                'catatan' => $catatan,
                'image' => $menu->image
            ];
        }

        session()->put('cart', $cart);

        if ($request->is_update == '1') {
            return redirect()->route('cart.index');
        }

        return redirect()->route('menu.index');
    }

    public function cart()
    {
        if (!session('nama')) {
            return redirect('/');
        }
        $cart = session('cart', []);
        
        $bookedTables = \App\Models\Order::whereIn('status', ['menunggu_pembayaran', 'diproses'])
                                         ->pluck('no_meja')
                                         ->toArray();
                                         
        return view('cart.index', compact('cart', 'bookedTables'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'meja' => 'required'
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('menu.index');
        }

        $totalHarga = 0;
        foreach ($cart as $item) {
            $totalHarga += ($item['qty'] * $item['price']);
        }

        $order = \App\Models\Order::create([
            'nama_pl' => session('nama'),
            'no_meja' => $request->meja,
            'status' => 'menunggu_pembayaran',
            'total_harga' => $totalHarga,
        ]);

        foreach ($cart as $menuId => $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menuId,
                'qty' => $item['qty'],
                'price' => $item['price'],
                'catatan' => $item['catatan'],
            ]);
        }

        session(['order_id' => $order->id]);
        session()->forget('cart'); // Clear cart after checkout
        
        return redirect()->route('receipt');
    }

    public function receipt()
    {
        if (!session('nama')) {
            return redirect('/');
        }

        $orderId = session('order_id');
        if (!$orderId) {
            return redirect()->route('menu.index');
        }

        $order = \App\Models\Order::with('items.menu')->findOrFail($orderId);

        return view('cart.receipt', compact('order'));
    }

    public function reset()
    {
        session()->forget(['order_id']);
        return redirect()->route('menu.index');
    }

    public function fullReset()
    {
        session()->forget(['order_id', 'nama', 'cart']);
        return redirect('/');
    }

    public function orderStatus($id)
    {
        // Clean up any expired orders before checking
        \App\Models\Order::cleanExpired();

        $order = \App\Models\Order::find($id);
        if ($order) {
            return response()->json(['status' => $order->status]);
        }
        return response()->json(['status' => null], 404);
    }
}
