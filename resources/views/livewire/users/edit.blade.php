<?php

use Livewire\Volt\Component;
use App\Models\{User, Country, Language};
use Mary\Traits\Toast;
use Livewire\WithFileUploads; 
use Livewire\Attributes\Rule; 

new class extends Component {
    
    use Toast, WithFileUploads;

    public User $user;

    #[Rule('nullable|image|max:1024')] 
    public $photo;

    #[Rule('required')] 
    public string $name = '';
 
    #[Rule('required|email')]
    public string $email = '';

    #[Rule('required')]
    public string $password = '';
 
    #[Rule('sometimes')]
    public ?int $country_id = null;

    #[Rule('required')]
    public array $my_languages = [];

    #[Rule('sometimes')]
    public ?string $bio = null;

    public bool $showPassword = false;

    public function mount(): void
    {
        $this->fill($this->user);
        $this->my_languages = $this->user->languages->pluck('id')->all();
    }

    public function with(): array 
    {
        return [
            'countries' => Country::all(),
            'languages' => Language::all(),
        ];
    }
    
    public function save(): void
    {
        $data = $this->validate();
    
        $this->user->update($data);

        $this->user->languages()->sync($this->my_languages);

        if ($this->photo) { 
            $url = $this->photo->store('users', 'public');
            $this->user->update(['avatar' => "/storage/$url"]);
        }

        $this->success('User updated with success.', redirectTo: '/users');
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }
};

?>

<div>
    <x-header title="Update {{ $user->name }}" separator /> 
    <x-form wire:submit="save"> 
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Basic" subtitle="Basic info from user" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-file label="Avatar" wire:model="photo" accept="image/png, image/jpeg" crop-after-change> 
                    <img src="{{ $user->avatar ?? '/empty-user.jpg' }}" class="h-40 rounded-lg" />
                </x-file>
                <x-input label="Name" wire:model="name" />
                <x-input label="Email" wire:model="email" />
                <div class="relative">
                    <x-input 
                        label="Password" 
                        type="{{ $showPassword ? 'text' : 'password' }}" 
                        wire:model="password"
                    />
                    <button 
                        type="button" 
                        wire:click="togglePasswordVisibility" 
                        class="absolute right-2 top-[65%] transform -translate-y-1/2"
                    >
                        <x-icon name="{{ $showPassword ? 'o-eye-slash' : 'o-eye' }}" />
                    </button>
                </div>
                <x-select label="Country" wire:model="country_id" :options="$countries" placeholder="---" />
            </div>
        </div>
        <hr class="my-5" />
        <div class="lg:grid grid-cols-5">
            <div class="col-span-2">
                <x-header title="Details" subtitle="More about the user" size="text-2xl" />
            </div>
            <div class="col-span-3 grid gap-3">
                <x-choices-offline
                    label="My languages"
                    wire:model="my_languages"
                    :options="$languages"
                    searchable />
                <x-editor wire:model="bio" label="Bio" hint="The great biography" /> 
            </div>
        </div>
        <x-slot:actions>
            <x-button label="Cancel" link="/users" />
            <x-button label="Save" icon="o-paper-airplane" spinner="save" type="submit" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
