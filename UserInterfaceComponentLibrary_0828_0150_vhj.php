<?php
// 代码生成时间: 2025-08-28 01:50:49
 * UserInterfaceComponentLibrary.php
 *
 * A Laravel-based library for managing user interface components.
 * This class provides a structured approach to creating and managing UI components.
 *
 * @author Your Name
 * @version 1.0
 * @package UserInterfaceComponentLibrary
 */

namespace App\Http\Libraries;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\View;

class UserInterfaceComponentLibrary extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'ui-component';
    }

    /**
     * Render a component by name.
     *
     * @param string $componentName The name of the component to render.
     * @param array $data Data to pass to the component.
     * @return string The rendered HTML of the component.
     * @throws \Exception If the component does not exist.
     */
    public static function render($componentName, $data = []) {
        // Check if the component exists in the view folder
        $viewPath = 'components.' . $componentName;
        if (!View::exists($viewPath)) {
            throw new \Exception("Component '{$componentName}' not found.");
        }

        // Pass data to the component and render it
        return View::make($viewPath, $data)->render();
    }
}
