<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    // Method index() dan destroy() tidak perlu banyak perubahan
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }


    private function validateProduct(Request $request, Product $product = null)
    {
        $skuRule = ['required', 'string', 'max:255'];
        if ($product) {
            $skuRule[] = Rule::unique('products', 'sku_barcode')->ignore($product->id_produk, 'id_produk');
        } else {
            $skuRule[] = 'unique:products,sku_barcode';
        }

        return $request->validate([
            // Validasi Umum
            'jenis_produk' => ['required', Rule::in(['OBAT', 'SUPLAI'])],
            'nama_produk' => ['required', 'string', 'max:255'],
            'pabrikan' => ['nullable', 'string', 'max:255'],
            'sku_barcode' => $skuRule,
            'kategori' => ['nullable', 'array'], // Menerima array
            'kategori.*' => ['string', 'max:255'], // Memvalidasi setiap item di dalam array
            'digunakan_untuk' => ['nullable', 'string', 'max:255'],
             'gambar_produk' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048'
            ],

            'kontrol_stok' => ['required', 'boolean'],
            'stok_awal' => ['required', 'numeric', 'min:0'],
            'min_stok' => ['required', 'numeric', 'min:0'],
            'max_stok' => ['required', 'numeric', 'min:0'],

            'harga_modal' => ['required', 'numeric', 'min:0'],
            'harga_jual' => ['required', 'numeric', 'min:0'],
            'harga_modal_diskon' => ['nullable', 'numeric', 'min:0'],
            'markup' => ['nullable', 'numeric', 'min:0'],
            'cakupan_harga' => ['required', Rule::in(['Global', 'Lokal'])],
            'harga_spesial' => ['nullable', 'numeric', 'min:0'],


            'kemasan_besar' => ['nullable', 'string', 'max:255'],
            'kemasan_kecil' => ['nullable', 'string', 'max:255'],
            'pembagi_konversi' => ['required', 'numeric', 'min:0'],

            // ===== VALIDASI KONDISIONAL =====
            // Wajib diisi HANYA JIKA jenis_produk adalah OBAT
            'nama_generik' => ['required_if:jenis_produk,OBAT', 'nullable', 'string', 'max:255'],
            'dosis' => ['required_if:jenis_produk,OBAT', 'nullable', 'string', 'max:255'],
            'bentuk_sediaan' => ['required_if:jenis_produk,OBAT', 'nullable', 'string', 'max:255'],
            'batch' => ['required_if:jenis_produk,OBAT', 'nullable', 'string', 'max:255'],
            'tgl_kadaluarsa' => ['required_if:jenis_produk,OBAT', 'nullable', 'date'],

            // Wajib diisi HANYA JIKA jenis_produk adalah SUPLAI
            'no_seri' => ['required_if:jenis_produk,SUPLAI', 'nullable', 'string', 'max:255'],
            'tgl_akhir_garansi' => ['required_if:jenis_produk,SUPLAI', 'nullable', 'date'],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateProduct($request);
         if ($request->hasFile('gambar_produk')) {
            $imagePath = $request->file('gambar_produk')->store('products', 'public'); // Simpan di storage/app/public/products
            $validatedData['gambar_produk'] = $imagePath;
        }
        Product::create($validatedData);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $this->validateProduct($request, $product);
         if ($request->hasFile('gambar_produk')) {

            if ($product->gambar_produk) {
                Storage::disk('public')->delete($product->gambar_produk);
            }

            $imagePath = $request->file('gambar_produk')->store('products', 'public');
            $validatedData['gambar_produk'] = $imagePath;
        }
        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->gambar_produk) {
            Storage::disk('public')->delete($product->gambar_produk);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
