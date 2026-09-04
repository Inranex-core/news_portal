<x-app-layout>

    <div class="min-h-screen bg-slate-100/80 pb-16" style="background-color: #f1f5f9;">

        {{-- Top Hero Header Card with Guaranteed Contrast --}}
        <div style="background: linear-gradient(135deg, #4c0519 0%, #881337 50%, #0f172a 100%); color: #ffffff; padding: 36px 0; border-bottom: 3px solid #9f1239; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center;">

                    {{-- Reporter Avatar & Profile Detail --}}
                    <div class="flex items-center gap-5" style="display: flex; align-items: center; gap: 20px;">
                        <div class="relative shrink-0" style="position: relative;">
                            @if($profile && $profile->profile_image)
                                <img
                                    src="{{ asset('storage/' . $profile->profile_image) }}"
                                    alt="{{ auth()->user()->name }}"
                                    class="w-20 h-20 md:w-24 md:h-24 rounded-2xl object-cover shadow-xl"
                                    style="width: 88px; height: 88px; border-radius: 16px; border: 3px solid rgba(255,255,255,0.3); object-fit: cover;"
                                >
                            @else
                                <div
                                    class="w-20 h-20 md:w-24 md:h-24 rounded-2xl font-black text-3xl flex items-center justify-center shadow-xl"
                                    style="width: 88px; height: 88px; border-radius: 16px; border: 3px solid rgba(255,255,255,0.3); background: linear-gradient(135deg, #e11d48, #9f1239); color: #ffffff; font-size: 32px; font-weight: 900; display: flex; align-items: center; justify-content: center;"
                                >
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif

                            @if($profile?->is_verified)
                                <div style="position: absolute; bottom: -4px; right: -4px; background: #10b981; color: #ffffff; border-radius: 9999px; padding: 4px; border: 2px solid #0f172a; display: flex; align-items: center; justify-content: center;" title="Verified Reporter">
                                    <svg style="width: 14px; height: 14px;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="flex items-center gap-3 flex-wrap" style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                <h1 style="color: #ffffff !important; font-size: 28px; font-weight: 900; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                    {{ auth()->user()->name }}
                                </h1>

                                @if($profile?->is_verified)
                                    <span style="background: rgba(16, 185, 129, 0.25); color: #6ee7b7; border: 1px solid rgba(16, 185, 129, 0.4); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        ✓ {{ __('Verified Journalist') }}
                                    </span>
                                @else
                                    <span style="background: rgba(245, 158, 11, 0.25); color: #fde68a; border: 1px solid rgba(245, 158, 11, 0.4); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        ⏳ {{ __('Verification Pending') }}
                                    </span>
                                @endif
                            </div>

                            <p style="color: #fecdd3 !important; font-size: 14px; font-weight: 600; margin-top: 6px;">
                                {{ $profile->display_designation }}
                                @if($profile?->display_organization)
                                    <span style="color: #cbd5e1; font-weight: 400;"> • {{ $profile->display_organization }}</span>
                                @endif
                            </p>

                            @if($profile?->location)
                                <p style="color: #cbd5e1 !important; font-size: 12px; margin-top: 4px;">
                                    📍 {{ $profile->location }}
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Header Action Buttons with Explicit Bulletproof Inline Style --}}
                    <div class="flex items-center gap-3 shrink-0" style="display: flex; align-items: center; gap: 12px;">
                        @if(auth()->user()->isApproved())
                            <a
                                href="{{ route('journalist.articles.create') }}"
                                style="background-color: #ffffff !important; color: #881337 !important; font-weight: 900 !important; font-size: 14px; padding: 12px 22px; border-radius: 12px; border: 1px solid #ffffff; box-shadow: 0 4px 14px rgba(0,0,0,0.25); display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: transform 0.2s;"
                            >
                                <svg style="width: 18px; height: 18px; color: #be123c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('Write New Article') }}</span>
                            </a>
                        @else
                            <button
                                type="button"
                                disabled
                                title="{{ __('Disabled: Account Pending Admin Approval') }}"
                                style="background-color: #cbd5e1 !important; color: #64748b !important; font-weight: 700 !important; font-size: 14px; padding: 12px 22px; border-radius: 12px; border: 1px solid #94a3b8; opacity: 0.65; cursor: not-allowed; display: inline-flex; align-items: center; gap: 8px;"
                            >
                                🔒 <span>{{ __('Write New Article') }}</span>
                            </button>
                        @endif

                        @if($profile?->slug)
                            <a
                                href="{{ route('journalists.show', $profile->slug) }}"
                                target="_blank"
                                style="background-color: rgba(255, 255, 255, 0.15) !important; color: #ffffff !important; font-weight: 700 !important; font-size: 13px; padding: 12px 18px; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.3); display: inline-flex; align-items: center; gap: 6px; text-decoration: none;"
                            >
                                <span>🌐</span>
                                <span>{{ __('View Portfolio') }}</span>
                            </a>
                        @endif
                    </div>

                </div>

            </div>
        </div>


        {{-- Main Dashboard Content --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8" style="margin-top: 24px;">

            @if(!auth()->user()->isApproved())
                <div style="background: #fffbeb; border: 2px solid #f59e0b; padding: 20px; border-radius: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.15);">
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <div style="font-size: 32px;">⏳</div>
                        <div>
                            <h3 style="font-size: 16px; font-weight: 900; color: #78350f; margin: 0;">
                                {{ __('Account Pending Admin Approval') }}
                            </h3>
                            <p style="font-size: 13px; font-weight: 600; color: #92400e; margin: 4px 0 0 0;">
                                {{ __('Your account is waiting for admin approval. You can view your ID & dashboard details, but writing articles, updating profile, and action buttons are disabled until an Admin approves your account.') }}
                            </p>
                        </div>
                    </div>
                    <span style="background: #fde68a; color: #78350f; font-size: 12px; font-weight: 900; padding: 6px 16px; border-radius: 9999px; border: 1px solid #f59e0b; whitespace: nowrap;">
                        🔒 {{ __('Read Only Mode') }}
                    </span>
                </div>
            @endif

            {{-- 1. Metrics Cards Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">

                {{-- Total Articles --}}
                <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-between; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">{{ __('Total Articles') }}</span>
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff1f2; color: #e11d48; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            📰
                        </div>
                    </div>
                    <p style="font-size: 32px; font-weight: 900; color: #0f172a; margin: 12px 0 0 0;">
                        {{ $articlesCount ?? 0 }}
                    </p>
                    <a href="{{ route('journalist.articles.index') }}" style="font-size: 12px; font-weight: 800; color: #be123c; text-decoration: none; margin-top: 8px; display: inline-block;">
                        {{ __('View List') }} →
                    </a>
                </div>

                {{-- Published --}}
                <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; border-left: 5px solid #10b981; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-between; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">{{ __('Published') }}</span>
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900;">
                            ✓
                        </div>
                    </div>
                    <p style="font-size: 32px; font-weight: 900; color: #059669; margin: 12px 0 0 0;">
                        {{ $publishedArticlesCount ?? 0 }}
                    </p>
                    <span style="font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 8px; display: block;">{{ __('Live on portal') }}</span>
                </div>

                {{-- Pending --}}
                <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; border-left: 5px solid #f59e0b; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-between; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">{{ __('Pending Review') }}</span>
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            ⏳
                        </div>
                    </div>
                    <p style="font-size: 32px; font-weight: 900; color: #d97706; margin: 12px 0 0 0;">
                        {{ $pendingArticlesCount ?? 0 }}
                    </p>
                    <span style="font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 8px; display: block;">{{ __('Under Admin review') }}</span>
                </div>

                {{-- Experience --}}
                <div style="background: #ffffff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; border-left: 5px solid #6366f1; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                    <div style="display: flex; justify-between; align-items: center; justify-content: space-between;">
                        <span style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">{{ __('Experience') }}</span>
                        <div style="width: 40px; height: 40px; border-radius: 10px; background: #e0e7ff; color: #4f46e5; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                            🎓
                        </div>
                    </div>
                    <p style="font-size: 32px; font-weight: 900; color: #0f172a; margin: 12px 0 0 0;">
                        {{ $profile?->experience_years ?? 0 }} <span style="font-size: 14px; font-weight: 600; color: #64748b;">{{ __('Yrs') }}</span>
                    </p>
                    <span style="font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 8px; display: block;">{{ __('Professional Years') }}</span>
                </div>

            </div>


            {{-- 2. Two-Column Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8" style="margin-top: 28px;">

                {{-- LEFT COLUMN: Recent Articles & Profile (8 Cols) --}}
                <div class="lg:col-span-8 space-y-8">

                    {{-- Recent Articles Card --}}
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden;">
                        <div style="padding: 20px 24px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                            <div>
                                <h2 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 10px; height: 10px; border-radius: 9999px; background: #be123c; display: inline-block;"></span>
                                    {{ __('My Recent News Articles') }}
                                </h2>
                                <p style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                    {{ __('Latest articles authored and submitted by you') }}
                                </p>
                            </div>

                            <a
                                href="{{ route('journalist.articles.create') }}"
                                style="background: #be123c !important; color: #ffffff !important; font-weight: 800 !important; font-size: 13px; padding: 10px 18px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 6px rgba(190, 18, 60, 0.3);"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>{{ __('Write Article') }}</span>
                            </a>
                        </div>

                        @if(isset($latestArticles) && $latestArticles->count() > 0)
                            <div style="overflow-x: auto;">
                                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                                    <thead>
                                        <tr style="background: #f8fafc; color: #475569; font-size: 11px; font-weight: 800; text-transform: uppercase; border-bottom: 1px solid #e2e8f0;">
                                            <th style="padding: 14px 20px;">{{ __('Article Title') }}</th>
                                            <th style="padding: 14px 16px;">{{ __('Category') }}</th>
                                            <th style="padding: 14px 16px;">{{ __('Status') }}</th>
                                            <th style="padding: 14px 16px;">{{ __('Date') }}</th>
                                            <th style="padding: 14px 20px; text-align: right;">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #334155;">
                                        @foreach($latestArticles as $art)
                                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                                <td style="padding: 16px 20px; font-weight: 800; color: #0f172a; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                    {{ $art->display_title }}
                                                </td>
                                                <td style="padding: 16px;">
                                                    <span style="background: #fff1f2; color: #be123c; border: 1px solid #ffe4e6; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 6px;">
                                                        {{ $art->category->display_name }}
                                                    </span>
                                                </td>
                                                <td style="padding: 16px;">
                                                    @if($art->status === 'published')
                                                        <span style="background: #d1fae5; color: #065f46; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                            ✓ {{ __('Published') }}
                                                        </span>
                                                    @elseif($art->status === 'pending')
                                                        <span style="background: #fef3c7; color: #92400e; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                            ⏳ {{ __('Pending Review') }}
                                                        </span>
                                                    @elseif($art->status === 'rejected')
                                                        <span style="background: #fee2e2; color: #991b1b; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 9999px; display: inline-flex; align-items: center; gap: 4px;">
                                                            ❌ {{ __('Rejected') }}
                                                        </span>
                                                    @else
                                                        <span style="background: #f1f5f9; color: #475569; font-size: 11px; font-weight: 800; padding: 4px 10px; border-radius: 9999px;">
                                                            📝 {{ __('Draft') }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td style="padding: 16px; color: #64748b; font-size: 12px; font-weight: 600;">
                                                    {{ $art->created_at->format('M d, Y') }}
                                                </td>
                                                <td style="padding: 16px 20px; text-align: right;">
                                                    <a href="{{ route('journalist.articles.edit', $art->id) }}" style="color: #2563eb; font-weight: 800; text-decoration: none; margin-right: 12px; font-size: 12px;">
                                                        ✏️ {{ __('Edit') }}
                                                    </a>
                                                    @if($art->status === 'published')
                                                        <a href="{{ route('articles.show', $art->slug) }}" target="_blank" style="color: #059669; font-weight: 800; text-decoration: none; font-size: 12px;">
                                                            👁️ {{ __('View Live') }}
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div style="padding: 16px; background: #f8fafc; border-top: 1px solid #f1f5f9; text-align: center;">
                                <a href="{{ route('journalist.articles.index') }}" style="font-size: 13px; font-weight: 800; color: #475569; text-decoration: none;">
                                    {{ __('View All My Articles') }} ({{ $articlesCount ?? 0 }}) →
                                </a>
                            </div>
                        @else
                            <div style="text-align: center; padding: 48px 16px; background: #f8fafc;">
                                <p style="color: #64748b; font-size: 14px; font-weight: 600;">{{ __('No news articles written yet.') }}</p>
                                <a href="{{ route('journalist.articles.create') }}" style="display: inline-block; margin-top: 12px; background: #be123c; color: #ffffff; font-weight: 800; font-size: 13px; padding: 10px 20px; border-radius: 12px; text-decoration: none;">
                                    + {{ __('Write Your First Article') }}
                                </a>
                            </div>
                        @endif
                    </div>


                    {{-- Biography & Background Card --}}
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); padding: 28px; margin-top: 24px;">
                        <div style="display: flex; justify-between; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 16px;">
                            <h3 style="font-size: 16px; font-weight: 900; color: #0f172a; margin: 0;">
                                📝 {{ __('Biography & Journalist Bio') }}
                            </h3>
                            <a href="{{ route('journalist.profile.edit') }}" style="font-size: 12px; font-weight: 800; color: #be123c; text-decoration: none;">
                                {{ __('Edit Bio') }}
                            </a>
                        </div>

                        @if($profile?->display_bio)
                            <p style="color: #334155; font-size: 14px; line-height: 1.7; margin: 0;">
                                {{ $profile->display_bio }}
                            </p>
                        @else
                            <p style="color: #94a3b8; font-size: 13px; font-style: italic; margin: 0;">
                                {{ __('No biography added yet. Complete your profile to share your journalism background with readers.') }}
                            </p>
                        @endif
                    </div>

                </div>


                {{-- RIGHT COLUMN: Shortcuts & Status (4 Cols) --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- Quick Action Shortcuts Card --}}
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); padding: 24px;">
                        <h3 style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0 0 16px 0; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
                            {{ __('Journalist Shortcuts') }}
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            <a
                                href="{{ route('journalist.articles.create') }}"
                                style="display: flex; justify-between; align-items: center; justify-content: space-between; padding: 14px 16px; background: #fff1f2; color: #881337; border: 1px solid #ffe4e6; border-radius: 12px; font-weight: 800; font-size: 13px; text-decoration: none;"
                            >
                                <span style="display: flex; align-items: center; gap: 8px;">
                                    ✍️ {{ __('Write New Article') }}
                                </span>
                                <span>→</span>
                            </a>

                            <a
                                href="{{ route('journalist.articles.index') }}"
                                style="display: flex; justify-between; align-items: center; justify-content: space-between; padding: 14px 16px; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;"
                            >
                                <span style="display: flex; align-items: center; gap: 8px;">
                                    📰 {{ __('Manage My Articles') }}
                                </span>
                                <span>→</span>
                            </a>

                            <a
                                href="{{ route('journalist.profile.edit') }}"
                                style="display: flex; justify-between; align-items: center; justify-content: space-between; padding: 14px 16px; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;"
                            >
                                <span style="display: flex; align-items: center; gap: 8px;">
                                    ⚙️ {{ __('Edit Profile Details') }}
                                </span>
                                <span>→</span>
                            </a>

                            @if($profile?->slug)
                                <a
                                    href="{{ route('journalists.show', $profile->slug) }}"
                                    target="_blank"
                                    style="display: flex; justify-between; align-items: center; justify-content: space-between; padding: 14px 16px; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; border-radius: 12px; font-weight: 700; font-size: 13px; text-decoration: none;"
                                >
                                    <span style="display: flex; align-items: center; gap: 8px;">
                                        🌐 {{ __('View Public Portfolio') }}
                                    </span>
                                    <span>↗</span>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Verification & Account Status --}}
                    <div style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); padding: 24px; margin-top: 24px;">
                        <h3 style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0 0 12px 0;">
                            {{ __('Verification Status') }}
                        </h3>

                        @if($profile?->is_verified)
                            <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; border-radius: 12px; padding: 16px;">
                                <div style="font-size: 14px; font-weight: 900; color: #064e3b; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                    <span>✓</span> {{ __('Verified Correspondent') }}
                                </div>
                                <p style="font-size: 12px; color: #047857; margin: 0; line-height: 1.5;">
                                    {{ __('Your journalist profile has been verified by the editorial team.') }}
                                </p>
                            </div>
                        @else
                            <div style="background: #fffbeb; border: 1px solid #fde68a; color: #92400e; border-radius: 12px; padding: 16px;">
                                <div style="font-size: 14px; font-weight: 900; color: #78350f; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                                    <span>⏳</span> {{ __('Pending Editorial Review') }}
                                </div>
                                <p style="font-size: 12px; color: #b45309; margin: 0; line-height: 1.5;">
                                    {{ __('Complete your bio and professional information to get verified.') }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{-- Expertise Tags --}}
                    @if($profile?->expertises && $profile->expertises->count() > 0)
                        <div style="background: #ffffff; border-radius: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); padding: 24px; margin-top: 24px;">
                            <h3 style="font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin: 0 0 12px 0;">
                                {{ __('Areas of Expertise') }}
                            </h3>

                            <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                @foreach($profile->expertises as $expertise)
                                    <span style="background: #fff1f2; color: #be123c; font-size: 12px; font-weight: 800; padding: 6px 12px; border-radius: 8px; border: 1px solid #ffe4e6;">
                                        {{ $expertise->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>