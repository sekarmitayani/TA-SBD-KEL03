<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Barang::with('kategori')->whereNull('deleted_at'); // Ganti is_deleted
        
        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_aset', 'like', "%{$search}%")
                  ->orWhere('spesifikasi', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $barangs = $query->latest()->paginate(10);
        $kategoris = Kategori::all(); // Jika Kategori juga pakai is_deleted, boleh difilter lagi

        return view('barang.index', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'spesifikasi' => 'nullable|string',
            'tanggal_pembelian' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'required|in:tersedia,dipinjam,rusak,dihapus',
            'lokasi' => 'nullable|string|max:255',
            'kode_aset' => 'required|string|max:255|unique:barangs,kode_aset',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang-images', 'public');
            $validated['gambar'] = $path;
        }

        Barang::create($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, Barang $barang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id_kategori',
            'spesifikasi' => 'nullable|string',
            'tanggal_pembelian' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'required|in:tersedia,dipinjam,rusak,dihapus',
            'lokasi' => 'nullable|string|max:255',
            'kode_aset' => 'required|string|max:255|unique:barangs,kode_aset,'.$barang->id_barang.',id_barang',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $path = $request->file('gambar')->store('barang-images', 'public');
            $validated['gambar'] = $path;
        }

        $barang->update($validated);

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Soft delete.
     */
    public function softDelete(Barang $barang)
    {
        $barang->delete(); // ini otomatis soft delete karena pakai trait SoftDeletes

        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil dihapus (soft delete).');
    }

    /**
     * Tampilkan data yang sudah dihapus.
     */
    public function trash()
    {
        $barangs = Barang::onlyTrashed()->with('kategori')->paginate(10);
        return view('barang.trash', compact('barangs'));
    }

    /**
     * Restore data yang soft deleted.
     */
    public function restore($id)
    {
        $barang = Barang::withTrashed()->findOrFail($id);
        $barang->restore();

        return redirect()->route('barang.trash')
            ->with('success', 'Barang berhasil dikembalikan.');
    }

    /**
     * Hard delete (hapus permanen).
     */
    public function destroy($id)
    {
        $barang = Barang::withTrashed()->findOrFail($id);

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->forceDelete(); // Hapus permanen

        return redirect()->route('barang.trash')
            ->with('success', 'Barang berhasil dihapus permanen.');
    }
}
