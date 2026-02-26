@extends('layouts.admin')

@section('title', 'Người dùng')
@section('page-title', 'Người dùng')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Người dùng</h2>
            <p class="text-sm text-gray-500 mt-1">Quản lý tài khoản người dùng</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="bg-gradient-to-r from-red-500 to-orange-500 text-white font-bold py-2 px-6 rounded-lg hover:shadow-lg transition">
            <i class="fas fa-plus mr-2"></i>Thêm người dùng
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Người dùng</th>
                    <th class="text-left px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Vai trò</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                    <th class="text-center px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Bài viết</th>
                    <th class="text-right px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                {{-- Avatar with initial --}}
                                @php
                                    $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-yellow-500', 'bg-pink-500', 'bg-indigo-500', 'bg-teal-500'];
                                    $colorIndex = crc32($user->name) % count($colors);
                                @endphp
                                <div class="w-9 h-9 {{ $colors[$colorIndex] }} rounded-full flex items-center justify-center flex-shrink-0">
                                    <span class="text-white text-sm font-bold">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-500">{{ $user->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->role === 'admin')
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-red-100 text-red-700">Admin</span>
                            @elseif($user->role === 'editor')
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-blue-100 text-blue-700">Editor</span>
                            @else
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-gray-100 text-gray-500">Writer</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($user->is_active)
                                <span class="inline-block w-2.5 h-2.5 bg-green-500 rounded-full" title="Hoạt động"></span>
                            @else
                                <span class="inline-block w-2.5 h-2.5 bg-gray-400 rounded-full" title="Tắt"></span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm text-gray-600">{{ $user->posts_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                          class="inline" onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-users text-3xl mb-3"></i>
                                <p class="text-sm">Chưa có người dùng nào</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    @endif
@endsection
