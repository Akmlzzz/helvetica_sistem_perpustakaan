@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
    <!-- Header Section -->
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Manajemen Banner Hero
        </h2>
        <a href="{{ route('admin.hero-banners.create') }}"
            class="inline-flex items-center justify-center gap-2.5 rounded-xl bg-brand-primary px-4 py-2 text-center font-medium text-white hover:bg-opacity-90 lg:px-6 xl:px-8">
            <svg class="fill-current" width="20" height="20" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4.16666V15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                <path d="M4.16669 10H15.8334" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            Tambah Banner
        </a>
    </div>

    <!-- Table Section -->
    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="min-w-[50px] px-4 py-4 font-medium text-black dark:text-white xl:pl-11">Order</th>
                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">Background</th>
                        <th class="min-w-[120px] px-4 py-4 font-medium text-black dark:text-white">Title & Char</th>
                        <th class="min-w-[220px] px-4 py-4 font-medium text-black dark:text-white">Info</th>
                        <th class="min-w-[100px] px-4 py-4 font-medium text-black dark:text-white">Status</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td class="border-b border-[#eee] px-4 py-5 pl-9 dark:border-strokedark xl:pl-11">
                            <h5 class="font-medium text-black dark:text-white">{{ $banner->order_priority }}</h5>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <div class="h-16 w-24 rounded-md overflow-hidden">
                                <img src="{{ Storage::url($banner->bg_img) }}" alt="BG" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <div class="flex gap-2">
                                @if($banner->title_img)
                                <div class="h-12 w-12 rounded bg-gray-100 p-1">
                                    <img src="{{ Storage::url($banner->title_img) }}" alt="Title" class="h-full w-full object-contain">
                                </div>
                                @endif
                                @if($banner->char_img)
                                <div class="h-12 w-12 rounded bg-gray-100 p-1">
                                    <img src="{{ Storage::url($banner->char_img) }}" alt="Char" class="h-full w-full object-contain">
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <p class="text-sm text-black dark:text-white line-clamp-2">{{ $banner->synopsis }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $banner->tags }}</p>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <span class="inline-flex rounded-full bg-{{ $banner->is_active ? 'success' : 'danger' }}/10 px-3 py-1 text-sm font-medium text-{{ $banner->is_active ? 'success' : 'danger' }}">
                                {{ $banner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                            <div class="flex items-center space-x-3.5">
                                <a href="{{ route('admin.hero-banners.edit', $banner->id) }}" class="hover:text-primary">
                                    <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.99981 14.8219C3.43106 14.8219 0.674805 9.50624 0.562305 9.28124C0.47793 9.11249 0.47793 8.88749 0.562305 8.71874C0.674805 8.49374 3.43106 3.17812 8.99981 3.17812C14.5686 3.17812 17.3248 8.49374 17.4373 8.71874C17.5217 8.88749 17.5217 9.11249 17.4373 9.28124C17.3248 9.50624 14.5686 14.8219 8.99981 14.8219ZM1.88418 8.99999C2.55918 10.1812 4.97793 13.5 8.99981 13.5C13.0217 13.5 15.4404 10.1812 16.1154 8.99999C15.4404 7.81874 13.0217 4.49999 8.99981 4.49999C4.97793 4.49999 2.55918 7.81874 1.88418 8.99999Z" fill="" />
                                        <path d="M9.00019 11.3906C7.67832 11.3906 6.60957 10.3219 6.60957 9C6.60957 7.67813 7.67832 6.60938 9.00019 6.60938C10.3221 6.60938 11.3908 7.67813 11.3908 9C11.3908 10.3219 10.3221 11.3906 9.00019 11.3906ZM9.00019 7.93125C8.40957 7.93125 7.93145 8.40938 7.93145 9C7.93145 9.59063 8.40957 10.0688 9.00019 10.0688C9.59082 10.0688 10.0689 9.59063 10.0689 9C10.0689 8.40938 9.59082 7.93125 9.00019 7.93125Z" fill="" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.hero-banners.destroy', $banner->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="hover:text-danger">
                                        <svg class="fill-current" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M13.7535 2.47502H11.5879V1.9969C11.5879 1.15315 10.9129 0.478149 10.0691 0.478149H7.90352C7.05977 0.478149 6.38477 1.15315 6.38477 1.9969V2.47502H4.21914C3.40352 2.47502 2.72852 3.15002 2.72852 3.96565V4.8094C2.72852 5.42815 3.09414 5.9344 3.62852 6.1594L4.07852 15.4688C4.13477 16.6219 5.09102 17.5219 6.24414 17.5219H11.7285C12.8816 17.5219 13.8379 16.6219 13.8941 15.4688L14.3441 6.1594C14.8785 5.9344 15.2441 5.42815 15.2441 4.8094V3.96565C15.2441 3.15002 14.5691 2.47502 13.7535 2.47502ZM7.67852 1.9969C7.67852 1.85627 7.79102 1.74377 7.93164 1.74377H10.041C10.1816 1.74377 10.2941 1.85627 10.2941 1.9969V2.47502H7.67852V1.9969ZM12.6004 15.4406C12.5723 15.8344 12.2348 16.1438 11.841 16.1438H6.13164C5.73789 16.1438 5.40039 15.8344 5.37227 15.4406L4.95039 6.2719H13.0223L12.6004 15.4406ZM13.9785 4.8094C13.9785 4.9219 13.8941 5.00627 13.7816 5.00627H4.19102C4.07852 5.00627 3.99414 4.9219 3.99414 4.8094V3.96565C3.99414 3.85315 4.07852 3.76877 4.19102 3.76877H13.7816C13.8941 3.76877 13.9785 3.85315 13.9785 3.96565V4.8094Z" fill="" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-5 text-center text-gray-500">Belum ada banner yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
