protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return route('masuk'); // arahkan ke route login
    }
}