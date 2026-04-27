@extends('layouts.app')

@section('content')
    <div class="w-full max-w-xl rounded-2xl bg-white p-8 shadow-lg">
        <div class="mb-8">
            <h1 class="text-3xl font-bold">Spin Registration</h1>
            <p class="mt-2 text-sm text-slate-600">Создайте пользователя и получите уникальную ссылку для спина.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Name</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-slate-500"
                    placeholder="John Doe"
                >
            </div>

            <div>
                <label for="phone" class="mb-2 block text-sm font-medium text-slate-700">Phone</label>
                <input
                    id="phone"
                    name="phone"
                    type="text"
                    value="{{ old('phone') }}"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-slate-500"
                    placeholder="+1 555 123 4567"
                >
            </div>

            <button
                type="submit"
                class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700"
            >
                Create user
            </button>
        </form>
    </div>
@endsection
