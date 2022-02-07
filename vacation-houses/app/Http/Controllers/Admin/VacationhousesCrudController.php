<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VacationhousesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class VacationhousesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class VacationhousesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    private function getFieldsData($show = false) {
        return [
            [
                'name'=> 'name',
                'label' => 'Name',
                'type'=> 'text'
            ],
            [
                'name' => 'rooms',
                'label' => 'Rooms',
                'type' => 'select2_from_array',
                'options' => ['1' => 'One', '2' => 'Two', '3' => 'Three'],
                'allows_null' => true,
                'default' => '1',
            ],
            [
                'name' => 'beds',
                'label' => 'Beds',
                'type' => 'select2_from_array',
                'options' => ['1' => 'One', '2' => 'Two', '3' => 'Three'],
                'allows_null' => true,
                'default' => '1',
            ],
            [
                'label'     => "Populated Places",
                'type'      => ($show ? "select": 'select2_multiple'),
                'name'      => 'populatedPlace',
                'entity'    => 'populatedPlace',
                'model'     => "App\Models\Populatedplace",
                'attribute' => 'populated_place',
                'pivot'     => true,
            ],
            [
                'label'     => "Object Types",
                'type'      => ($show ? "select": 'select2_multiple'),
                'name'      => 'objectType',
                'entity'    => 'objectType',
                'model'     => "App\Models\Objecttype",
                'attribute' => 'type',
                'pivot'     => true,
            ]
        ];
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Vacationhouses::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/vacationhouses');
        CRUD::setEntityNameStrings('vacationhouses', 'vacationhouses');

        $this->crud->addFields($this->getFieldsData());
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('id');
        CRUD::column('name');
        CRUD::column('populatedPlace');
        CRUD::column('rooms');
        CRUD::column('beds');
        CRUD::column('objectType');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(VacationhousesRequest::class);

        CRUD::field('name');
        CRUD::field('rooms');
        CRUD::field('beds');
        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        // by default the Show operation will try to show all columns in the db table,
        // but we can easily take over, and have full control of what columns are shown,
        // by changing this config for the Show operation
        $this->crud->set('show.setFromDb', false);
        $this->crud->addColumns($this->getFieldsData(true));
    }
}
