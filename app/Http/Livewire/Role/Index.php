<?php

declare(strict_types=1);

namespace App\Http\Livewire\Role;

use App\Http\Livewire\WithSorting;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\Datatable;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $role;

    public $permissions;

    /** @var string[] */
    public $listeners = ['createModal', 'editModal'];

    public $createModal = false;

    public $editModal = false;

    public array $listsForFields = [];

    /** @var string[][] */
    protected $queryString = [
        'search' => [
            'except' => '',
        ],
        'sortBy' => [
            'except' => 'id',
        ],
        'sortDirection' => [
            'except' => 'desc',
        ],
    ];

    protected function rules(): array
    {
        return [
            'role.name'        => 'required|string|max:255',
            'role.label'       => 'string|nullable|max:255',
            'role.guard_name'  => 'required|string|max:255',
            'role.description' => 'string|nullable|max:255',
            'role.status'      => 'string|nullable|max:255',
        ];
    }

    public function mount(): void
    {
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->perPage = 100;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new Role())->orderable;
        $this->permissions = $this->role->permissions->pluck('id')->toArray();
        $this->initListsForFields();
    }

    public function render()
    {
        $query = Role::with(['permissions'])->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $roles = $query->paginate($this->perPage);

        return view('livewire.role.index', compact('roles'));
    }

    public function createModal(Role $role)
    {
        abort_if(Gate::denies('role_create'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->role = $role;

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->role->save();

        $this->role->permissions()->sync($this->permissions);

        $this->createModal = false;

        $this->alert('success', __('Role created successfully.'));
    }

    public function editModal(Role $role)
    {
        abort_if(Gate::denies('role_edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->role = Role::find($role->id);

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->role->save();

        $this->role->permissions()->sync($this->permissions);

        $this->editModal = false;

        $this->alert('success', __('Role updated successfully.'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('role_delete'), 403);

        Role::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Role $role)
    {
        abort_if(Gate::denies('role_delete'), 403);

        $role->delete();
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['permissions'] = Permission::pluck('name', 'id')->toArray();
    }
}
