{{-- layouts.common.blade.phpのレイアウト継承 --}}
@extends('layouts.common')

{{-- ヘッダー呼び出し --}}
@include('common.header')
{{-- サイドバー呼び出し --}}
@include('common.sidebar')
@if(session('success'))
    <div class="alert alert-success bg-violet-200 border-t border-b border-violet-500 text-violet-700 text-center px-4 py-3 font-bold" >
        {{ session('success') }}
    </div>
@endif
{{-- メイン部分作成 --}}
@section('content')
<div class="px-8 py-8 mx-auto bg-white">
    <div class="flex items-center justify-between">
        <span class="text-sm font-light text-gray-600">最終更新日時:{{ $post->updated_at }}</span>
    </div>

    <div class="mt-2">
        <p class="text-2xl font-bold text-gray-800">{{ $post->title }}</p>
        <p class="mt-8 text-gray-600">{{ $post->body }}</p>
    </div>
</div>
@auth
<div class="mt-4 flex justify-end">
      <form method="POST" action="">
        @csrf
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <button type="submit" class="px-6 py-2 inline-flex items-center text-indigo-500 transition ease-in duration-200 uppercase rounded cursor-pointer hover:bg-blue-500 hover:text-white border-2 border-blue-500 focus:outline-none">ブックマーク登録</button>
      </form>
    @endauth
</div>
@endsection
{{-- フッター呼び出し --}}
@include('common.footer')