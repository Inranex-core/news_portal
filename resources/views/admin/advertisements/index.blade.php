<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Header --}}
            <div class="bg-white p-6 sm:p-8 rounded-3xl shadow-sm border border-slate-200 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                        📢 {{ __('SPONSORSHIPS & CAMPAIGNS') }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">
                        {{ __('Advertisement Banners') }}
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">
                        {{ __('Manage sponsored advertisements, campaign links, and banner status.') }}
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 font-bold text-xs hover:bg-slate-50 transition">
                        ← {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('admin.advertisements.create') }}" class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs transition shadow-sm flex items-center gap-1.5">
                        <span>➕</span>
                        <span>{{ __('Create New Ad') }}</span>
                    </a>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-sm font-bold flex items-center gap-2">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Advertisements Table --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h2 class="text-lg font-black text-slate-900">
                        {{ __('Active & Inactive Banners') }}
                    </h2>
                    <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                        {{ __('Total Ads:') }} {{ $advertisements->total() }}
                    </span>
                </div>

                @if($advertisements->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">{{ __('Photocard') }}</th>
                                    <th class="px-6 py-4">{{ __('Title & Target URL') }}</th>
                                    <th class="px-6 py-4">{{ __('Placement Location') }}</th>
                                    <th class="px-6 py-4">{{ __('Stats') }}</th>
                                    <th class="px-6 py-4">{{ __('Status') }}</th>
                                    <th class="px-6 py-4 text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                                @foreach($advertisements as $ad)
                                    <tr class="hover:bg-slate-50/80 transition">
                                        <td class="px-6 py-4">
                                            @if($ad->type === 'video' && $ad->video)
                                                <div class="w-16 h-12 bg-slate-950 rounded-xl overflow-hidden border border-slate-700 relative group">
                                                    <video src="{{ asset('storage/' . $ad->video) }}" class="w-full h-full object-cover"></video>
                                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center text-white text-xs">
                                                        ▶
                                                    </div>
                                                </div>
                                            @elseif($ad->image)
                                                <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ $ad->title }}" class="w-16 h-12 object-cover rounded-xl border border-slate-200 shadow-2xs">
                                            @else
                                                <div class="w-16 h-12 bg-slate-100 rounded-xl border border-dashed border-slate-300 flex items-center justify-center text-xs text-slate-400 font-bold">
                                                    📷 {{ __('Text Ad') }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 max-w-xs">
                                            <div class="flex items-center gap-1.5 mb-0.5">
                                                @if($ad->type === 'video')
                                                    <span class="text-[10px] font-black uppercase bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full border border-purple-200">
                                                        🎥 {{ __('Video') }}
                                                    </span>
                                                @else
                                                    <span class="text-[10px] font-black uppercase bg-slate-100 text-slate-700 px-2 py-0.5 rounded-full border border-slate-200">
                                                        🖼️ {{ __('Image') }}
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="font-bold text-slate-900 truncate">
                                                {{ $ad->title }}
                                            </div>
                                            @if($ad->url)
                                                <a href="{{ $ad->url }}" target="_blank" class="text-xs text-red-600 hover:underline truncate block">
                                                    {{ $ad->url }} ↗
                                                </a>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                                {{ str_replace('_', ' ', $ad->placement) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">
                                                🖱️ {{ number_format($ad->clicks) }} {{ __('clicks') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($ad->status)
                                                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                                                    🟢 {{ __('Active') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-full">
                                                    ⚪ {{ __('Inactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.advertisements.edit', $ad) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-bold transition">
                                                    ✏️ {{ __('Edit') }}
                                                </a>

                                                <form action="{{ route('admin.advertisements.toggle', $ad) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-bold transition {{ $ad->status ? 'bg-amber-100 text-amber-800 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' }}">
                                                        {{ $ad->status ? __('Disable') : __('Enable') }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.advertisements.destroy', $ad) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this advertisement?') }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 text-xs font-bold transition">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-slate-100">
                        {{ $advertisements->links() }}
                    </div>
                @else
                    <div class="py-16 text-center text-slate-400">
                        <span class="text-4xl">📢</span>
                        <h3 class="text-lg font-bold text-slate-700 mt-2">{{ __('No Advertisements Found') }}</h3>
                        <p class="text-xs text-slate-500 mt-1">{{ __('Create your first campaign advertisement banner.') }}</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

</x-app-layout>
