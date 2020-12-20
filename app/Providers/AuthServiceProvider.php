<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Folder;
use App\Models\Notecard;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('see-folder', function ($user, $folderId) {
            $folder = Folder::findOrFail($folderId);
            return $folder->owner->is($user);
        });

        Gate::define('see-notecard', function ($user, $notecardId) {
            $notecard = Notecard::findOrFail($notecardId);
            return $notecard->folder->owner->is($user);
        });
    }
}
