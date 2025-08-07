<?php
// 代码生成时间: 2025-08-07 11:03:41
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/**
 * ThemeSwitcher Class
 * Handles theme switching functionality in the application.
 */
class ThemeSwitcher {

    /**
     * Switches the theme for the user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchTheme(Request $request) {
        // Ensure the theme is valid
        $theme = $request->input('theme');
        $validThemes = ['light', 'dark', 'colorful']; // Add more themes as needed

        if (!in_array($theme, $validThemes)) {
            return redirect()->back()->withErrors('Invalid theme selected.');
        }

        // Store the theme in session
        session(['theme' => $theme]);

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Theme switched to ' . $theme . ' successfully.');
    }

    /**
     * Returns the current theme.
     *
     * @return string
     */
    public function getCurrentTheme() {
        return session('theme', 'light'); // Default to 'light' theme if none is set
    }
}

// Define Routes
Route::post('/switch-theme', function (Request $request) {
    $themeSwitcher = new ThemeSwitcher();
    return $themeSwitcher->switchTheme($request);
});

// Middleware to apply theme
Route::middleware(['theme'])->group(function () {
    Route::get('/', function () {
        $themeSwitcher = new ThemeSwitcher();
        $theme = $themeSwitcher->getCurrentTheme();
        \View::share('theme', $theme);
        return view('welcome');
    });
});

/**
 * Middleware to set the theme
 */
class ThemeMiddleware {
    public function handle($request, \Closure $next) {
        $themeSwitcher = new ThemeSwitcher();
        $theme = $themeSwitcher->getCurrentTheme();
        \View::share('theme', $theme);
        return $next($request);
    }
}