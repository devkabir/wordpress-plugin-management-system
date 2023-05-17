<?php

use App\Models\PluginUser;

Route::post('org/support', static function (\Illuminate\Http\Request $request) {
    $origin = '';
    $parsed_domain = parse_url($request->url);

    if (isset($parsed_domain['scheme'])) {
        $origin .= $parsed_domain['scheme'] . '://';
    }
    if (isset($parsed_domain['host'])) {
        $origin .= $parsed_domain['host'];
    }
    if (isset($parsed_domain['port'])) {
        $origin .= ':' . $parsed_domain['port'];
    }

    if (app()->isProduction() && preg_match('/^.*\.(dev|test|local|localhost)$/', $origin)) {
        info($request);
        return response('ok', 200);
    }

    try {
        [$name, $version] = explode(':', $request->name);
        $plugins = $request->plugins;
        $server = $request->server_info;

        $user = PluginUser::where('name', $name)
            ->where('version', $version)
            ->where('website', $origin)
            ->first();

        if (!$user) {
            $user = new PluginUser();
        }

        if ($request->action === 'activate') {
            $user->name = $name;
            $user->version = $version;
            $user->website = $origin;
            $user->status = PluginUser::ACTIVE;
            $user->activated_at = now();
        } elseif ($request->action === 'deactivate') {
            $user->status = PluginUser::INACTIVE;
            $user->deactivated_at = now();
        } elseif ($request->action === 'uninstall') {
            $user->status = PluginUser::UNINSTALL;
            $user->uninstalled_at = now();
        }

        $user->plugins = $plugins;
        $user->server = $server;
        $user->save();

        return response('ok', 200);
    } catch (Exception $exception) {
        Log::alert($request->all());
        Log::alert($exception->getMessage());
        Log::info($exception->getTrace()[0]);

        return response('error', 500);
    }

})->name('org.support');
