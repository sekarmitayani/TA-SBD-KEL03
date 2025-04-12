@extends('components.app-layout')

@section('title', 'Barang Dihapus')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Barang Dihapus (Trash)</h1>

    <a href="{{ route('barang.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
        ← Kembali
    </a>

    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2 text-left">Nama Barang</th>
                    <th class="border px-4 py-2 text-left">Kode Aset</th>
                    <th class="border px-4 py-2 text-left">Kategori</th>
                    <th class="border px-4 py-2 text-left">Status</th>
                    <th class="border px-4 py-2 text-left">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $barang)
                <tr class="hover:bg-gray-100">
                    <td class="border px-4 py-2">{{ $barang->nama_barang }}</td>
                    <td class="border px-4 py-2">{{ $barang->kode_aset }}</td>
                    <td class="border px-4 py-2">{{ $barang->kategori->nama_kategori }}</td>
                    <td class="border px-4 py-2 capitalize">{{ $barang->status }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <form action="{{ route('barang.restore', $barang->id_barang) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-green-600 hover:underline">Restore</button>
                        </form>
                        <form action="{{ route('barang.forceDelete', $barang->id_barang) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Hapus permanen barang ini?')">
                                Hapus Permanen
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Tidak ada barang dihapus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination kalau diperlukan -->
        <div class="mt-4">
            {{ $barangs->links() }}
        </div>
    </div>
</div>
@endsection
