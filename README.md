## Laravel Backpack Select tree view

1. [Installation](#installation)
2. [Documentation](#documentation)
3. [Usage](#usage)

![Alt text](screenshots/screenshot.png?raw=true "screenshot")

### Installation

```
composer require izica/select-tree-view-for-backpack
```

### Documentation

* relation_panel
    * `name` - name of relation
    * `label` - panel label
    * `backpack_crud` - backpack crud url,
    * `buttons` (optional) - set `false` to hide all action buttons
    * `button_show` (optional) - set `false` to hide
    * `button_edit` (optional) - set `false` to hide
    * `visible` (optional) - closure for hiding or showing panel
    * `fields` (optional) - fields array, by default get columns from `fillable` in model
        * `name` - name
        * `label` - for field
        * `closure` - use closure instead of name field,
        * `visible`(optional) - closure for hiding or showing panel

* relation_table
    * `name` - (required) name of relation
    * `label` - panel label
    * `relation_attribute` - (optional) used for passing url parameter name for button_create
    * `search` - (optional) `closure`, enables search input
    * `per_page` - (optional) enables pagination, `null` by default
    * `backpack_crud` - backpack crud url,
    * `buttons` (optional) - set `false` to hide all action buttons
    * `button_create` (optional) - set `false` to hide
    * `button_show` (optional) - set `false` to hide
    * `button_edit` (optional) - set `false` to hide
    * `button_delete` (optional) - set `false` to hide
    * `visible` (optional) - `closure` for hiding or showing panel
    * `columns` (optional) - columns `array`, by default get columns from `fillable` in model
        * `name` - name
        * `label` - for field
        * `closure` - use `closure` instead of name field for passing value,

### Usage

#### Table structure examples

```
catalog-category
- id
- name
- catalog_category_id
```

```
catalog-product
- id
- name
- catalog_category_id
```

#### Code

```php
protected function setupCreateOperation()
{
     CRUD::addField([
        'type'              => 'select_tree_view',
        'label'             => "Catalog category",
        'name'              => 'catalog_category_id',
        // with preventing loops on itself
        'options'           => CatalogCategory::whereNot('id', $this->crud->getCurrentEntryId())->get()->toArray(),
   
        // OPTIONAL
        'options_parent_id' => 'catalog_category_id',   // using value from 'name' param by default
        'depth_prefix'      => '.  ',                   //default value
        'depth_max'         => 10,                      //default value
        'options_root_id'   => null,                    //default value
        'options_sort_by'   => 'name',                  //default value
        'option_name'       => 'name',                  //default value
        'allows_null'       => true,                    //default value
        'default'           => null,                     //default value
    ]);
}

```

To prevent loops you