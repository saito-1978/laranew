{{-- src/resources/views/layouts/common.blade.php継承 --}}
@extends('layouts.common')

@include('user.parts.sidebar_user')
@section('content')


<div class="h-screen overflow-y-scroll">
    <div class="px-4 sm:px-4">
        <div class="flex justify-between">
            <div class="text-2xl font-bold pt-7">ブックマーク登録済み一覧</div>
            
        </div>
        <div class="py-4">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    タイトル
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    投稿ID
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    カテゴリー
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    記事本文
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    最終更新日時
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                                    操作
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    PV数
                                </th>
                                <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-center text-sm uppercase font-normal">
                                    お気に入り数
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookmarks as $bookmark)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm w-40">
                                <a href="" class="hover:underline">
                                    <p class="text-left text-gray-900 whitespace-no-wrap">
                                        {{ $bookmark->title }}
                                    </p>
                                </a>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-center text-gray-900 whitespace-no-wrap">
                                        {{ $bookmark->id }}
                                    </p>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <span class="relative inline-block px-3 py-1 font-semibold text-white leading-tight">
                                        <span aria-hidden="true" class="absolute inset-0 bg-green-500 rounded-full">
                                        </span>
                                        <span class="relative">
                                            @if (isset($bookmark->category_id))
                                                {{ $bookmark->category->category_name }}
                                            @else
                                                カテゴリーなし
                                            @endif
                                        </span>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <p class="text-center text-gray-900 whitespace-no-wrap">
                                        {{ $bookmark->body }}
                                    </p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div>
    {{ $bookmarks->links() }}
    </div>
</div>
@endsection