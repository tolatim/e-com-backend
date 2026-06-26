public function handle($request, Closure $next, ...$guards)
{
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            if ($request->is('admin/login')) {
                return redirect()->route('admin.dashboard');
            }

            return redirect('/');
        }
    }

    return $next($request);
}