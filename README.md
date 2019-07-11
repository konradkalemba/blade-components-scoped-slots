# blade-components-scoped-slots
[![Latest Stable Version](https://poser.pugx.org/konradkalemba/blade-components-scoped-slots/v/stable)](https://packagist.org/packages/konradkalemba/blade-components-scoped-slots) [![Total Downloads](https://poser.pugx.org/konradkalemba/blade-components-scoped-slots/downloads)](https://packagist.org/packages/konradkalemba/blade-components-scoped-slots)

Scoped slots feature addition to Laravel's Blade templating engine. The package adds two new Blade directives: `@scopedslot` and `@endscopedslot`. Inspired by  [Vue's scoped slots feature](https://vuejs.org/v2/guide/components-slots.html#Scoped-Slots).

### Installation
```sh
composer require konradkalemba/blade-components-scoped-slots
```


### Usage example

*index.blade.php*
```php
@component('components.list', ['objects' => $objects])
    @scopedslot('item', ($object))
    // It is also possible to pass outside variable to the scoped slot
    // by using the third parameter: @scopedslot('item', ($object), ($variable))
        <li>
            {{ $object->name }} 
            @if($object->isEditable)
                <a href="{{ route('objects.edit', $object->id) }}">{{ __('Edit') }}</a>
            @endif
        </li>
    @endscopedslot
@endcomponent
```

*components/list.blade.php*
```php
<ul>
    @foreach($objects as $object)
        {{ $item($object) }}
    @endforeach
</ul>
```

### License
 [![License](https://poser.pugx.org/konradkalemba/blade-components-scoped-slots/license)](https://github.com/konradkalemba/blade-components-scoped-slots/blob/master/LICENSE)