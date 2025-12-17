<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>
    @extends('layouts.app') 
@section('content') 
<div class="container"> 
<h2>Daftar Lowongan Kerja</h2> 
<!-- Form Pencarian --> 
    <form action="{{ route('jobs.index') }}" method="GET" 
class="mb-4"> 
        <div class="input-group"> 
            <input type="text"  
                   name="search"  
                   class="form-control"  
                   placeholder="Cari berdasarkan title atau 
company..." 
                   value="{{ request('search') }}"> 
            <button class="btn btn-primary" type="submit"> 
                <i class="bi bi-search"></i> Cari 
            </button> 
            @if(request('search')) 
                <a href="{{ route('jobs.index') }}" class="btn 
btn-secondary">Reset</a> 
            @endif 
        </div> 
    </form> 
     
    <!-- Hasil Pencarian --> 
    @if(request('search')) 
        <p class="text-muted">hasil<strong>{{ 
request('search') }}</strong></p> 
    @endif 
     
    <a href="{{ route('jobs.create') }}" class="btn btn-success 
mb-3">Tambah Lowongan</a> 
     
    <table class="table table-bordered"> 
        <thead> 
            <tr> 
                <th>No</th> 
                <th>Title</th> 
                <th>Company</th> 
                <th>Location</th> 
                <th>Salary</th> 
                <th>Action</th> 
            </tr> 
        </thead> 
        <tbody> 
            @forelse($jobs as $job) 
            <tr> 
                <td>{{ $loop->iteration + ($jobs->currentPage() - 
1) * $jobs->perPage() }}</td> 
                <td>{{ $job->title }}</td> 
                <td>{{ $job->company }}</td> 
                <td>{{ $job->location }}</td> 
                <td>{{ $job->salary }}</td> 
                <td> 
                    <a href="{{ route('jobs.show', $job->id) }}" 
class="btn btn-info btn-sm">Detail</a> 
                    <a href="{{ route('jobs.edit', $job->id) }}" 
class="btn btn-warning btn-sm">Edit</a> 
                    <form action="{{ route('jobs.destroy', 
$job->id) }}" method="POST" class="d-inline"> 
                        @csrf 
                        @method('DELETE') 
                        <button type="submit" class="btn 
btn-danger btn-sm"  
                                onclick="return confirm('Yakin 
hapus?')">Hapus</button> 
                    </form> 
                </td> 
            </tr> 
            @empty 
            <tr> 
                <td colspan="6" class="text-center">Tidak ada data</td> 
            </tr> 
            @endforelse 
        </tbody> 
    </table> 
PHP
     
    <!-- Pagination Links --> 
    <div class="d-flex justify-content-center"> 
        {{ $jobs->links() }} 
    </div> 
</div> 
@endsection 

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-lg font-medium text-gray-700">Kelola lowongan kerja yang tersedia.</p>
                        <form action="{{ route('jobs.index') }}" method="GET" class="flex w-full gap-2 sm:w-auto">
                            <input type="search" name="search" value="{{ $search }}" placeholder="Cari judul atau perusahaan" class="">
                            <button type="submit"> Cari </button>
                        </form>
                        <a href="{{ route('jobs.create') }}"
                            class="inline-flex items-center gap-2 rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold shadow transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                            Tambah Lowongan
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Perusahaan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Lokasi</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Gaji</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Logo</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($jobs as $job)
                                    <tr>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->title }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->company }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->location }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $job->salary }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            @if($job->logo)
                                            <img src="{{ asset('storage/' . $job->logo) }}"
                                                alt="Logo {{ $job->company }}"
                                                class="h-12 w-12 rounded object-cover"
                                                width="100px" />
                                            @else
                                            <span class="text-xs text-gray-400">Tidak ada logo</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('jobs.show', $job->id) }}"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-3 py-1 text-xs font-semibold transition hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                                    Show
                                                </a>
                                                {{-- Jika Admin --}}
                                                @if(Auth::check() && Auth::user()->role === 'admin')
                                                <a href="{{ route('applications.index', $job->id) }}"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-3 py-1 text-xs font-semibold transition hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                                    Daftar Pelamar
                                                </a>
                                                <a href="{{ route('jobs.edit', $job->id) }}"
                                                    class="inline-flex items-center rounded-md border border-transparent bg-yellow-500 px-3 py-1 text-xs font-semibold transition hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                                    Edit
                                                </a>
                                                <form action="{{ route('jobs.destroy', $job->id) }}" method="POST" onsubmit="return confirm('Hapus data?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-3 py-1 text-xs font-semibold transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2">
                                                        Hapus
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">
                                            Belum ada lowongan yang tersedia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{--
                        @if($jobs->hasPages())
                        <div class="mt-6">
                            {{ $jobs->links() }}
                        </div>
                        @endif
                        --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>