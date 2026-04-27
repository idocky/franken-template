@extends('layouts.app')

@section('content')
    <div class="w-full max-w-3xl space-y-6 rounded-2xl bg-white p-8 shadow-lg">
        <div class="flex items-start justify-between gap-4 border-b border-slate-200 pb-6">
            <div>
                <h1 class="text-3xl font-bold">History</h1>
                <p class="mt-2 text-sm text-slate-600">Последние 3 результата кнопки Imfeelinglucky.</p>
            </div>

            <a
                href="{{ route('spins.index', $user->spin_uuid) }}"
                class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 transition hover:bg-slate-50"
            >
                Назад
            </a>
        </div>

        @if ($history->isEmpty())
            <div class="rounded-2xl border border-slate-200 p-6">
                <p class="text-sm text-slate-500">История пуста.</p>
            </div>
        @else
            <div class="overflow-hidden rounded-xl border border-slate-200">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-slate-500">
                        <tr>
                            <th class="px-4 py-3 font-medium">Result</th>
                            <th class="px-4 py-3 font-medium">Points</th>
                            <th class="px-4 py-3 font-medium">Random</th>
                            <th class="px-4 py-3 font-medium">Created</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white text-slate-700">
                        @foreach ($history as $item)
                            <tr>
                                <td class="px-4 py-3">{{ $item->result }}</td>
                                <td class="px-4 py-3">{{ $item->points }}</td>
                                <td class="px-4 py-3">{{ $item->random_number }}</td>
                                <td class="px-4 py-3">{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
