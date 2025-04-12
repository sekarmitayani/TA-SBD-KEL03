@extends('components.app-layout')

@section('title', 'Manajemen Pemeliharaan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Manajemen Pemeliharaan</h1>

    <div class="mb-4">
        <a href="{{ route('pemeliharaan.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 text-sm">
            + Tambah Pemeliharaan
        </a>
    </div>

    <div class="bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full text-sm text-left border">
            <thead class="bg-gray-100 text-xs font-semibold uppercase">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Barang</th>
                    <th class="px-4 py-2 border">Tanggal Pemeliharaan</th>
                    <th class="px-4 py-2 border">Deskripsi Masalah</th>
                    <th class="px-4 py-2 border">Tindakan</th>
                    <th class="px-4 py-2 border">Biaya</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Petugas</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemeliharaans as $index => $pemeliharaan)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $pemeliharaans->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border">{{ $pemeliharaan->barang->nama_barang }}</td>
                    <td class="px-4 py-2 border">{{ $pemeliharaan->tanggal_pemeliharaan }}</td>
                    <td class="px-4 py-2 border">{{ $pemeliharaan->deskripsi_masalah }}</td>
                    <td class="px-4 py-2 border">{{ $pemeliharaan->tindakan }}</td>
                    <td class="px-4 py-2 border">{{ number_format($pemeliharaan->biaya, 2, ',', '.') }}</td>
                    <td class="px-4 py-2 border">
                        <span class="inline-block px-2 py-1 text-white rounded 
                            @if($pemeliharaan->status == 'dalam proses') bg-yellow-500
                            @else bg-green-500 @endif">
                            {{ ucwords($pemeliharaan->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">{{ $pemeliharaan->petugas }}</td>
                    <td class="px-4 py-2 border">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('pemeliharaan.edit', $pemeliharaan->id_pemeliharaan) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">Edit</a>
                            <form action="{{ route('pemeliharaan.destroy', $pemeliharaan->id_pemeliharaan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pemeliharaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4 text-gray-500">Tidak ada pemeliharaan ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $pemeliharaans->links() }}
        </div>
    </div>
</div>
@endsection
