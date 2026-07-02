<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pesananMasukCount = Order::where('status', 'menunggu_pembayaran')->count();
        $pesananDiprosesCount = Order::where('status', 'diproses')->count();
        $riwayatTransaksiCount = Order::where('status', 'selesai')->count();
        $totalPendapatan = Order::where('status', 'selesai')->sum('total_harga');

        // Fetch income data grouped by date (last 7 days)
        $chartData = Order::selectRaw('DATE(created_at) as date, SUM(total_harga) as total')
            ->where('status', 'selesai')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get()
            ->reverse()
            ->values(); // reindex

        $maxIncome = $chartData->max('total') ?: 1000000; // default max 1M if no data
        // Round up maxIncome to next nice number (e.g., nearest 100,000)
        $maxIncome = ceil($maxIncome / 100000) * 100000;
        if ($maxIncome == 0) $maxIncome = 1000000; // fallback if 0

        return view('admin.dashboard', compact('pesananMasukCount', 'pesananDiprosesCount', 'riwayatTransaksiCount', 'totalPendapatan', 'chartData', 'maxIncome'));
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        if (!$keyword) {
            if ($request->ajax()) {
                return response()->json(['menus' => [], 'orders' => []]);
            }
            return redirect()->back();
        }

        $menus = Menu::where('name', 'LIKE', "%{$keyword}%")->get();
        $orders = Order::where('nama_pl', 'LIKE', "%{$keyword}%")
                       ->orWhere('no_meja', 'LIKE', "%{$keyword}%")
                       ->get();

        if ($request->ajax()) {
            return response()->json([
                'menus' => $menus,
                'orders' => $orders
            ]);
        }

        return view('admin.search', compact('menus', 'orders', 'keyword'));
    }

    public function pesananMasuk()
    {
        $orders = Order::with('items.menu')->where('status', 'menunggu_pembayaran')->orderBy('created_at', 'desc')->get();
        return view('admin.pesanan-masuk', compact('orders'));
    }

    public function pesananDiproses()
    {
        $orders = Order::with('items.menu')->where('status', 'diproses')->orderBy('created_at', 'desc')->get();
        return view('admin.pesanan-diproses', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($request->status) {
            $order->update(['status' => $request->status]);
        }
        return redirect()->back()->with('success', 'Status pesanan diubah');
    }

    public function payOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'diproses',
            'metode_pembayaran' => $request->metode_pembayaran,
            'dibayar' => $request->dibayar,
            'kembalian' => $request->kembalian,
        ]);
        return redirect()->route('admin.pesanan-masuk')->with('success', 'Pembayaran berhasil, pesanan sedang diproses.');
    }

    public function updateOrderItems(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $totalHarga = 0;
        
        if ($request->has('items')) {
            foreach ($request->items as $itemId => $qty) {
                $orderItem = OrderItem::where('id', $itemId)->where('order_id', $order->id)->first();
                if ($orderItem) {
                    if ($qty > 0) {
                        $orderItem->update(['qty' => $qty]);
                        $totalHarga += ($orderItem->price * $qty);
                    } else {
                        $orderItem->delete();
                    }
                }
            }
        }
        
        $order->update(['total_harga' => $totalHarga]);
        
        return redirect()->back()->with('success', 'Pesanan ini berhasil di update');
    }

    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();
        return redirect()->back()->with('success', 'Pesanan ini berhasil di hapus');
    }

    public function menu()
    {
        $menus = Menu::with('category')->get();
        return view('admin.menu', compact('menus'));
    }

    public function createMenu()
    {
        $categories = Category::all();
        $mode = 'create';
        return view('admin.menu.form', compact('categories', 'mode'));
    }

    public function showMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        $mode = 'show';
        return view('admin.menu.form', compact('menu', 'categories', 'mode'));
    }

    public function editMenuForm($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        $mode = 'edit';
        return view('admin.menu.form', compact('menu', 'categories', 'mode'));
    }

    public function storeMenu(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|integer',
            'stok' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/menus'), $imageName);
            $data['image'] = 'assets/menus/' . $imageName;
        }

        Menu::create($data);
        return redirect()->route('admin.menu')->with('success', 'Menu ditambahkan');
    }

    public function updateMenu(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'price' => 'required|integer',
            'stok' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $menu = Menu::findOrFail($id);
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('assets/menus'), $imageName);
            $data['image'] = 'assets/menus/' . $imageName;
        }

        $menu->update($data);
        return redirect()->route('admin.menu')->with('success', 'Menu ini berhasil di update');
    }

    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return redirect()->route('admin.menu')->with('success', 'Menu ini berhasil di hapus');
    }

    public function kategori()
    {
        $categories = Category::all();
        return view('admin.kategori', compact('categories'));
    }

    public function storeKategori(Request $request)
    {
        $request->validate(['name' => 'required']);
        Category::create(['name' => $request->name]);
        return redirect()->route('admin.kategori')->with('success', 'Kategori ditambahkan');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name]);
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil di simpan');
    }

    public function destroyKategori($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.kategori')->with('success', 'Kategori berhasil di hapus');
    }

    public function riwayat()
    {
        $orders = Order::with('items.menu')->where('status', 'selesai')->orderBy('created_at', 'desc')->get();
        return view('admin.riwayat', compact('orders'));
    }
}
