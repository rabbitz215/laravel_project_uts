<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Midtrans\Snap;
use Midtrans\Config;
use Ramsey\Uuid\Uuid;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $data = Product::with('category')->where('name', 'like', "%$search%")->paginate(100);
        } else {
            $products = Cache::remember('all-products', 60, function () {
                return Product::with('category')->paginate(100);
            });

            $data = $products;
        }
        return view('admin.pages.checkout.product', [
            'title' => 'List Product',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $productID = $request->input('product_id');
        $qty = (int) $request->input('qty', 1);
        $checkout = [
            'products' => [],
        ];
        $data = Cache::get('checkout', $checkout);
        $temp = null;
        if (isset($data['products'][$productID])) {
            $temp =  [
                "id" => $productID,
                "qty" => $qty + $data['products'][$productID]['qty']
            ];
        } else {
            $temp =  [
                "id" => $productID,
                "qty" => $qty
            ];
        }
        $data['products'][$productID] = $temp;

        Cache::put('checkout', $data);
        Alert::success('Checkout', 'Barang sudah ditambahkan');
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO:
        // save data to database
        // and call midtrans for generate invoce of transaction
        //Mengambil semua request data dari JSON API
        $validator = validator($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required|numeric',
            'total' => 'required|numeric',
        ], [
            'name.required' => 'Nama harus di isi',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email harus di isi',
            'email.email' => 'Email salah',
            'address.required' => 'Alamat harus di isi',
            'phone.required' => 'No HP harus di isi',
        ]);

        $data = $validator->validated();

        //Mengambil semua id dari array collection products
        $productIds = $request->input('product_ids');
        $productPrices = $request->input('price');
        $productQty = $request->input('qty');

        // // //Query untuk mengambil product dengan menggunakan whereIn id array
        $product = Product::whereIn('id', $productIds)->get();

        //memulai session untuk query transaction
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'id' => Uuid::uuid4()->toString(),
                'customer' => $data['name'],
                'address' => $data['address'],
                'total_amount' => $data['total'],
                'phone' => $data['phone'],
                'email' => $data['email'],
            ]);

            $transaction_details = [];

            foreach ($productIds as $key => $value) {
                $product = $product->firstWhere('id', $value);
                $transaction_details[] = [
                    'id' => Uuid::uuid4()->toString(),
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'quantity' => $productQty[$key],
                    'amount' => $productPrices[$key],
                    'created_at' => Carbon::now()
                ];
            }

            if ($transaction_details) {
                TransactionDetail::insert($transaction_details);
            }
            Cache::forget('checkout');

            $transactionJson = json_encode($transaction);

            $apiController = new ApiController();
            $paymentUrl = $apiController->createInvoice($transactionJson);
            //Menyimpan data create ke database
            DB::commit();
            return redirect()->route('checkout.index')->with([
                'alert-type' => 'success',
                'alert-message' => 'Silahkan klik OK untuk melanjutkan pembayaran',
                'paymentUrl' => $paymentUrl,
            ]);;
        } catch (\Throwable $th) {
            //melakukan rollback/membatalkan query jika terjadi kesalahan
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function chart()
    {
        $data = Cache::get('checkout');
        $prices = [];
        $qty = [];
        $id = [];
        if (!empty($data['products'])) {
            foreach ($data['products'] as $product) {
                $id[] = $product['id'];
                $qty[] = $product['qty'];
            }
            $products = Product::whereIn('id', $id)->get();

            foreach ($products as $product) {
                $prices[] = $product->price;
            }

            $totalPrice = 0;

            foreach ($prices as $key => $price) {
                $totalPrice += $price * $qty[$key];
            }

            return view('admin.pages.checkout.chart', compact('data'), [
                'title' => 'My Chart',
                'products' => $products,
                'totalprice' => $totalPrice,
            ]);
        } else {
            Alert::error('My Chart', 'Tidak ada Barang di Chart anda');
            return redirect()->route('checkout.index');
        }
    }
}
