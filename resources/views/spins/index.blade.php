@extends('layouts.app')

@section('content')
    <div class="w-full max-w-3xl space-y-6 rounded-2xl bg-white p-8 shadow-lg">
        <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 md:flex-row md:items-start md:justify-between">
            <div>
                <h1 class="text-3xl font-bold">Spin Page</h1>
                <p class="mt-2 text-sm text-slate-600">Страница для запуска спина по уникальной ссылке.</p>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <div class="space-y-2 rounded-2xl bg-slate-50 p-6">
            <p class="text-sm text-slate-500">Unique link</p>
            <p class="break-all rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700">
                {{ route('spins.index', $user->spin_uuid) }}
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-semibold">Last result</h2>

                @if ($latestSpin)
                    <div class="mt-4 space-y-2 text-sm text-slate-700">
                        <p><span class="font-semibold">Result:</span> {{ $latestSpin->result }}</p>
                        <p><span class="font-semibold">Points:</span> {{ $latestSpin->points }}</p>
                        <p><span class="font-semibold">Random number:</span> {{ $latestSpin->random_number }}</p>
                    </div>
                @else
                    <p class="mt-4 text-sm text-slate-500">Пока еще нет результатов.</p>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 p-6">
                <h2 class="text-lg font-semibold">Actions</h2>

                <div class="mt-4 grid gap-3">
                    <form method="POST" action="{{ route('spins.store', $user->spin_uuid) }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-500"
                        >
                            Imfeelinglucky
                        </button>
                    </form>

                    <form method="GET" action="{{ route('spins.history', $user->spin_uuid) }}">
                        <button type="submit" class="w-full rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                            History
                        </button>
                    </form>

                    <form method="POST" action="{{ route('spins.regenerate', $user->spin_uuid) }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-800 transition hover:bg-slate-50"
                        >
                            Regenerate link
                        </button>
                    </form>

                    <form method="POST" action="{{ route('spins.deactivate', $user->spin_uuid) }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-red-500"
                        >
                            Deactivate user
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
