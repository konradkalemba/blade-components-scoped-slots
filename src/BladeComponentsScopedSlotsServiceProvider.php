<?php

namespace KonradKalemba\BladeComponentsScopedSlots;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentsScopedSlotsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('scopedslot', function ($expression) {
            // Split the expression by `top-level` commas (not in parentheses)
            $directiveArguments = preg_split("/,(?![^\(\(]*[\)\)])/", $expression);
            $directiveArguments = array_map('trim', $directiveArguments);

            // Ensure that the directive's arguments array has 3 elements - otherwise fill with `null`
            $directiveArguments = array_pad($directiveArguments, 3, null);

            // Extract values from the directive's arguments array
            [$name, $functionArguments, $functionUses] = $directiveArguments;

            // Connect the arguments to form a correct function declaration
            if ($functionArguments) $functionArguments = "function {$functionArguments}";

            $functionUses = array_filter(explode(',', trim($functionUses, '()')), 'strlen');

            // Add `$__env` and `$__bladeCompiler` to allow usage of other Blade directives inside the scoped slot
            array_push($functionUses, '$__env');
            array_push($functionUses, '$__bladeCompiler');

            $functionUses = implode(',', $functionUses);

            return "<?php \$__bladeCompiler = \$__bladeCompiler ?? null; \$__env->slot({$name}, {$functionArguments} use ({$functionUses}) { ?>";
        });

        Blade::directive('endscopedslot', function () {
            return "<?php }); ?>";
        });
    }
}
