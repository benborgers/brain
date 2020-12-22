<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Folder;
use App\Models\Notecard;
use App\Models\Collection;

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

        Gate::define('see-folder', function ($user, Folder $folder) {
            return $folder->owner->is($user);
        });

        Gate::define('see-notecard', function ($user = null, Notecard $notecard) {
            if($notecard->folder->owner->is($user)) {
                return true;
            }

            $collectionWhereThisNotecardIsPublished = Collection::whereJsonContains('notecards', (string) $notecard->id)->first();
            if($collectionWhereThisNotecardIsPublished) {
                return true;
            }
        });

        Gate::define('edit-notecard', function ($user, Notecard $notecard) {
            return $notecard->folder->owner->is($user);
        });
    }
}
