<?php
// 代码生成时间: 2025-09-10 05:29:05
// theme_switcher.php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class ThemeSwitcherController extends Controller
{
    private $themes = ['light', 'dark', 'colorful'];

    // Function to switch themes
    public function switchTheme($theme)
    {
        // Check if the theme is valid
        if (!in_array($theme, $this->themes)) {
            // Redirect to the home page with an error message
            return Redirect::to('/')->withErrors('Invalid theme selected.')->withInput();
        }

        // Set the theme in the session
        Session::put('theme', $theme);

        // Redirect to the previous page or home page
        return Redirect::back();
    }

    // Function to get the active theme from session
    public function getCurrentTheme()
    {
        // Get the theme from the session, default to 'light' if not set
        $theme = Session::get('theme', 'light');

        // Return the active theme
        return $theme;
    }

    // Function to apply the theme to views
    public function applyTheme()
    {
        // Get the active theme
        $theme = $this->getCurrentTheme();

        // Set the active theme in the view
        View::share('theme', $theme);
    }
}
