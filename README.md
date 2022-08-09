## Laravel Backpack Select tree view

1. [Installation](#installation)
2. [Usage](#usage)

![Alt text](screenshots/screenshot.png?raw=true "screenshot")

### Installation

```
composer require izica/select-tree-view-for-backpack
```

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
        // in product view
        'options'           => CatalogCategory::get()->toArray(),
        // in category view, with preventing loops on itself
        'options'           => CatalogCategory::whereNot('id', $this->crud->getCurrentEntryId())->get()->toArray(),
   
        // OPTIONAL
        'options_parent_id' => 'catalog_category_id',   // using value from 'name' param by default
        'depth_prefix'      => '.  ',                   //default value
        'depth_max'         => 10,                      //default value
        'options_root_id'   => null,                    //default value
        'options_sort_by'   => 'name',                  //default value
        'option_name'       => 'name',                  //default value
        'allows_null'       => true,                    //default value
        'default'           => null,                    //default value
    ]);
}

```

To prevent loops you