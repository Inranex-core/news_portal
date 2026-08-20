<x-app-layout>

    <div class="min-h-screen bg-slate-50 py-10">

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumbs --}}
            <nav class="flex text-sm font-medium text-slate-500 mb-6 gap-2 items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600 transition">{{ __('Dashboard') }}</a>
                <span>/</span>
                <a href="{{ route('admin.advertisements.index') }}" class="hover:text-red-600 transition">{{ __('Advertisements') }}</a>
                <span>/</span>
                <span class="text-slate-800 font-bold">{{ __('Create') }}</span>
            </nav>

            {{-- Form Card --}}
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="bg-slate-900 text-white p-6 sm:p-8">
                    <span class="text-xs font-black uppercase tracking-widest text-amber-400 bg-amber-950/80 px-3 py-1 rounded-full">
                        📢 {{ __('CAMPAIGN BUILDER') }}
                    </span>
                    <h1 class="text-2xl font-black mt-2">
                        {{ __('Create New Advertisement Banner') }}
                    </h1>
                </div>

                <form action="{{ route('admin.advertisements.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-6">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Advertisement Title / Headline') }} *
                        </label>
                        <input
                            type="text"
                            name="title"
                            required
                            placeholder="{{ __('e.g., Admission Open 2026 - Comilla University Computer Science') }}"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3"
                            value="{{ old('title') }}"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Target Website URL (Optional)') }}
                        </label>
                        <input
                            type="url"
                            name="url"
                            placeholder="https://example.com"
                            class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3"
                            value="{{ old('url') }}"
                        >
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Banner Placement Position') }} *
                        </label>
                        <select name="placement" required class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="header_top">{{ __('Header Top Banner') }}</option>
                            <option value="sidebar">{{ __('Sidebar Banner') }}</option>
                            <option value="in_article">{{ __('In-Article Reading Banner') }}</option>
                            <option value="footer">{{ __('Footer Banner') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            {{ __('Status') }} *
                        </label>
                        <select name="status" required class="w-full text-sm rounded-xl border-slate-300 focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="1">{{ __('Active (Enabled)') }}</option>
                            <option value="0">{{ __('Inactive (Disabled)') }}</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <a href="{{ route('admin.advertisements.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-700">
                            ← {{ __('Back to Advertisements') }}
                        </a>

                        <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm px-8 py-3 rounded-xl transition shadow-sm">
                            {{ __('Save & Activate Banner') }}
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</x-app-layout>
