<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('roles:show', function () {
    $roles = Spatie\Permission\Models\Role::pluck('name')->join(', ');
    $this->info("Roles: " . $roles);
});

Artisan::command('roles:fix', function () {
    $role = Spatie\Permission\Models\Role::find(6);
    if ($role) {
        $this->info("ID 6 name is: " . $role->name);
        $role->name = 'Humas';
        $role->save();
        $role->syncPermissions(['view_dashboard', 'view_news', 'manage_news']);
        $this->info("Renamed role ID 6 to Humas");
    } else {
        $this->info("Role ID 6 not found");
    }
    
    $pos = App\Models\Position::where('order', 7)->orWhere('slug', 'like', '%kordinator%')->first();
    if ($pos) {
        $this->info("Position name is: " . $pos->name);
        $pos->name = 'Humas';
        $pos->slug = 'humas';
        $pos->save();
        App\Models\Management::where('position_id', $pos->id)->update(['division_id' => null]);
        $this->info('Renamed Position to Humas');
    }
    app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
});
