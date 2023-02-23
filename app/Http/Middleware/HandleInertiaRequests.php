<?php

namespace App\Http\Middleware;

use App\Services\Site\SiteReadService;
use App\Services\Hard\HardReadService;
use App\Services\Voice\VoiceReadService;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * コンストラクタ
     */
    function __construct(
        private SiteReadService $siteReadService,
        private HardReadService $hardReadService,
        private VoiceReadService $voiceReadService,
    ) {
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'const' => config('const'),
            'search_sites' => $this->siteReadService->getSiteList(),
            'search_voices' => $this->voiceReadService->getVoiceList(),
            'search_hards'  => $this->hardReadService->getHardList(),
        ]);
    }
}
