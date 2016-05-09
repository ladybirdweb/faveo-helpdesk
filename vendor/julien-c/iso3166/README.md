iso3166
=======

ISO 3166-1 alpha-2 mapping:

Get Country Name:
```php
echo Iso3166\Codes::country('FR');
// 'France'
```

Get Phone Code:
```php
echo Iso3166\Codes::phoneCode('FR');
// '33'
```

Get Continent Name:
```php
echo Iso3166\Codes::continent('EU');
// 'Europa'
```

Plus one super handy helper:

```php
echo Iso3166\Codes::countrySelector('class', 'name', 'FR');
```

will output:

```html
<select class="class" name="name">
  <option value="AF">Afghanistan</option>
  ...
  <option value="FR" selected>France</option>
  ...
</select>
```
