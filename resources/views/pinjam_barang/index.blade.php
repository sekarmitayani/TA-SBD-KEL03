@extends('components.app-layout')

@section('title', 'Daftar Peminjaman Barang')

@section('content')
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-4">Daftar Peminjaman Barang</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:justify-between items-center mb-4 gap-4">
            <a href="{{ route('pinjam_barang.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">
            + Tambah Peminjaman
        </a>
    </div>
    <div class="bg-white shadow-md rounded-lg p-6 overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Barang</th>
                    <th class="px-4 py-2 border">Tanggal Pinjam</th>
                    <th class="px-4 py-2 border">Rencana Kembali</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $data)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $data->barang->nama_barang }}</td>
                    <td class="px-4 py-2 border">{{ date('d M Y', strtotime($data->tanggal_pinjam)) }}</td>
                    <td class="px-4 py-2 border">{{ date('d M Y', strtotime($data->tanggal_kembali_rencana)) }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 text-white rounded 
                            @if($data->status_pinjam == 'dipinjam') bg-blue-500
                            @elseif($data->status_pinjam == 'terlambat') bg-red-500
                            @else bg-green-500 @endif">
                            {{ ucfirst($data->status_pinjam) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border flex flex-wrap gap-2">
                        <a href="{{ route('pinjam_barang.show', $data->id_pinjam_barang) }}" class="bg-blue-500 text-white px-3 py-1 rounded text hover:bg-blue-600">Detail</a>
                        <a href="{{ route('pinjam_barang.edit', $data->id_pinjam_barang) }}" class="bg-yellow-500 text-white px-3 py-1 rounded text hover:bg-yellow-600">Edit</a>
                        <form action="{{ route('pinjam_barang.destroy', $data->id_pinjam_barang) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text hover:bg-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $peminjaman->links() }}
    </div>
</div>
@endsection
