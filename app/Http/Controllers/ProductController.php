<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $data = Cache::remember('all-products', 60, function () use($search, $filter){
            $data = Product::with(['category']);

            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            }

            if ($filter) {
                $data->where(function ($query) use ($filter) {
                    $query->where('category_id', '=', $filter);
                });
            }
            return $data->get();
        });

        return view('admin.pages.product.list', compact('data'), [
            'title' => 'List Product'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('form product')) {
            return redirect()->route('product.index')->with('notif', 'Tidak ada akses !!!');
        }
        $product = new Product();

        return view('admin.pages.product.form', [
            'product' => $product,
            'title' => 'Create a new product',
            'categories' => Category::where('status', 'active')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            $data['image'] = $image->store('images/product', 'public');
        }
        Product::create($data);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if (!Auth::user()->hasPermissionTo('form product')) {
            return redirect()->route('product.index')->with('notif', 'Tidak ada akses !!!');
        }

        return view('admin.pages.product.form', [
            'title' => 'Edit Product',
            'product' => $product,
            'categories' => Category::where('status', 'active')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->all();
        $image = $request->file('image');
        if ($image) {
            // cek apakah file lama ada didalam folder?
            $exists = File::exists(storage_path('app/public/') . $product->image);
            if ($exists) {
                // delete file lama tersebut
                File::delete(storage_path('app/public/') . $product->image);
            }
            // upload file baru
            $data['image'] = $image->store('images/product', 'public');
        }
        $product->update($data);

        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if (!Auth::user()->hasPermissionTo('form product')) {
            return redirect()->route('product.index')->with('notif', 'Tidak ada akses !!!');
        }
        $product->destroy($product->id);
        File::delete(storage_path('app/public/') . $product->image);

        return redirect()->route('product.index')->with('notif', 'Data Berhasil di Hapus');
    }
}
